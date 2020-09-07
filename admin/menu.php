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
use XoopsModules\Quotes;
use XoopsModules\Quotes\Helper;

require dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

/** @var Helper $helper */
$helper = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

// get path to icons
$pathIcon32 = Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    $pathModIcon32 = $helper->getConfig('modicons32');
}

$adminObject = Admin::getInstance();

$adminmenu[] = [
    'title' => MI_QUOTES_ADMENU1,
    'link'  => 'admin/index.php',
    'icon'  => "{$pathIcon32}/home.png",
];

$adminmenu[] = [
    'title' => MI_QUOTES_ADMENU2,
    'link'  => 'admin/quote.php',
    'icon'  => "{$pathIcon32}/insert_table_row.png",
];

$adminmenu[] = [
    'title' => MI_QUOTES_ADMENU3,
    'link'  => 'admin/category.php',
    'icon'  => "{$pathIcon32}/category.png",
];

$adminmenu[] = [
    'title' => MI_QUOTES_ADMENU4,
    'link'  => 'admin/author.php',
    'icon'  => "{$pathIcon32}/user-icon.png",
];

$adminmenu[] = [
    'title' => MI_QUOTES_ADMENU8,
    'link'  => 'admin/permissions.php',
    'icon'  => "{$pathIcon32}/permissions.png",
];

$adminmenu[] = [
    'title' => MI_QUOTES_ADMENU5,
    'link'  => 'admin/feedback.php',
    'icon'  => "{$pathIcon32}/mail_foward.png",
];

$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link'  => 'admin/blocksadmin.php',
    'icon'  => "{$pathIcon32}/block.png",
];

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => MI_QUOTES_ADMENU6,
        'link'  => 'admin/migrate.php',
        'icon'  => "{$pathIcon32}/database_go.png",
    ];
}

$adminmenu[] = [
    'title' => MI_QUOTES_ADMENU7,
    'link'  => 'admin/about.php',
    'icon'  => "{$pathIcon32}/about.png",
];
