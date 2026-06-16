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
$moduleDirName      = \basename(\dirname(__DIR__, 2));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

// General
define('_CO_QUOTES_CONFIRM', 'Confirm');

define('_CO_QUOTES_GDLIBSTATUS', 'GD library support: ');
define('_CO_QUOTES_GDLIBVERSION', 'GD Library version: ');
\define('_CO_QUOTES_GDOFF', "<span style='font-weight: bold;'>Disabled</span> (No thumbnails available)");
\define('_CO_QUOTES_GDON', "<span style='font-weight: bold;'>Enabled</span> (Thumbsnails available)");
define('_CO_QUOTES_IMAGEINFO', 'Server status');
define('_CO_QUOTES_MAXPOSTSIZE', 'Max post size permitted (post_max_size directive in php.ini): ');
define('_CO_QUOTES_MAXUPLOADSIZE', 'Max upload size permitted (upload_max_filesize directive in php.ini): ');
define('_CO_QUOTES_MEMORYLIMIT', 'Memory limit (memory_limit directive in php.ini): ');
define('_CO_QUOTES_METAVERSION', "<span style='font-weight: bold;'>Downloads meta version:</span> ");
define('_CO_QUOTES_OFF', "<span style='font-weight: bold;'>OFF</span>");
define('_CO_QUOTES_ON', "<span style='font-weight: bold;'>ON</span>");
define('_CO_QUOTES_SERVERPATH', 'Server path to XOOPS root: ');
define('_CO_QUOTES_SERVERUPLOADSTATUS', 'Server uploads status: ');
define('_CO_QUOTES_SPHPINI', "<span style='font-weight: bold;'>Information taken from PHP ini file:</span>");
define('_CO_QUOTES_UPLOADPATHDSC', 'Note. Upload path *MUST* contain the full server path of your upload folder.');

define('_CO_QUOTES_PRINT', "<span style='font-weight: bold;'>Print</span>");
define('_CO_QUOTES_PDF', "<span style='font-weight: bold;'>Create PDF</span>");

