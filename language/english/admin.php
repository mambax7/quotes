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

//Index
define('_AM_QUOTES_STATISTICS', 'Quotes statistics');
define('_AM_QUOTES_THEREARE_QUOTE', "There are <span class='bold'>%s</span> Quote in the database");
define('_AM_QUOTES_THEREARE_CATEGORY', "There are <span class='bold'>%s</span> Category in the database");
define('_AM_QUOTES_THEREARE_AUTHOR', "There are <span class='bold'>%s</span> Author in the database");
//Buttons
define('_AM_QUOTES_ADD_QUOTE', 'Add new Quote');
define('_AM_QUOTES_QUOTE_LIST', 'List of Quote');
define('_AM_QUOTES_ADD_CATEGORY', 'Add new Category');
define('_AM_QUOTES_CATEGORY_LIST', 'List of Category');
define('_AM_QUOTES_ADD_AUTHOR', 'Add new Author');
define('_AM_QUOTES_AUTHOR_LIST', 'List of Author');
//General
define('_AM_QUOTES_FORMOK', 'Registered successfull');
define('_AM_QUOTES_FORMDELOK', 'Deleted successfull');
define('_AM_QUOTES_FORMSUREDEL', "Are you sure to Delete: <span class='bold red'>%s</span></b>");
define('_AM_QUOTES_FORMSURERENEW', "Are you sure to Renew: <span class='bold red'>%s</span></b>");
define('_AM_QUOTES_FORMUPLOAD', 'Upload');
define('_AM_QUOTES_FORMIMAGE_PATH', 'File presents in %s');
define('_AM_QUOTES_FORM_ACTION', 'Action');
define('_AM_QUOTES_SELECT', 'Select action for selected item(s)');
define('_AM_QUOTES_SELECTED_DELETE', 'Delete selected item(s)');
define('_AM_QUOTES_SELECTED_ACTIVATE', 'Activate selected item(s)');
define('_AM_QUOTES_SELECTED_DEACTIVATE', 'De-activate selected item(s)');
define('_AM_QUOTES_SELECTED_ERROR', 'You selected nothing to delete');
define('_AM_QUOTES_CLONED_OK', 'Record cloned successfully');
define('_AM_QUOTES_CLONED_FAILED', 'Cloning of the record has failed');
define('_AM_QUOTES_FORMSURECLONE', "Are you sure to Clone record: <span class='bold red'>#%s</span>?");

