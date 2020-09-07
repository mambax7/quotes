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
use XoopsModules\Mtools;
use XoopsModules\Quotes\{Helper,
    Utility
};

/** @var Admin $adminObject */
/** @var Helper $helper */
/** @var Utility $utility */

require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require dirname(dirname(dirname(__DIR__))) . '/class/xoopsformloader.php';

require dirname(__DIR__) . '/include/common.php';

require dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName = basename(dirname(__DIR__));

$helper      = Helper::getInstance();
$utility     = new Utility();
$adminObject = Admin::getInstance();

$db = \XoopsDatabaseFactory::getDatabaseConnection();

$pathIcon16    = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32    = \Xmf\Module\Admin::iconUrl('', 32);
$pathModIcon32 = $helper->getConfig('modicons32');

/** @var \XoopsPersistableObjectHandler $quoteHandler */
$quoteHandler = $helper->getHandler('Quote');
/** @var \XoopsPersistableObjectHandler $categoryHandler */
$categoryHandler = $helper->getHandler('Category');
/** @var \XoopsPersistableObjectHandler $authorHandler */
$authorHandler = $helper->getHandler('Author');

$myts = \MyTextSanitizer::getInstance();
if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    require XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new \XoopsTpl();
}

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('common');

//xoops_cp_header();