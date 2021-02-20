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
use XoopsModules\Mtools\Common\SampleData;

/** @var Helper $helper */

require_once dirname(__DIR__, 3) . '/include/cp_header.php';
require dirname(__DIR__) . '/preloads/autoloader.php';

$op = Request::getCmd('op', '');

$helper = Helper::getInstance();
// Load language files
$helper->loadLanguage('common');
$sampleData = new SampleData($helper);

switch ($op) {
    case 'load':
        $sampleData->loadData();
        break;
    case 'save':
        $sampleData->saveData();
        break;
    case 'clear':
        $sampleData->clearData();
        break;
//    case 'exportschema':
//        $sampleData->exportShema();
//        break;
}