// Quote
define('_AM_QUOTES_QUOTE_ADD', 'Add a quote');
define('_AM_QUOTES_QUOTE_EDIT', 'Edit quote');
define('_AM_QUOTES_QUOTE_DELETE', 'Delete quote');
define('_AM_QUOTES_QUOTE_ID', 'ID');
define('_AM_QUOTES_QUOTE_CID', 'Category');
define('_AM_QUOTES_QUOTE_AUTHOR_ID', 'Author');
define('_AM_QUOTES_QUOTE_QUOTE', 'Quote');
define('_AM_QUOTES_QUOTE_ONLINE', 'Online');
define('_AM_QUOTES_QUOTE_CREATED', 'Created');
define('_AM_QUOTES_QUOTE_UPDATED', 'Updated');
define('_AM_QUOTES_SUBMITTER', 'Submitter');
// Category
define('_AM_QUOTES_CATEGORY_ADD', 'Add a category');
define('_AM_QUOTES_CATEGORY_EDIT', 'Edit category');
define('_AM_QUOTES_CATEGORY_DELETE', 'Delete category');
define('_AM_QUOTES_CATEGORY_ID', 'ID');
define('_AM_QUOTES_CATEGORY_PID', 'Parent');
define('_AM_QUOTES_CATEGORY_TITLE', 'Category');
define('_AM_QUOTES_CATEGORY_DESCRIPTION', 'Description');
define('_AM_QUOTES_CATEGORY_IMAGE', 'Image');
define('_AM_QUOTES_CATEGORY_WEIGHT', 'Weight');
define('_AM_QUOTES_CATEGORY_COLOR', 'Color');
define('_AM_QUOTES_CATEGORY_ONLINE', 'Online');
// Author
define('_AM_QUOTES_AUTHOR_ADD', 'Add a author');
define('_AM_QUOTES_AUTHOR_EDIT', 'Edit author');
define('_AM_QUOTES_AUTHOR_DELETE', 'Delete author');
define('_AM_QUOTES_AUTHOR_ID', 'ID');
define('_AM_QUOTES_AUTHOR_NAME', 'Name');
define('_AM_QUOTES_AUTHOR_COUNTRY', 'Country');
define('_AM_QUOTES_AUTHOR_BIO', 'Bio');
define('_AM_QUOTES_AUTHOR_PHOTO', 'Photo');
define('_AM_QUOTES_AUTHOR_CREATED', 'Created');
define('_AM_QUOTES_AUTHOR_UPDATED', 'Updated');
define('_AM_QUOTES_NEWAUTHOR', 'New author');
define('_AM_QUOTES_NEWAUTHOR_HELP', 'To add a brand-new author, fill in the name below (and optionally country / bio / photo). Leave the name blank if you selected an existing author above.');
define('_AM_QUOTES_NEED_AUTHOR', 'Please select an existing author or enter a new author name.');
//Blocks.php
//Permissions
define('_AM_QUOTES_PERMISSIONS_GLOBAL', 'Global permissions');
define('_AM_QUOTES_PERMISSIONS_GLOBAL_DESC', 'Only users in the group that you select may global this');
define('_AM_QUOTES_PERMISSIONS_GLOBAL_4', 'Rate from user');
define('_AM_QUOTES_PERMISSIONS_GLOBAL_8', 'Submit from user side');
define('_AM_QUOTES_PERMISSIONS_GLOBAL_16', 'Auto approve');
define('_AM_QUOTES_PERMISSIONS_GLOBAL_32', 'Can edit own posts');
define('_AM_QUOTES_PERMISSIONS_APPROVE', 'Permissions to approve');
define('_AM_QUOTES_PERMISSIONS_APPROVE_DESC', 'Only users in the group that you select may approve this');
define('_AM_QUOTES_PERMISSIONS_VIEW', 'Permissions to view');
define('_AM_QUOTES_PERMISSIONS_VIEW_DESC', 'Only users in the group that you select may view this');
define('_AM_QUOTES_PERMISSIONS_SUBMIT', 'Permissions to submit');
define('_AM_QUOTES_PERMISSIONS_SUBMIT_DESC', 'Only users in the group that you select may submit this');
define('_AM_QUOTES_PERMISSIONS_GPERMUPDATED', 'Permissions have been changed successfully');
define('_AM_QUOTES_PERMISSIONS_NOPERMSSET', 'Permission cannot be set: No author created yet! Please create a author first.');

//Errors
define('_AM_QUOTES_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('_AM_QUOTES_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('_AM_QUOTES_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('_AM_QUOTES_ERROR_COLUMN', 'Could not create column in database : %s');
define('_AM_QUOTES_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('_AM_QUOTES_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('_AM_QUOTES_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');
//directories
define('_AM_QUOTES_AVAILABLE', "<span style='color : #008000;'>Available. </span>");
define('_AM_QUOTES_NOTAVAILABLE', "<span style='color : #ff0000;'>is not available. </span>");
define('_AM_QUOTES_NOTWRITABLE', "<span style='color : #ff0000;'>" . ' should have permission ( %1$d ), but it has ( %2$d )' . '</span>');
define('_AM_QUOTES_CREATETHEDIR', 'Create it');
define('_AM_QUOTES_SETMPERM', 'Set the permission');
define('_AM_QUOTES_DIRCREATED', 'The directory has been created');
define('_AM_QUOTES_DIRNOTCREATED', 'The directory can not be created');
define('_AM_QUOTES_PERMSET', 'The permission has been set');
define('_AM_QUOTES_PERMNOTSET', 'The permission can not be set');
define('_AM_QUOTES_VIDEO_EXPIREWARNING', 'The publishing date is after expiration date!!!');
//Sample Data
define('_AM_QUOTES_LOAD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
define('_AM_QUOTES_SAMPLEDATA_SUCCESS', 'Sample Date uploaded successfully');

define('_AM_QUOTES_MAINTAINEDBY', 'is maintained by the');

define('_AM_QUOTES_ERROR_SYSTEMCANT', 'Cannot delete system block(s)');
define('_AM_QUOTES_ERROR_MODULECANT', 'Cannot delete module block(s)');
define('_AM_QUOTES_CLONEBLOCK', 'Clone Block');
define('_AM_QUOTES_EDITBLOCK', 'Edit Block');
define('_AM_QUOTES_RESTRICTED', 'Restricted access');
define('_AM_QUOTES_BLOCKTAG1', '%s, %s');
