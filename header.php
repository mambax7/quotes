<?php declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Module: Quotes
 *
 * @category        Module
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       2000-2026 XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use XoopsModules\Mtools;
use XoopsModules\Quotes\Helper;
use XoopsModules\Quotes\Utility;

/** @var Utility $utility */
/** @var Helper $helper */
require_once \dirname(__DIR__, 2) . '/mainfile.php';

//require XOOPS_ROOT_PATH . '/header.php';

require __DIR__ . '/bootstrap.php';

$mtoolsDependencyError = quotes_mtools_dependency_error();
if ('' !== $mtoolsDependencyError) {
    redirect_header(XOOPS_URL, 3, $mtoolsDependencyError);
    exit;
}

require __DIR__ . '/include/common.php';
$moduleDirName = basename(__DIR__);

quotes_ensure_core_config_defaults();

$helper       = Helper::getInstance();
$utility      = new Utility();
$configurator = Mtools\Common\Configurator::forModule($helper);
$copyright    = $configurator->modCopyright;

$modulePath = XOOPS_ROOT_PATH . '/modules/' . $moduleDirName;
$db         = \XoopsDatabaseFactory::getDatabaseConnection();

$myts = \MyTextSanitizer::getInstance();

$GLOBALS['xoopsTpl']->assign('commentsnav', '');
$GLOBALS['xoopsTpl']->assign('lang_notice', '');
$GLOBALS['xoopsTpl']->assign('comment_mode', '');

$stylesheet = "modules/{$moduleDirName}/assets/css/style.css";
/** @var \XoopsPersistableObjectHandler $quoteHandler */
$quoteHandler = $helper->getHandler('Quote');
/** @var \XoopsPersistableObjectHandler $categoryHandler */
$categoryHandler = $helper->getHandler('Category');
/** @var \XoopsPersistableObjectHandler $authorHandler */
$authorHandler = $helper->getHandler('Author');

// Load language files
$helper->loadLanguage('blocks');
$helper->loadLanguage('common');
$helper->loadLanguage('main');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('admin');

/**
 * Whether the current user may add/edit quotes content from the frontend.
 *
 * Uses XMF's Permission helper, which resolves the current user's groups, the module
 * id, and the admin short-circuit itself. True for module admins, and for any group
 * the admin granted the global "Submit from user side" right (`quotes_ac` item 8) on
 * admin/permissions.php.
 */
function quotes_user_can_submit(): bool
{
    static $permission;
    if (null === $permission) {
        // No argument => current module (quotes), per Xmf\Module\Helper\AbstractHelper.
        $permission = new \Xmf\Module\Helper\Permission();
    }

    return $permission->checkPermission('quotes_ac', 8);
}

/**
 * Whether the current user may add/edit a quote in a specific category.
 *
 * Uses the PER-CATEGORY "Permissions to submit" right (`quotes_submit`, item id =
 * category id) managed on admin/permissions.php and the category form. Admin-aware
 * (admins always pass). Result is memoised per category id for list pages.
 */
function quotes_user_can_submit_to_category(int $cid): bool
{
    static $permission;
    static $cache = [];

    if (\array_key_exists($cid, $cache)) {
        return $cache[$cid];
    }
    if (null === $permission) {
        $permission = new \Xmf\Module\Helper\Permission();
    }

    return $cache[$cid] = $permission->checkPermission('quotes_submit', $cid);
}

/**
 * Current front-end user id, or 0 for anonymous.
 */
function quotes_current_uid(): int
{
    return ($GLOBALS['xoopsUser'] instanceof \XoopsUser) ? (int)$GLOBALS['xoopsUser']->getVar('uid') : 0;
}

/**
 * Whether the current user is a module admin (admins edit everything).
 */
function quotes_is_admin(): bool
{
    return Helper::getInstance()->isUserAdmin();
}

/**
 * Whether the current user holds the global "Can edit own posts" right (quotes_ac item 32).
 * Admin-aware via XMF (admins always pass), but ownership is still required for non-admins.
 */
function quotes_user_can_edit_own(): bool
{
    static $permission;
    if (null === $permission) {
        $permission = new \Xmf\Module\Helper\Permission();
    }

    return $permission->checkPermission('quotes_ac', 32);
}

