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

use XoopsModules\Mtools\Common\Configurator;
use XoopsModules\Mtools\Module\Installer;
use XoopsModules\Quotes\Helper;
use XoopsModules\Quotes\Utility;

/** @var Helper $helper */
/** @var Utility $utility */
if ((!defined('XOOPS_ROOT_PATH')) || !$GLOBALS['xoopsUser'] instanceof \XoopsUser
    || !$GLOBALS['xoopsUser']->isAdmin()) {
    exit('Restricted access' . PHP_EOL);
}

require \dirname(__DIR__) . '/bootstrap.php';

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_quotes(\XoopsModule $module)
{
    $mtoolsDependencyError = quotes_mtools_dependency_error();
    if ('' !== $mtoolsDependencyError) {
        $module->setErrors($mtoolsDependencyError);

        return false;
    }

    $utility = new Utility();

    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);

    // Ensure upload folders exist before the update runs.
    Installer::createUploadFolders(new Configurator(\dirname(__DIR__)));

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
    $mtoolsDependencyError = quotes_mtools_dependency_error();
    if ('' !== $mtoolsDependencyError) {
        $module->setErrors($mtoolsDependencyError);

        return false;
    }

    // Add the owner column to existing installs (idempotent — safe to re-run).
    $db = \XoopsDatabaseFactory::getDatabaseConnection();
    $quoteTable = $db->prefix('quotes_quote');
    if (!\XoopsModules\Mtools\Common\Db::fieldExists($db, 'uid', $quoteTable)) {
        $db->exec("ALTER TABLE `{$quoteTable}` ADD COLUMN `uid` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `author_id`, ADD KEY `idx_uid` (`uid`)");
    }
    $authorTable = $db->prefix('quotes_author');
    if (!\XoopsModules\Mtools\Common\Db::fieldExists($db, 'uid', $authorTable)) {
        $db->exec("ALTER TABLE `{$authorTable}` ADD COLUMN `uid` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `photo`, ADD KEY `idx_uid` (`uid`)");
    }

    $helper = Helper::getInstance();
    $helper->loadLanguage('common');
    $configurator = new Configurator(\dirname(__DIR__));

    if ($previousVersion < 240) {
        // Shared update cleanup: remove legacy .html templates / old files / old folders,
        // (re)create upload folders, reseed blank.png, and purge .html rows from tplfile.
        Installer::removeOldAssets($module, $configurator);
        Installer::createUploadFolders($configurator);
        Installer::copyBlankFiles($configurator);
        Installer::purgeHtmlTemplates($module);

        /** @var \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = xoops_getHandler('groupperm');

        return $grouppermHandler->deleteByModule($module->getVar('mid'), 'item_read');
    }

    return true;
}
