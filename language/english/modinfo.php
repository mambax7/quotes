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
// Admin
define('_MI_QUOTES_NAME', 'Quotes');
define('_MI_QUOTES_DESC', 'A curated quote library for browsing memorable words by author and category.');
define('_MI_QUOTES_SMNAME_ADD_AUTHOR', 'Add Author');
define('_MI_QUOTES_SMNAME_ADD_QUOTE', 'Add Quote');
//Menu
define('_MI_QUOTES_ADMENU1', 'Home');
define('_MI_QUOTES_ADMENU2', 'Quote');
define('_MI_QUOTES_ADMENU3', 'Category');
define('_MI_QUOTES_ADMENU4', 'Author');
define('_MI_QUOTES_ADMENU5', 'Feedback');
define('_MI_QUOTES_ADMENU6', 'Migrate');
define('_MI_QUOTES_ADMENU7', 'About');
define('_MI_QUOTES_ADMENU8', 'Permissions');
//Blocks
define('_MI_QUOTES_QUOTE_BLOCK', 'Quote block');
define('_MI_QUOTES_CATEGORY_BLOCK', 'Category block');
define('_MI_QUOTES_AUTHOR_BLOCK', 'Author block');
//Config
define('_MI_QUOTES_EDITOR_ADMIN', 'Editor: Admin');
define('_MI_QUOTES_EDITOR_ADMIN_DESC', 'Select the Editor to use by the Admin');
define('_MI_QUOTES_EDITOR_USER', 'Editor: User');
define('_MI_QUOTES_EDITOR_USER_DESC', 'Select the Editor to use by the User');
define('_MI_QUOTES_KEYWORDS', 'Keywords');
define('_MI_QUOTES_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
define('_MI_QUOTES_ADMINPAGER', 'Admin: records / page');
define('_MI_QUOTES_ADMINPAGER_DESC', 'Admin: # of records shown per page');
define('_MI_QUOTES_USERPAGER', 'User: records / page');
define('_MI_QUOTES_USERPAGER_DESC', 'User: # of records shown per page');
define('_MI_QUOTES_MAXSIZE', 'Max size');
define('_MI_QUOTES_MAXSIZE_DESC', 'Set a number of max size uploads file in byte');
define('_MI_QUOTES_MIMETYPES', 'Mime Types');
define('_MI_QUOTES_MIMETYPES_DESC', 'Set the mime types selected');
define('_MI_QUOTES_IDPAYPAL', 'Paypal ID');
define('_MI_QUOTES_IDPAYPAL_DESC', 'Insert here your PayPal ID for donactions.');
define('_MI_QUOTES_ADVERTISE', 'Advertisement Code');
define('_MI_QUOTES_ADVERTISE_DESC', 'Insert here the advertisement code');
define('_MI_QUOTES_BOOKMARKS', 'Social Bookmarks');
define('_MI_QUOTES_BOOKMARKS_DESC', 'Show Social Bookmarks in the form');
define('_MI_QUOTES_FBCOMMENTS', 'Facebook comments');
define('_MI_QUOTES_FBCOMMENTS_DESC', 'Allow Facebook comments in the form');
// Notifications
define('_MI_QUOTES_GLOBAL_NOTIFY', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_NOTIFY', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('_MI_QUOTES_FILE_NOTIFY', 'Quotes');
define('_MI_QUOTES_FILE_NOTIFY_DESC', 'Notifications for an individual quote');
define('_MI_QUOTES_GLOBAL_NEWCATEGORY_NOTIFY', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_NEWCATEGORY_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_NEWCATEGORY_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_NEWCATEGORY_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILEMODIFY_NOTIFY', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILEMODIFY_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILEMODIFY_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILEMODIFY_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILEBROKEN_NOTIFY', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILEBROKEN_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILEBROKEN_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILEBROKEN_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILESUBMIT_NOTIFY', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILESUBMIT_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILESUBMIT_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_FILESUBMIT_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_NEWFILE_NOTIFY', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_NEWFILE_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_NEWFILE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('_MI_QUOTES_GLOBAL_NEWFILE_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_FILESUBMIT_NOTIFY', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_FILESUBMIT_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_FILESUBMIT_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_FILESUBMIT_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_NEWFILE_NOTIFY', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_NEWFILE_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_NEWFILE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('_MI_QUOTES_CATEGORY_NEWFILE_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('_MI_QUOTES_FILE_APPROVE_NOTIFY', 'Quote approved');
define('_MI_QUOTES_FILE_APPROVE_NOTIFY_CAPTION', 'Notify me when this quote is approved');
define('_MI_QUOTES_FILE_APPROVE_NOTIFY_DESC', 'Receive a notification when this quote is approved.');
define('_MI_QUOTES_FILE_APPROVE_NOTIFY_SUBJECT', 'Quote approved');

// Help
define('_MI_QUOTES_DIRNAME', basename(dirname(__DIR__, 2)));
define('_MI_QUOTES_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_QUOTES_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_QUOTES_OVERVIEW', 'Overview');
// The name of this module
//define('_MI_QUOTES_NAME', 'YYYYY Module Name');

//define('_MI_QUOTES_HELP_DIR', __DIR__);

//help multipage
define('_MI_QUOTES_DISCLAIMER', 'Disclaimer');
define('_MI_QUOTES_LICENSE', 'License');
define('_MI_QUOTES_SUPPORT', 'Support');
//define('_MI_QUOTES_REQUIREMENTS', 'Requirements');
//define('_MI_QUOTES_CREDITS', 'Credits');
//define('_MI_QUOTES_HOWTO', 'How To');
//define('_MI_QUOTES_UPDATE', 'Update');
//define('_MI_QUOTES_INSTALL', 'Install');
//define('_MI_QUOTES_HISTORY', 'History');
//define('_MI_QUOTES_HELP1', 'YYYYY');
//define('_MI_QUOTES_HELP2', 'YYYYY');
//define('_MI_QUOTES_HELP3', 'YYYYY');
//define('_MI_QUOTES_HELP4', 'YYYYY');
//define('_MI_QUOTES_HELP5', 'YYYYY');
//define('_MI_QUOTES_HELP6', 'YYYYY');

// Permissions Groups
define('_MI_QUOTES_GROUPS', 'Groups access');
define('_MI_QUOTES_GROUPS_DESC', 'Select general access permission for groups.');
define('_MI_QUOTES_ADMINGROUPS', 'Admin Group Permissions');
define('_MI_QUOTES_ADMINGROUPS_DESC', 'Which groups have access to tools and permissions page');

//define('_MI_QUOTES_SHOW_SAMPLE_BUTTON', 'Import Sample Button?');
//define('_MI_QUOTES_SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');
