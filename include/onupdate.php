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

use XoopsModules\Mtools;
use XoopsModules\Quotes\{
    Helper,
    Utility
};

/** @var Helper $helper */
/** @var Utility $utility */

if ((!defined('XOOPS_ROOT_PATH')) || !$GLOBALS['xoopsUser'] instanceof \XoopsUser
    || !$GLOBALS['xoopsUser']->isAdmin()) {
    exit('Restricted access' . PHP_EOL);
}

require \dirname(__DIR__) . '/preloads/autoloader.php';
require_once XOOPS_ROOT_PATH . '/modules/mtools/preloads/autoloader.php';

/**
 *
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_quotes(\XoopsModule $module)
{
    $helper  = Helper::getInstance();
    $utility = new Utility();

    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);

    $configurator = new Mtools\Common\Configurator($helper->path());

    //create upload folders
    $uploadFolders = $configurator->uploadFolders;
    foreach ($uploadFolders as $value) {
        $utility::prepareFolder($value);
    }

    //    $migrator = new \XoopsModules\Mtools\Common\Migrate();
    //    $migrator->synchronizeSchema();

    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during update of the module
 * @param \XoopsModule $module {@link XoopsModule}
 * @param null|int     $previousVersion
 *
 * @return bool true if update successful, false if not
 */

function xoops_module_update_quotes(\XoopsModule $module, $previousVersion = null)
{
    $moduleDirName = \basename(\dirname(__DIR__));
    //$moduleDirNameUpper = mb_strtoupper($moduleDirName);

    $helper  = Helper::getInstance();
    $utility = new Utility();

    $configurator = new Mtools\Common\Configurator($helper->path());
    $helper->loadLanguage('common');

    if ($previousVersion < 240) {
        //delete old HTML templates
        if (count($configurator->templateFolders) > 0) {
            foreach ($configurator->templateFolders as $folder) {
                $templateFolder = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $folder);
                if (is_dir($templateFolder)) {
                    //$templateList = array_diff(scandir($templateFolder, SCANDIR_SORT_NONE), ['..', '.',]);
                    $temp = scandir($templateFolder, SCANDIR_SORT_NONE);
                    if (false !== $temp) {
                        $templateList = array_diff($temp, [
                                                            '..',
                                                            '.',
                                                        ]);

                        foreach ($templateList as $k => $v) {
                            $fileInfo = new SplFileInfo($templateFolder . $v);
                            if ('html' === $fileInfo->getExtension() && 'index.html' !== $fileInfo->getFilename()) {
                                if (is_file($templateFolder . $v)) {
                                    unlink($templateFolder . $v);
                                }
                            }
                        }
                    }
                }
            }
        }

        //  ---  DELETE OLD FILES ---------------
        if (count($configurator->oldFiles) > 0) {
            //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
            foreach (array_keys($configurator->oldFiles) as $i) {
                $tempFile = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFiles[$i]);
                if (is_file($tempFile)) {
                    unlink($tempFile);
                }
            }
        }

        //  ---  DELETE OLD FOLDERS ---------------
        xoops_load('XoopsFile');
        if (count($configurator->oldFolders) > 0) {
            //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
            foreach (array_keys($configurator->oldFolders) as $i) {
                $tempFolder = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFolders[$i]);
                /** @var \XoopsObjectHandler $folderHandler */
                $folderHandler = \XoopsFile::getHandler('folder', $tempFolder);
                $folderHandler->delete($tempFolder);
            }
        }

        //  ---  CREATE FOLDERS ---------------
        if (count($configurator->uploadFolders) > 0) {
            //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
            foreach (array_keys($configurator->uploadFolders) as $i) {
                $utility::createFolder($configurator->uploadFolders[$i]);
            }
        }

        //  ---  COPY blank.png FILES ---------------
        if (count($configurator->copyBlankFiles) > 0) {
            $file = \dirname(__DIR__) . '/assets/images/blank.png';
            foreach (array_keys($configurator->copyBlankFiles) as $i) {
                $dest = $configurator->copyBlankFiles[$i] . '/blank.png';
                $utility::copyFile($file, $dest);
            }
        }

        //delete .html entries from the tpl table
        $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('tplfile') . " WHERE `tpl_module` = '" . $module->getVar('dirname', 'n') . "' AND `tpl_file` LIKE '%.html%'";
        $GLOBALS['xoopsDB']->queryF($sql);

        /** @var \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = xoops_getHandler('groupperm');
        return $grouppermHandler->deleteByModule($module->getVar('mid'), 'item_read');
    }
    return true;
}
