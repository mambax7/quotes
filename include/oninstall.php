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
require \dirname(__DIR__) . '/bootstrap.php';

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_quotes(\XoopsModule $module)
{
    $mtoolsDependencyError = quotes_mtools_dependency_error();
    if ('' !== $mtoolsDependencyError) {
        $module->setErrors($mtoolsDependencyError);

        return false;
    }

    $utility = new Utility();

    //check for minimum XOOPS and PHP versions
    if (!$utility::checkVerXoops($module) || !$utility::checkVerPhp($module)) {
        return false;
    }

    // Shared pre-install filesystem work: create upload folders + drop existing tables.
    // At (pre-)install the module is not registered yet, so the Helper cannot resolve its own
    // path — build the Configurator from the module dir on disk instead.
    Installer::prepare($module, new Configurator(\dirname(__DIR__)));

    return true;
}

/**
 * Performs tasks required during installation of the module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if installation successful, false if not
 */
function xoops_module_install_quotes(\XoopsModule $module)
{
    $mtoolsDependencyError = quotes_mtools_dependency_error();
    if ('' !== $mtoolsDependencyError) {
        $module->setErrors($mtoolsDependencyError);

        return false;
    }

    $moduleDirName = \basename(\dirname(__DIR__));
    $helper        = Helper::getInstance();

    // Load language files
    $helper->loadLanguage('admin');
    $helper->loadLanguage('modinfo');

    // Module-specific default permissions.
    $moduleId = $module->getVar('mid');
    /** @var \XoopsGroupPermHandler $grouppermHandler */
    $grouppermHandler = xoops_getHandler('groupperm');
    $grouppermHandler->addRight($moduleDirName . '_approve', 1, \XOOPS_GROUP_ADMIN, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_submit', 1, \XOOPS_GROUP_ADMIN, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_view', 1, \XOOPS_GROUP_ADMIN, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_view', 1, \XOOPS_GROUP_USERS, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_view', 1, \XOOPS_GROUP_ANONYMOUS, $moduleId);

    // Shared install filesystem work: upload folders + blank.png + test data + .html tpl purge.
    Installer::install($module, new Configurator(\dirname(__DIR__)));

    return true;
}
