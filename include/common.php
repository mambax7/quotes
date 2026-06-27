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

use Xmf\Module\Admin;
use XoopsModules\Quotes\Helper;
use XoopsModules\Quotes\Utility;

/** @var Admin $adminObject */
/** @var Utility $utility */
/** @var Helper $helper */
require \dirname(__DIR__) . '/bootstrap.php';

$moduleDirName      = \basename(\dirname(__DIR__));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

/** @var \XoopsDatabase $db */
$db      = \XoopsDatabaseFactory::getDatabaseConnection();
$helper  = Helper::getInstance();
$utility = new Utility();
//$configurator = new \XoopsModules\Mtools\Common\Configurator($helper->path());

$helper->loadLanguage('common');

//handlers/** @var \XoopsPersistableObjectHandler $quoteHandler */
$quoteHandler = $helper->getHandler('Quote');
/** @var \XoopsPersistableObjectHandler $categoryHandler */
$categoryHandler = $helper->getHandler('Category');
/** @var \XoopsPersistableObjectHandler $authorHandler */
$authorHandler = $helper->getHandler('Author');

$pathIcon16 = Admin::iconUrl('', '16');
$pathIcon32 = Admin::iconUrl('', '32');
//$pathModIcon16 = $helper->getConfig('modicons16');
//$pathModIcon32 = $helper->getConfig('modicons32');

// Standard {UP}_* path/URL constants from the shared, helper-backed module context
// (replaces the hand-built XOOPS_URL/XOOPS_ROOT_PATH concatenation block).
$context = \XoopsModules\Mtools\Module\ModuleContext::fromHelper($helper);
$context->defineConstants();

// Module-specific constants not covered by the standard set.
if (!defined($moduleDirNameUpper . '_CAT_IMAGES_URL')) {
    define($moduleDirNameUpper . '_CAT_IMAGES_URL', $context->uploadUrl('category'));
    define($moduleDirNameUpper . '_CAT_IMAGES_PATH', $context->uploadPath('category'));
    define($moduleDirNameUpper . '_AUTHOR_LOGOIMG', $pathIcon32 . '/xoopsmicrobutton.gif');
    define($moduleDirNameUpper . '_CONSTANTS_DEFINED', 1);
}

//define option du module
//define($moduleDirNameUpper. '_DISPLAY_CAT', $helper->getConfig('$mod_name_cat_display', 'none'));

//require \dirname(__DIR__) . '/include/seo_functions.php';
//require \dirname(__DIR__) . '/class/PageNav.php';

//require XOOPS_ROOT_PATH . '/class/tree.php';

//require \dirname(__DIR__) . '/class/Tree.php';
//require \dirname(__DIR__) . '/class/FormSelect.php';

// Load only if module is installed
//if (is_object($helper->getModule())) {
//    // Find if the user is admin of the module
//    $publisherIsAdmin = publisher\Utility::userIsAdmin();
//    // get current page
//    $publisherCurrentPage = publisher\Utility::getCurrentPage();
//}

$icons = [
    'edit'    => "<img src='" . $pathIcon16 . "/edit.png'  alt=" . _EDIT . "' align='middle'>",
    'delete'  => "<img src='" . $pathIcon16 . "/delete.png' alt='" . _DELETE . "' align='middle'>",
    'clone'   => "<img src='" . $pathIcon16 . "/editcopy.png' alt='" . _CLONE . "' align='middle'>",
    'preview' => "<img src='" . $pathIcon16 . "/view.png' alt='" . _PREVIEW . "' align='middle'>",
    'print'   => "<img src='" . $pathIcon16 . "/printer.png' alt='" . _CLONE . "' align='middle'>",
    'pdf'     => "<img src='" . $pathIcon16 . "/pdf.png' alt='" . _CLONE . "' align='middle'>",
    'add'     => "<img src='" . $pathIcon16 . "/add.png' alt='" . _ADD . "' align='middle'>",
    '0'       => "<img src='" . $pathIcon16 . "/0.png' alt='" . 0 . "' align='middle'>",
    '1'       => "<img src='" . $pathIcon16 . "/1.png' alt='" . 1 . "' align='middle'>",
];

$debug = false;

// MyTextSanitizer object
$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof \XoopsTpl)) {
    require_once $GLOBALS['xoops']->path('class/template.php');
    $GLOBALS['xoopsTpl'] = new \XoopsTpl();
}

$GLOBALS['xoopsTpl']->assign('mod_url', $helper->url());
// Local icons path
if (is_object($helper->getModule())) {
    $pathModIcon16 = $helper->getModule()->getInfo('modicons16');
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');

    $GLOBALS['xoopsTpl']->assign('pathModIcon16', \Xoops\Helpers\Service\Url::module($moduleDirName, (string)$pathModIcon16));
    $GLOBALS['xoopsTpl']->assign('pathModIcon32', $pathModIcon32);
}

if (!\function_exists('quotes_render_rich_text')) {
function quotes_render_rich_text(string $text): string
{
    $text = \trim($text);
    if ('' === $text) {
        return '';
    }
    $text = \preg_replace(
        '/<p\b([^>]*)>\s*(?:&nbsp;|&amp;nbsp;|&#160;|&amp;#160;|&#xA0;|&#xa0;|&amp;#xA0;|&amp;#xa0;|\xC2\xA0|\s)*<\/p>/iu',
        '<p><br></p>',
        $text
    ) ?? $text;
    $text = \str_replace(
        ["\xC2\xA0", '&nbsp;', '&amp;nbsp;', '&#160;', '&amp;#160;', '&#xA0;', '&#xa0;', '&amp;#xA0;', '&amp;#xa0;'],
        ' ',
        $text
    );

    if (!\class_exists(\HTMLPurifier::class) && \defined('XOOPS_TRUST_PATH')) {
        $purifierAutoloader = \XOOPS_TRUST_PATH . '/vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php';
        if (\is_file($purifierAutoloader)) {
            require_once $purifierAutoloader;
        }
    }

    if (\class_exists(\HTMLPurifier::class) && \class_exists(\HTMLPurifier_Config::class)) {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set(
            'HTML.Allowed',
            'p,br,strong,b,em,i,u,s,blockquote,span[class|style],div[class|style],ul,ol,li,a[href|title|target|rel]'
        );
        $config->set('CSS.AllowedProperties', ['color', 'background-color', 'font-weight', 'font-style', 'text-decoration', 'text-align']);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('Cache.DefinitionImpl', null);

        return (new \HTMLPurifier($config))->purify($text);
    }

    $myts = \MyTextSanitizer::getInstance();

    return $myts->displayTarea($text, 1, 1, 1, 1, 0);
}
}

xoops_loadLanguage('main', $moduleDirName);
if (class_exists('D3LanguageManager')) {
    require_once XOOPS_TRUST_PATH . '/libs/altsys/class/D3LanguageManager.class.php';
    $langman = D3LanguageManager::getInstance();
    $langman->read('main.php', $moduleDirName);
}
