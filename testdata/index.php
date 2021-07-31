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

use Xmf\Request;
use XoopsModules\Quotes\{Helper,
    Utility
};
use XoopsModules\Mtools\Common\TestdataSample;

/** @var Helper $helper */

require dirname(__DIR__, 3) . '/include/cp_header.php';
require dirname(__DIR__) . '/preloads/autoloader.php';

$op = Request::getCmd('op', '');

$helper = Helper::getInstance();
$moduleDirNameUpper =  mb_strtoupper($helper->getDirname());
// Load language files
$helper->loadLanguage('common');
$testdataSample = new TestdataSample($helper);

switch ($op) {
    case 'load':
        if (Request::hasVar('ok', 'REQUEST') && 1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($helper->url('admin/index.php'), 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $testdataSample->loadData();
        } else {
            xoops_cp_header();
            xoops_confirm(['ok' => 1, 'op' => 'load'], 'index.php', constant('CO_' . $moduleDirNameUpper . '_' . 'LOAD_SAMPLEDATA_CONFIRM'), constant('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM'), true);
            xoops_cp_footer();
        }
        break;
    case 'save':
        $testdataSample->saveData();
        break;
    case 'clear':
        if (Request::hasVar('ok', 'REQUEST') && 1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($helper->url('admin/index.php'), 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $testdataSample->clearData();
        } else {
            xoops_cp_header();
            xoops_confirm(['ok' => 1, 'op' => 'clear'], 'index.php', constant('CO_' . $moduleDirNameUpper . '_' . 'CLEAR_SAMPLEDATA_CONFIRM'), constant('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM'), true);
            xoops_cp_footer();
        }
        break;
    case 'exportschema':
//        $testdataSample->exportShema();
        break;
}
