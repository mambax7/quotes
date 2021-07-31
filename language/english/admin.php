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

//Index
define('AM_QUOTES_STATISTICS', 'Quotes statistics');
define('AM_QUOTES_THEREARE_QUOTE', "There are <span class='bold'>%s</span> Quote in the database");
define('AM_QUOTES_THEREARE_CATEGORY', "There are <span class='bold'>%s</span> Category in the database");
define('AM_QUOTES_THEREARE_AUTHOR', "There are <span class='bold'>%s</span> Author in the database");
//Buttons
define('AM_QUOTES_ADD_QUOTE', 'Add new Quote');
define('AM_QUOTES_QUOTE_LIST', 'List of Quote');
define('AM_QUOTES_ADD_CATEGORY', 'Add new Category');
define('AM_QUOTES_CATEGORY_LIST', 'List of Category');
define('AM_QUOTES_ADD_AUTHOR', 'Add new Author');
define('AM_QUOTES_AUTHOR_LIST', 'List of Author');
//General
define('AM_QUOTES_FORMOK', 'Registered successfull');
define('AM_QUOTES_FORMDELOK', 'Deleted successfull');
define('AM_QUOTES_FORMSUREDEL', "Are you sure to Delete: <span class='bold red'>%s</span></b>");
define('AM_QUOTES_FORMSURERENEW', "Are you sure to Renew: <span class='bold red'>%s</span></b>");
define('AM_QUOTES_FORMUPLOAD', 'Upload');
define('AM_QUOTES_FORMIMAGE_PATH', 'File presents in %s');
define('AM_QUOTES_FORM_ACTION', 'Action');
define('AM_QUOTES_SELECT', 'Select action for selected item(s)');
define('AM_QUOTES_SELECTED_DELETE', 'Delete selected item(s)');
define('AM_QUOTES_SELECTED_ACTIVATE', 'Activate selected item(s)');
define('AM_QUOTES_SELECTED_DEACTIVATE', 'De-activate selected item(s)');
define('AM_QUOTES_SELECTED_ERROR', 'You selected nothing to delete');
define('AM_QUOTES_CLONED_OK', 'Record cloned successfully');
define('AM_QUOTES_CLONED_FAILED', 'Cloning of the record has failed');

