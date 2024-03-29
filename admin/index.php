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

use Xmf\Module\Admin;
use Xmf\Request;
use Xmf\Yaml;
use XoopsModules\Mtools\{
    Common,
    Common\Configurator,
    Common\TestdataButtons, //    Helper,
    //    Utility
};
use XoopsModules\Quotes\{
    Helper,
    Utility
};

/** @var Admin $adminObject */
/** @var Helper $helper */
/** @var Utility $utility */

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
//count "total Quote"
/** @var \XoopsPersistableObjectHandler $quoteHandler */
$totalQuote = $quoteHandler->getCount();
//count "total Category"
/** @var \XoopsPersistableObjectHandler $categoryHandler */
$totalCategory = $categoryHandler->getCount();
//count "total Author"
$totalAuthor = $authorHandler->getCount();
// InfoBox Statistics
$adminObject->addInfoBox(AM_QUOTES_STATISTICS);

// InfoBox quote
$adminObject->addInfoBoxLine(sprintf(AM_QUOTES_THEREARE_QUOTE, $totalQuote));

// InfoBox category
$adminObject->addInfoBoxLine(sprintf(AM_QUOTES_THEREARE_CATEGORY, $totalCategory));

// InfoBox author
$adminObject->addInfoBoxLine(sprintf(AM_QUOTES_THEREARE_AUTHOR, $totalAuthor));

//------ check Upload Folders ---------------
$adminObject->addConfigBoxLine('');
$redirectFile = $_SERVER['SCRIPT_NAME'];

$configurator  = new Configurator($helper->path());
$uploadFolders = $configurator->uploadFolders;

foreach (array_keys($uploadFolders) as $i) {
    $adminObject->addConfigBoxLine(Common\DirectoryChecker::getDirectoryStatus($uploadFolders[$i], 0777, $redirectFile));
}

// Render Index
$adminObject->displayNavigation(basename(__FILE__));

//check for latest release
//$newRelease = $utility->checkVerModule($helper);
//if (!empty($newRelease)) {
//    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
//}

//------------- Test Data Buttons ----------------------------
if ($helper->getConfig('displaySampleButton')) {
    TestdataButtons::loadButtonConfig($adminObject, $helper);
    $adminObject->displayButton('left', '');
}
$op = Request::getString('op', 0, 'GET');
switch ($op) {
    case 'hide_buttons':
        TestdataButtons::hideButtons($helper);
        break;
    case 'show_buttons':
        TestdataButtons::showButtons($helper);
        break;
}
//------------- End Test Data Buttons ----------------------------

$adminObject->displayIndex();
echo $utility::getServerStats();

//codeDump(__FILE__);
require_once __DIR__ . '/admin_footer.php';
