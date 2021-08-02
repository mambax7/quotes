<?php

declare(strict_types=1);

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
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GPL 2.0 or later
 */

use XoopsModules\Quotes\{
    Helper,
    Utility
};
use XoopsModules\Mtools;

/** @var Utility $utility */
/** @var Helper $helper */

require_once \dirname(__DIR__, 2) . '/mainfile.php';

//require XOOPS_ROOT_PATH . '/header.php';

require __DIR__ . '/preloads/autoloader.php';
require __DIR__ . '/include/common.php';
$moduleDirName = basename(__DIR__);

$helper       = Helper::getInstance();
$utility      = new Utility();
$configurator = new Mtools\Common\Configurator($helper->path());
$copyright    = $configurator->modCopyright;

$modulePath = XOOPS_ROOT_PATH . '/modules/' . $moduleDirName;
$db         = \XoopsDatabaseFactory::getDatabaseConnection();

$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoTheme']) || !is_object($GLOBALS['xoTheme'])) {
    require $GLOBALS['xoops']->path('class/theme.php');
    $GLOBALS['xoTheme'] = new \xos_opal_Theme();
}

$stylesheet = "modules/{$moduleDirName}/assets/css/style.css";
if (file_exists($GLOBALS['xoops']->path($stylesheet))) {
    $GLOBALS['xoTheme']->addStylesheet($GLOBALS['xoops']->url("www/{$stylesheet}"));
}
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