// Quote
define('AM_QUOTES_QUOTE_ADD', 'Add a quote');
define('AM_QUOTES_QUOTE_EDIT', 'Edit quote');
define('AM_QUOTES_QUOTE_DELETE', 'Delete quote');
define('AM_QUOTES_QUOTE_ID', 'ID');
define('AM_QUOTES_QUOTE_CID', 'Category');
define('AM_QUOTES_QUOTE_AUTHOR_ID', 'Author');
define('AM_QUOTES_QUOTE_QUOTE', 'Quote');
define('AM_QUOTES_QUOTE_ONLINE', 'Online');
define('AM_QUOTES_QUOTE_CREATED', 'Created');
define('AM_QUOTES_QUOTE_UPDATED', 'Updated');
// Category
define('AM_QUOTES_CATEGORY_ADD', 'Add a category');
define('AM_QUOTES_CATEGORY_EDIT', 'Edit category');
define('AM_QUOTES_CATEGORY_DELETE', 'Delete category');
define('AM_QUOTES_CATEGORY_ID', 'ID');
define('AM_QUOTES_CATEGORY_PID', 'Parent');
define('AM_QUOTES_CATEGORY_TITLE', 'Category');
define('AM_QUOTES_CATEGORY_DESCRIPTION', 'Description');
define('AM_QUOTES_CATEGORY_IMAGE', 'Image');
define('AM_QUOTES_CATEGORY_WEIGHT', 'Weight');
define('AM_QUOTES_CATEGORY_COLOR', 'Color');
define('AM_QUOTES_CATEGORY_ONLINE', 'Online');
// Author
define('AM_QUOTES_AUTHOR_ADD', 'Add a author');
define('AM_QUOTES_AUTHOR_EDIT', 'Edit author');
define('AM_QUOTES_AUTHOR_DELETE', 'Delete author');
define('AM_QUOTES_AUTHOR_ID', 'ID');
define('AM_QUOTES_AUTHOR_NAME', 'Name');
define('AM_QUOTES_AUTHOR_COUNTRY', 'Country');
define('AM_QUOTES_AUTHOR_BIO', 'Bio');
define('AM_QUOTES_AUTHOR_PHOTO', 'Photo');
define('AM_QUOTES_AUTHOR_CREATED', 'Created');
define('AM_QUOTES_AUTHOR_UPDATED', 'Updated');
//Blocks.php
//Permissions
define('AM_QUOTES_PERMISSIONS_GLOBAL', 'Global permissions');
define('AM_QUOTES_PERMISSIONS_GLOBAL_DESC', 'Only users in the group that you select may global this');
define('AM_QUOTES_PERMISSIONS_GLOBAL_4', 'Rate from user');
define('AM_QUOTES_PERMISSIONS_GLOBAL_8', 'Submit from user side');
define('AM_QUOTES_PERMISSIONS_GLOBAL_16', 'Auto approve');
define('AM_QUOTES_PERMISSIONS_APPROVE', 'Permissions to approve');
define('AM_QUOTES_PERMISSIONS_APPROVE_DESC', 'Only users in the group that you select may approve this');
define('AM_QUOTES_PERMISSIONS_VIEW', 'Permissions to view');
define('AM_QUOTES_PERMISSIONS_VIEW_DESC', 'Only users in the group that you select may view this');
define('AM_QUOTES_PERMISSIONS_SUBMIT', 'Permissions to submit');
define('AM_QUOTES_PERMISSIONS_SUBMIT_DESC', 'Only users in the group that you select may submit this');
define('AM_QUOTES_PERMISSIONS_GPERMUPDATED', 'Permissions have been changed successfully');
define('AM_QUOTES_PERMISSIONS_NOPERMSSET', 'Permission cannot be set: No author created yet! Please create a author first.');

//Errors
define('AM_QUOTES_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('AM_QUOTES_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('AM_QUOTES_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('AM_QUOTES_ERROR_COLUMN', 'Could not create column in database : %s');
define('AM_QUOTES_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('AM_QUOTES_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('AM_QUOTES_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');
//directories
define('AM_QUOTES_AVAILABLE', "<span style='color : #008000;'>Available. </span>");
define('AM_QUOTES_NOTAVAILABLE', "<span style='color : #ff0000;'>is not available. </span>");
define('AM_QUOTES_NOTWRITABLE', "<span style='color : #ff0000;'>" . ' should have permission ( %1$d ), but it has ( %2$d )' . '</span>');
define('AM_QUOTES_CREATETHEDIR', 'Create it');
define('AM_QUOTES_SETMPERM', 'Set the permission');
define('AM_QUOTES_DIRCREATED', 'The directory has been created');
define('AM_QUOTES_DIRNOTCREATED', 'The directory can not be created');
define('AM_QUOTES_PERMSET', 'The permission has been set');
define('AM_QUOTES_PERMNOTSET', 'The permission can not be set');
define('AM_QUOTES_VIDEO_EXPIREWARNING', 'The publishing date is after expiration date!!!');
//Sample Data
define('AM_QUOTES_LOAD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
define('AM_QUOTES_SAMPLEDATA_SUCCESS', 'Sample Date uploaded successfully');

define('AM_QUOTES_MAINTAINEDBY', 'is maintained by the');


define('_AM_QUOTES_ERROR_SYSTEMCANT', 'Cannot delete system block(s)');
define('_AM_QUOTES_ERROR_MODULECANT', 'Cannot delete module block(s)');
define('_AM_QUOTES_CLONEBLOCK', 'Clone Block');
define('_AM_QUOTES_EDITBLOCK', 'Edit Block');
define('_AM_QUOTES_RESTRICTED', 'Restricted access');
define('_AM_QUOTES_BLOCKTAG1', '%s, %s');