/**
 * May the current user edit this quote? Admin OR (owner AND has the edit-own right).
 */
function quotes_user_can_edit_quote($quoteObject): bool
{
    if (!\is_object($quoteObject)) {
        return false;
    }

    return \XoopsModules\Quotes\EditPermission::canEdit(
        quotes_is_admin(),
        quotes_current_uid(),
        (int)$quoteObject->getVar('uid'),
        quotes_user_can_edit_own()
    );
}

/**
 * May the current user edit this author? Admin OR (owner AND has the edit-own right).
 */
function quotes_user_can_edit_author($authorObject): bool
{
    if (!\is_object($authorObject)) {
        return false;
    }

    return \XoopsModules\Quotes\EditPermission::canEdit(
        quotes_is_admin(),
        quotes_current_uid(),
        (int)$authorObject->getVar('uid'),
        quotes_user_can_edit_own()
    );
}

function quotes_ensure_core_config_defaults(): void
{
    global $xoopsConfig;

    if (!\is_array($xoopsConfig)) {
        $xoopsConfig = [];
    }

    $defaultTheme = \is_dir(\XOOPS_ROOT_PATH . '/themes/xbootstrap5') ? 'xbootstrap5' : 'default';
    $xoopsConfig += [
        'language'          => 'english',
        'debug_mode'        => 0,
        'theme_set'         => $defaultTheme,
        'theme_set_allowed' => [$defaultTheme],
        'template_set'      => 'default',
        'module_cache'      => [],
        'sitename'          => 'XOOPS',
        'slogan'            => '',
        'banners'           => 0,
        'startpage'         => '--',
        'default_TZ'        => '0.0',
        'server_TZ'         => '0.0',
        'use_ssl'           => 0,
        'usercookie'        => '',
        'anonymous'         => 'Anonymous',
        'adminmail'         => '',
        'from'              => '',
        'mailmethod'        => 'mail',
        'sendmailpath'      => '/usr/sbin/sendmail',
        'smtphost'          => [],
    ];

    if (!\is_array($xoopsConfig['theme_set_allowed'])) {
        $xoopsConfig['theme_set_allowed'] = [$xoopsConfig['theme_set']];
    }
    if (!\is_array($xoopsConfig['module_cache'])) {
        $xoopsConfig['module_cache'] = [];
    }
    if (!\is_array($xoopsConfig['smtphost'])) {
        $xoopsConfig['smtphost'] = [];
    }

    $GLOBALS['xoopsConfig'] = $xoopsConfig;
}

function quotes_register_theme_assets(string $stylesheet): void
{
    global $xoTheme;

    if (\is_object($xoTheme) && \file_exists($GLOBALS['xoops']->path($stylesheet))) {
        $stylesheetPath = $GLOBALS['xoops']->path($stylesheet);
        $stylesheetUrl  = $GLOBALS['xoops']->url("www/{$stylesheet}") . '?v=' . (string)\filemtime($stylesheetPath);
        $xoTheme->addStylesheet($stylesheetUrl);
    }

    if (isset($GLOBALS['xoopsTpl']) && $GLOBALS['xoopsTpl'] instanceof \XoopsTpl) {
        $GLOBALS['xoopsTpl']->assign('xoops_meta_robots', $GLOBALS['xoopsTpl']->getTemplateVars('xoops_meta_robots') ?: 'index,follow');
        $GLOBALS['xoopsTpl']->assign('xoops_meta_rating', $GLOBALS['xoopsTpl']->getTemplateVars('xoops_meta_rating') ?: 'general');
        $GLOBALS['xoopsTpl']->assign('xoops_meta_author', $GLOBALS['xoopsTpl']->getTemplateVars('xoops_meta_author') ?: 'XOOPS');
        $GLOBALS['xoopsTpl']->assign('xoops_meta_copyright', $GLOBALS['xoopsTpl']->getTemplateVars('xoops_meta_copyright') ?: '');
        $GLOBALS['xoopsTpl']->assign('xoops_meta_description', $GLOBALS['xoopsTpl']->getTemplateVars('xoops_meta_description') ?: '');
        $GLOBALS['xoopsTpl']->assign('xoops_meta_keywords', $GLOBALS['xoopsTpl']->getTemplateVars('xoops_meta_keywords') ?: '');
    }
}
