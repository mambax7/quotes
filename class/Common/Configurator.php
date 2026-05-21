<?php declare(strict_types=1);

namespace XoopsModules\Quote\Common;

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

//require_once \dirname(__DIR__, 2) . '/include/common.php';

/**
 * Class Configurator
 */
class Configurator
{
    public string $name;
    public $paths;
    public array  $uploadFolders   = [];
    public array  $copyBlankFiles  = [];
    public array  $copyTestFolders = [];
    public array  $templateFolders = [];
    public array  $oldFiles        = [];
    public array  $oldFolders      = [];
    public array  $renameTables    = [];
    public array  $renameColumns   = [];
    public array  $moduleStats     = [];
    public string $modCopyright;
    public $icons ;

    /**
     * Configurator constructor.
     */
    public function __construct()
    {
        // $moduleDirName = \basename(\dirname(__DIR__, 2));

        $config = include \dirname(__DIR__, 2) . '/config/config.php';

        $this->name            = $config->name;
        // $this->paths           = $config->paths;
        $this->uploadFolders   = $config->uploadFolders;
        $this->copyBlankFiles  = $config->copyBlankFiles;
        $this->copyTestFolders = $config->copyTestFolders;
        $this->templateFolders = $config->templateFolders;
        $this->oldFiles        = $config->oldFiles;
        $this->oldFolders      = $config->oldFolders;
        $this->renameTables    = $config->renameTables;
        $this->renameColumns   = $config->renameColumns;
        $this->moduleStats     = $config->moduleStats;
        $this->modCopyright    = $config->modCopyright;

        $this->icons = require \dirname(__DIR__, 2) . '/config/icons.php';
        $this->paths = require \dirname(__DIR__, 2) . '/config/paths.php';
    }
}
