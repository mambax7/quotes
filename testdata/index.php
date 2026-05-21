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
 * Module: Quote
 *
 * @category        Module
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use Xmf\Database\TableLoad;
use Xmf\Request;
use Xmf\Yaml;
use XoopsModules\Quote\Common\Configurator;
use XoopsModules\Quote\Helper;
use XoopsModules\Quote\Utility;

/** @var Helper $helper */
/** @var Utility $utility */
/** @var Configurator $configurator */
require \dirname(__DIR__, 3) . '/include/cp_header.php';
require \dirname(__DIR__) . '/preloads/autoloader.php';

$op = Request::getCmd('op', '');

$moduleDirName      = \basename(\dirname(__DIR__));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

$helper = Helper::getInstance();
// Load language files
$helper->loadLanguage('common');

switch ($op) {
    case 'load':
        if (Request::hasVar('ok', 'REQUEST') && 1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($helper->url('admin/index.php'), 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            loadSampleData();
        } else {
            xoops_cp_header();
            xoops_confirm(['ok' => 1, 'op' => 'load'], 'index.php', constant('CO_' . $moduleDirNameUpper . '_' . 'LOAD_SAMPLEDATA_CONFIRM'), constant('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM'));
            xoops_cp_footer();
        }
        break;
    case 'save':
        saveSampleData();
    // no break
    case 'clear':
        if (Request::hasVar('ok', 'REQUEST') && 1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($helper->url('admin/index.php'), 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            clearSampleData();
        } else {
            xoops_cp_header();
            xoops_confirm(['ok' => 1, 'op' => 'clear'], 'index.php', sprintf(constant('CO_' . $moduleDirNameUpper . '_' . 'CLEAR_SAMPLEDATA')), constant('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM'));
            xoops_cp_footer();
        }
        break;
}

// XMF TableLoad for SAMPLE data

function loadSampleData(): void
{
    global $xoopsConfig;

    $moduleDirName      = \basename(\dirname(__DIR__));
    $moduleDirNameUpper = \mb_strtoupper($moduleDirName);

    $utility      = new Utility();
    $configurator = new Configurator();
    $helper       = Helper::getInstance();

    //        $tables = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getInfo('tables');
    $tables = $helper->getModule()->getInfo('tables');

    $language = 'english/';
    if (is_dir(__DIR__ . '/' . $xoopsConfig['language'])) {
        $language = $xoopsConfig['language'] . '/';
    }

    // load module tables
    foreach ($tables as $table) {
        $tabledata = \Xmf\Yaml::readWrapped($language . $table . '.yml');
        if (is_array($tabledata)) {
            \Xmf\Database\TableLoad::truncateTable($table);
            \Xmf\Database\TableLoad::loadTableFromArray($table, $tabledata);
        }
    }

    // load permissions
    $table     = 'group_permission';
    $tabledata = \Xmf\Yaml::readWrapped($language . $table . '.yml');
    $mid       = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid');
    loadTableFromArrayWithReplace($table, $tabledata, 'gperm_modid', $mid);

    // load blocks
    $table     = 'newblocks';
    $tabledata = \Xmf\Yaml::readWrapped($language . $table . '.yml');
    $mid       = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid');
    loadTableFromArrayWithReplace($table, $tabledata, 'mid', $mid);

    // load config
    $table     = 'config';
    $tabledata = \Xmf\Yaml::readWrapped($language . $table . '.yml');
    $mid       = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid');
    loadTableFromArrayWithReplace($table, $tabledata, 'conf_modid', $mid);

    //load configoptions
    $table       = 'configoption';
    $tabledata   = \Xmf\Yaml::readWrapped($language . $table . '.yml');
    $configTable = 'config';
    $configdata  = \Xmf\Yaml::readWrapped($language . $configTable . '.yml');
    $mid         = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid');

    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('conf_modid', \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid')));

    $updatedConfidata = \Xmf\Database\TableLoad::extractRows($configTable, $criteria, $skipColumns);

    loadConfigoptionsFromYamlFile($table, $tabledata, 'conf_modid');

    //  ---  COPY test folder files ---------------
    if (is_array($configurator->copyTestFolders) && count($configurator->copyTestFolders) > 0) {
        //        $file = \dirname(__DIR__) . '/testdata/images/';
        foreach (array_keys($configurator->copyTestFolders) as $i) {
            $src  = $configurator->copyTestFolders[$i][0];
            $dest = $configurator->copyTestFolders[$i][1];
            $utility::rcopy($src, $dest);
        }
    }
    redirect_header($helper->url('admin/index.php'), 1, constant('CO_' . $moduleDirNameUpper . '_' . 'LOAD_SAMPLEDATA_SUCCESS'));
}

function saveSampleData(): void
{
    global $xoopsConfig;

    $moduleDirName      = \basename(\dirname(__DIR__));
    $moduleDirNameUpper = \mb_strtoupper($moduleDirName);
    $helper             = Helper::getInstance();
    $skipColumns        = [];
    $mid                = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid');

    //    $tables = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getInfo('tables');
    $tables = $helper->getModule()->getInfo('tables');

    $language = 'english/';
    if (is_dir(__DIR__ . '/' . $xoopsConfig['language'])) {
        $language = $xoopsConfig['language'] . '/';
    }

    $languageFolder = __DIR__ . '/' . $language;
    if (!file_exists($languageFolder . '/')) {
        Utility::createFolder($languageFolder . '/');
    }

    $exportFolder = $languageFolder . '/Exports-' . date('Y-m-d-H-i-s') . '/';
    Utility::createFolder($exportFolder);

    // save module tables
    foreach ($tables as $table) {
        \Xmf\Database\TableLoad::saveTableToYamlFile($table, $exportFolder . $table . '.yml');
    }

    // save permissions
    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('gperm_modid', \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid')));
    $skipColumns[] = 'gperm_id';
    \Xmf\Database\TableLoad::saveTableToYamlFile('group_permission', $exportFolder . 'group_permission.yml', $criteria, $skipColumns);
    unset($criteria);

    // save blocks
    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('mid', \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid')));
    $skipColumns[] = 'bid';
    \Xmf\Database\TableLoad::saveTableToYamlFile('newblocks', $exportFolder . 'newblocks.yml', $criteria, $skipColumns);
    unset($criteria);

    // save block_module_link
    //    $criteria = new \CriteriaCompo();
    //    $criteria->add(new \Criteria('module_id', \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid')));
    //    $skipColumns[] = 'block_id';
    //    \Xmf\Database\TableLoad::saveTableToYamlFile('block_module_link', $exportFolder . 'block_module_link.yml', $criteria, $skipColumns);
    //    unset($criteria);

    // save config
    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('conf_modid', \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid')));
    $skipColumns[] = 'conf_modid';
    \Xmf\Database\TableLoad::saveTableToYamlFile('config', $exportFolder . 'config.yml', $criteria, $skipColumns);
    unset($criteria);

    // save configoption
    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('conf_modid', \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid')));

    $rows          = getConfigoption($mid);
    $skipColumns[] = 'confop_id';
    saveArrayToYamlFile($rows, $exportFolder . 'configoption.yml');
    unset($criteria);

    //========================
    // save config WITH configoption
    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('conf_modid', $mid));

    $table = 'config';
    $rows  = \Xmf\Database\TableLoad::extractRows($table, $criteria, $skipColumns);

    $optionRows = getConfigAndOptions($mid, $rows);

    $criteria->add(new \Criteria('confop_id', $mid));
    $skipColumns[] = 'confop_id';
    saveArrayToYamlFile($optionRows, $exportFolder . 'configoption.yml');
    unset($criteria);

    redirect_header($helper->url('admin/index.php'), 1, constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA_SUCCESS'));
}

function exportSchema(): void
{
    $moduleDirName      = \basename(\dirname(__DIR__));
    $moduleDirNameUpper = \mb_strtoupper($moduleDirName);
    $helper             = Helper::getInstance();

    try {
        // TODO set exportSchema
        //        $migrate = new Migrate($moduleDirName);
        //        $migrate->saveCurrentSchema();
        //
        //        redirect_header($helper->url('admin/index.php'), 1, constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_SUCCESS'));
    } catch (\Throwable) {
        exit(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_ERROR'));
    }
}

/**
 * loadTableFromArrayWithReplace
 *
 * @param string $table  value which should be used instead of original value of $search
 *
 * @param array  $data   array of rows to insert
 *                       Each element of the outer array represents a single table row.
 *                       Each row is an associative array in 'column' => 'value' format.
 * @param string $search name of column for which the value should be replaced
 * @param int $mid
 * @return int number of rows inserted
 */
function loadTableFromArrayWithReplace(string $table, array $data, string $search, int $mid): int
{
    /** @var \XoopsMySQLDatabase $db */
    $db = \XoopsDatabaseFactory::getDatabaseConnection();

    $prefixedTable = $db->prefix($table);
    $count         = 0;

    $sql = 'DELETE FROM ' . $prefixedTable . ' WHERE `' . $search . '`=' . $db->quote((string)$mid);

    $db->exec($sql);

    foreach ($data as $row) {
        $insertInto  = 'INSERT INTO ' . $prefixedTable . ' (';
        $valueClause = ' VALUES (';
        $first       = true;
        foreach ($row as $column => $value) {
            if ($first) {
                $first = false;
            } else {
                $insertInto  .= ', ';
                $valueClause .= ', ';
            }

            $insertInto .= $column;
            if ($search === $column) {
                $valueClause .= $db->quote((string)$mid);
            } else {
                $valueClause .= $db->quote($value);
            }
        }

        $sql = $insertInto . ') ' . $valueClause . ')';

        if ($db->exec($sql)) {
            ++$count;
        }
    }

    return $count;
}

function clearSampleData(): void
{
    $moduleDirName      = \basename(\dirname(__DIR__));
    $moduleDirNameUpper = \mb_strtoupper($moduleDirName);
    $helper             = Helper::getInstance();
    // Load language files
    $helper->loadLanguage('common');
    $tables = $helper->getModule()->getInfo('tables');
    // truncate module tables
    foreach ($tables as $table) {
        \Xmf\Database\TableLoad::truncateTable($table);
    }
    redirect_header($helper->url('admin/index.php'), 1, constant('CO_' . $moduleDirNameUpper . '_' . 'CLEAR_SAMPLEDATA_OK'));
}

function getConfigoption($mid)
{
    global $xoopsDB;
    $list  = [];
    $list2 = [];

    //Correct Answers
    //    $sql =  'SELECT * FROM ' . $xoopsDB->prefix('configoption') . ' as op'
    ////             . ' NATURAL JOIN ' . $xoopsDB->prefix('co') . ' as qq'
    //             . ' INNER  JOIN ' . $xoopsDB->prefix('co') . ' as co'
    //             . " WHERE  co.conf_modid = ". $mid ." AND op.confop_id=co.conf_id";

    $sql = 'SELECT op.confop_id, op.confop_name, op.confop_value, op.conf_id FROM ' . $xoopsDB->prefix('configoption') . ' as op' //             . ' NATURAL JOIN ' . $xoopsDB->prefix('co') . ' as qq'
           . ' INNER  JOIN ' . $xoopsDB->prefix('config') . ' as co' . ' WHERE  co.conf_modid = ' . $mid . ' AND co.conf_id=op.conf_id';

    //    $sql2 = 'SELECT * FROM ' . $xoopsDB->prefix('configoption') . ' as op INNER JOIN ' . $xoopsDB->prefix('co') . ' as co ON co.conf_modid = '. $mid . ' AND op.confop_id = co.conf_id';
    $sql2    = 'SELECT op.confop_id, op.confop_name, op.confop_value, op.conf_id FROM ' . $xoopsDB->prefix('configoption') . ' as op INNER JOIN ' . $xoopsDB->prefix('config') . ' as co ON co.conf_modid = ' . $mid . ' AND co.conf_id=op.conf_id';
    $result2 = $xoopsDB->query($sql2);

    $result = $xoopsDB->query($sql);

    while (false !== ($myrow = (($xoopsDB->isResultSet($result) && ($result instanceof \mysqli_result)) ? $xoopsDB->fetchArray($result) : false))) {
        $list[] = $myrow;
    }

    //    $q = 0;
    //    while (false !== ($myrow = (($xoopsDB->isResultSet($result) && ($result instanceof \mysqli_result)) ? $xoopsDB->fetchArray($result) : false))) {
    //        $list[$q]['confop_id']    = $myrow['confop_id'];
    //        $list[$q]['confop_name']  = $myrow['confop_name'];
    //        $list[$q]['confop_value'] = $myrow['confop_value'];
    //        $list[$q]['conf_id']      = $myrow['conf_id'];
    //        ++$q;
    //    }

    $q = 0;
    while (false !== ($myrow = (($xoopsDB->isResultSet($result2) && ($result2 instanceof \mysqli_result)) ? $xoopsDB->fetchArray($result2) : false))) {
        $list2[$q][] = $myrow;
        ++$q;
    }

    return $list;
}

function getConfigAndOptions($mid, $rows)
{
    global $xoopsDB;
    $list  = [];
    $list2 = [];

    //    $table     = 'config';
    //    $rows = \Xmf\Database\TableLoad::extractRows($table, $criteria, $skipColumns);

    //foreach($rows as $k=>$v){
    //
    //    $list[] =
    //}

    //    $sql    = 'SELECT co.conf_id FROM ' . $xoopsDB->prefix('config') . ' as co' . " WHERE  co.conf_modid = " . $mid;
    $sql    = 'SELECT * FROM ' . $xoopsDB->prefix('config') . ' as co' . ' WHERE  co.conf_modid = ' . $mid;
    $result = $xoopsDB->query($sql);

    while (false !== ($myrow = (($xoopsDB->isResultSet($result) && ($result instanceof \mysqli_result)) ? $xoopsDB->fetchArray($result) : false))) {
        //        $list[] = $myrow;
        $confId = $myrow['conf_id'];

        $sql = 'SELECT op.confop_id, op.confop_name, op.confop_value, op.conf_id FROM ' . $xoopsDB->prefix('configoption') . ' as op' //             . ' NATURAL JOIN ' . $xoopsDB->prefix('co') . ' as qq'
               . ' WHERE  op.conf_id = ' . $confId;

        $result2 = $xoopsDB->query($sql);

        $q = 0;
        while (false !== ($myrow2 = (($xoopsDB->isResultSet($result2) && ($result2 instanceof \mysqli_result)) ? $xoopsDB->fetchArray($result2) : false))) {
            $list[$confId][$q]['confop_id']    = $myrow2['confop_id'];
            $list[$confId][$q]['confop_name']  = $myrow2['confop_name'];
            $list[$confId][$q]['confop_value'] = $myrow2['confop_value'];
            $list[$confId][$q]['conf_id']      = $myrow2['conf_id'];
            ++$q;
        }
    }

    //    $sql2 = 'SELECT * FROM ' . $xoopsDB->prefix('configoption') . ' as op INNER JOIN ' . $xoopsDB->prefix('co') . ' as co ON co.conf_modid = '. $mid . ' AND op.confop_id = co.conf_id';
    //    $sql2    = 'SELECT op.confop_id, op.confop_name, op.confop_value, op.conf_id FROM ' . $xoopsDB->prefix('configoption') . ' as op INNER JOIN ' . $xoopsDB->prefix('config') . ' as co ON co.conf_modid = ' . $mid . ' AND co.conf_id=op.conf_id';
    //    $result2 = $xoopsDB->query($sql2);
    //
    //    $q = 0;
    //    while (false !== ($myrow = (($xoopsDB->isResultSet($result2) && ($result2 instanceof \mysqli_result)) ? $xoopsDB->fetchArray($result2) : false))) {
    //        $list2[$q][] = $myrow;
    //        ++$q;
    //    }

    return $list;
}

function saveArrayToYamlFile($array, $yamlFile)
{
    //    $rows = \Xmf\Database\TableLoad::extractRows($table, $criteria, $skipColumns);

    $count = Yaml::save($array, $yamlFile);

    return (false !== $count);
}

/**
 * loadTableFromYamlFile
 *
 * @param string $table name of table to load without prefix
 *
 * @return int number of rows inserted
 */
function loadConfigoptionsFromYamlFile($table, mixed $tabledata, mixed $skipColumns, mixed $configid)
{
    $count = 0;

    //    $data = Yaml::readWrapped($yamlFile); // work with phpmyadmin YAML dumps

    //get Config

    //create ConfigOptions

    if (false !== $tabledata) {
        $count = Xmf\Database\TableLoad::loadTableFromArray($table, $tabledata);
    }

    return $count;
}