define('_CO_QUOTES_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('_CO_QUOTES_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('_CO_QUOTES_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('_CO_QUOTES_ERROR_COLUMN', 'Could not create column in database : %s');
define('_CO_QUOTES_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('_CO_QUOTES_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('_CO_QUOTES_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');

define('_CO_QUOTES_FOLDERS_DELETED_OK', 'Upload Folders have been deleted');

// Error Msgs
define('_CO_QUOTES_ERROR_BAD_DEL_PATH', 'Could not delete %s directory');
define('_CO_QUOTES_ERROR_BAD_REMOVE', 'Could not delete %s');
define('_CO_QUOTES_ERROR_NO_PLUGIN', 'Could not load plugin');

//Help
define('_CO_QUOTES_DIRNAME', basename(dirname(__DIR__, 2)));
define('_CO_QUOTES_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_CO_QUOTES_BACK_2_ADMIN', 'Back to Administration of ');
define('_CO_QUOTES_OVERVIEW', 'Overview');

//define('_CO_QUOTES_HELP_DIR', __DIR__);

//help multipage
define('_CO_QUOTES_DISCLAIMER', 'Disclaimer');
define('_CO_QUOTES_LICENSE', 'License');
define('_CO_QUOTES_SUPPORT', 'Support');

//Sample Data
define('_CO_QUOTES_LOAD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
define('_CO_QUOTES_LOAD_SAMPLEDATA_CONFIRM', 'Are you sure to Import Sample Data? (It will delete ALL current data)');
define('_CO_QUOTES_LOAD_SAMPLEDATA_SUCCESS', 'Sample Date imported  successfully');
define('_CO_QUOTES_SAVE_SAMPLEDATA', 'Export Tables to YAML');
define('_CO_QUOTES_SAVE_SAMPLEDATA_SUCCESS', 'Export Tables to YAML successfully');
define('_CO_QUOTES_CLEAR_SAMPLEDATA', 'Clear Sample Data');
define('_CO_QUOTES_CLEAR_SAMPLEDATA_OK', 'The Sample Data has been cleared');
define('_CO_QUOTES_CLEAR_SAMPLEDATA_CONFIRM', 'Are you sure to Clear Sample Data? (It will delete ALL current data)');
define('_CO_QUOTES_EXPORT_SCHEMA', 'Export DB Schema to YAML');
define('_CO_QUOTES_EXPORT_SCHEMA_SUCCESS', 'Export DB Schema to YAML was a success');
define('_CO_QUOTES_EXPORT_SCHEMA_ERROR', 'ERROR: Export of DB Schema to YAML failed');
define('_CO_QUOTES_SHOW_SAMPLE_BUTTON', 'Show Sample Button?');
define('_CO_QUOTES_SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');
define('_CO_QUOTES_HIDE_SAMPLEDATA_BUTTONS', 'Hide the Import buttons)');
define('_CO_QUOTES_SHOW_SAMPLEDATA_BUTTONS', 'Show the Import buttons)');

// block defines
define('_CO_QUOTES_ACCESSRIGHTS', 'Access Rights');
define('_CO_QUOTES_ACTION', 'Action');
define('_CO_QUOTES_ACTIVERIGHTS', 'Active Rights');
define('_CO_QUOTES_BADMIN', 'Block Administration');
define('_CO_QUOTES_BLKDESC', 'Description');
define('_CO_QUOTES_CBCENTER', 'Center Middle');
define('_CO_QUOTES_CBLEFT', 'Center Left');
define('_CO_QUOTES_CBRIGHT', 'Center Right');
define('_CO_QUOTES_SBLEFT', 'Left');
define('_CO_QUOTES_SBRIGHT', 'Right');
define('_CO_QUOTES_SIDE', 'Alignment');
define('_CO_QUOTES_TITLE', 'Title');
define('_CO_QUOTES_VISIBLE', 'Visible');
define('_CO_QUOTES_VISIBLEIN', 'Visible In');
define('_CO_QUOTES_WEIGHT', 'Weight');

define('_CO_QUOTES_PERMISSIONS', 'Permissions');
define('_CO_QUOTES_BLOCKS', 'Blocks Admin');
define('_CO_QUOTES_BLOCKS_DESC', 'Blocks/Group Admin');

define('_CO_QUOTES_BLOCKS_MANAGMENT', 'Manage');
define('_CO_QUOTES_BLOCKS_ADDBLOCK', 'Add a new block');
define('_CO_QUOTES_BLOCKS_EDITBLOCK', 'Edit a block');
define('_CO_QUOTES_BLOCKS_CLONEBLOCK', 'Clone a block');

//myblocksadmin
\define('_CO_QUOTES_AGDS', 'Admin Groups');
\define('_CO_QUOTES_BCACHETIME', 'Cache Time');
\define('_CO_QUOTES_BLOCKS_ADMIN', 'Blocks Admin');
\define('_CO_QUOTES_UPDATE_SUCCESS', 'Update successful');

//Template Admin
define('_CO_QUOTES_TPLSETS', 'Template Management');
define('_CO_QUOTES_GENERATE', 'Generate');
define('_CO_QUOTES_FILENAME', 'File Name');

//Menu
define('_CO_QUOTES_ADMENU_MIGRATE', 'Migrate');
define('_CO_QUOTES_FOLDER_YES', 'Folder "%s" exist');
define('_CO_QUOTES_FOLDER_NO', 'Folder "%s" does not exist. Create the specified folder with CHMOD 777.');
define('_CO_QUOTES_SHOW_DEV_TOOLS', 'Show Development Tools Button?');
define('_CO_QUOTES_SHOW_DEV_TOOLS_DESC', 'If yes, the "Migrate" Tab and other Development tools will be visible to the Admin.');
define('_CO_QUOTES_ADMENU_FEEDBACK', 'Feedback');
define('_CO_QUOTES_MIGRATE_OK', 'Database migrated to current schema.');
define('_CO_QUOTES_MIGRATE_WARNING', 'Warning! This is intended for developers only. Confirm write schema file from current database.');
define('_CO_QUOTES_MIGRATE_SCHEMA_OK', 'Current schema file written');

//Latest Version Check
define('_CO_QUOTES_NEW_VERSION', 'New Version: ');

//DirectoryChecker
define('_CO_QUOTES_AVAILABLE', "<span style='color: #008000;'>Available</span>");
define('_CO_QUOTES_NOTAVAILABLE', "<span style='color: #ff0000;'>Not available</span>");
define('_CO_QUOTES_NOTWRITABLE', "<span style='color: #ff0000;'>Should have permission ( %d ), but it has ( %d )</span>");
define('_CO_QUOTES_CREATETHEDIR', 'Create it');
define('_CO_QUOTES_SETMPERM', 'Set the permission');
define('_CO_QUOTES_DIRCREATED', 'The directory has been created');
define('_CO_QUOTES_DIRNOTCREATED', 'The directory cannot be created');
define('_CO_QUOTES_PERMSET', 'The permission has been set');
define('_CO_QUOTES_PERMNOTSET', 'The permission cannot be set');

//FileChecker
//define('_CO_QUOTES_AVAILABLE', "<span style='color: #008000;'>Available</span>");
//define('_CO_QUOTES_NOTAVAILABLE', "<span style='color: #ff0000;'>Not available</span>");
//define('_CO_QUOTES_NOTWRITABLE', "<span style='color: #ff0000;'>Should have permission ( %d ), but it has ( %d )</span>");
//define('_CO_QUOTES_COPYTHEFILE', 'Copy it');
//define('_CO_QUOTES_CREATETHEFILE', 'Create it');
//define('_CO_QUOTES_SETMPERM', 'Set the permission');

define('_CO_QUOTES_FILECOPIED', 'The file has been copied');
define('_CO_QUOTES_FILENOTCOPIED', 'The file cannot be copied');

//define('_CO_QUOTES_PERMSET', 'The permission has been set');
//define('_CO_QUOTES_PERMNOTSET', 'The permission cannot be set');

define('_CO_QUOTES_TRUNCATE_LENGTH', 'Number of Characters to truncate to the long text field');
define('_CO_QUOTES_TRUNCATE_LENGTH_DESC', 'Set the maximum number of characters to truncate the long text fields');

define('_CO_QUOTES_DELETE_BLOCK_CONFIRM', 'Are you sure to delete this Block?');
