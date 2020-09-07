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
// Admin
define('MI_QUOTES_NAME', 'Quotes');
define('MI_QUOTES_DESC', '&lt;p&gt;This module is displaying random quotes or testimonials...&lt;/p&gt;');
//Menu
define('MI_QUOTES_ADMENU1', 'Home');
define('MI_QUOTES_ADMENU2', 'Quote');
define('MI_QUOTES_ADMENU3', 'Category');
define('MI_QUOTES_ADMENU4', 'Author');
define('MI_QUOTES_ADMENU5', 'Feedback');
define('MI_QUOTES_ADMENU6', 'Migrate');
define('MI_QUOTES_ADMENU7', 'About');
define('MI_QUOTES_ADMENU8', 'Permissions');
//Blocks
define('MI_QUOTES_QUOTE_BLOCK', 'Quote block');
define('MI_QUOTES_CATEGORY_BLOCK', 'Category block');
define('MI_QUOTES_AUTHOR_BLOCK', 'Author block');
//Config
define('MI_QUOTES_EDITOR_ADMIN', 'Editor: Admin');
define('MI_QUOTES_EDITOR_ADMIN_DESC', 'Select the Editor to use by the Admin');
define('MI_QUOTES_EDITOR_USER', 'Editor: User');
define('MI_QUOTES_EDITOR_USER_DESC', 'Select the Editor to use by the User');
define('MI_QUOTES_KEYWORDS', 'Keywords');
define('MI_QUOTES_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
define('MI_QUOTES_ADMINPAGER', 'Admin: records / page');
define('MI_QUOTES_ADMINPAGER_DESC', 'Admin: # of records shown per page');
define('MI_QUOTES_USERPAGER', 'User: records / page');
define('MI_QUOTES_USERPAGER_DESC', 'User: # of records shown per page');
define('MI_QUOTES_MAXSIZE', 'Max size');
define('MI_QUOTES_MAXSIZE_DESC', 'Set a number of max size uploads file in byte');
define('MI_QUOTES_MIMETYPES', 'Mime Types');
define('MI_QUOTES_MIMETYPES_DESC', 'Set the mime types selected');
define('MI_QUOTES_IDPAYPAL', 'Paypal ID');
define('MI_QUOTES_IDPAYPAL_DESC', 'Insert here your PayPal ID for donactions.');
define('MI_QUOTES_ADVERTISE', 'Advertisement Code');
define('MI_QUOTES_ADVERTISE_DESC', 'Insert here the advertisement code');
define('MI_QUOTES_BOOKMARKS', 'Social Bookmarks');
define('MI_QUOTES_BOOKMARKS_DESC', 'Show Social Bookmarks in the form');
define('MI_QUOTES_FBCOMMENTS', 'Facebook comments');
define('MI_QUOTES_FBCOMMENTS_DESC', 'Allow Facebook comments in the form');
// Notifications
define('MI_QUOTES_GLOBAL_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_FILE_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_FILE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_NEWCATEGORY_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_NEWCATEGORY_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_NEWCATEGORY_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_NEWCATEGORY_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILEMODIFY_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILEMODIFY_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILEMODIFY_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILEMODIFY_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILEBROKEN_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILEBROKEN_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILEBROKEN_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILEBROKEN_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILESUBMIT_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILESUBMIT_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILESUBMIT_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_FILESUBMIT_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_NEWFILE_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_NEWFILE_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_NEWFILE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_GLOBAL_NEWFILE_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_FILESUBMIT_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_FILESUBMIT_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_FILESUBMIT_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_FILESUBMIT_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_NEWFILE_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_NEWFILE_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_NEWFILE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_CATEGORY_NEWFILE_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_QUOTES_FILE_APPROVE_NOTIFY', 'Allow Facebook comments in the form');
define('MI_QUOTES_FILE_APPROVE_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_QUOTES_FILE_APPROVE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_QUOTES_FILE_APPROVE_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');

// Help
define('MI_QUOTES_DIRNAME', basename(dirname(dirname(__DIR__))));
define('MI_QUOTES_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('MI_QUOTES_BACK_2_ADMIN', 'Back to Administration of ');
define('MI_QUOTES_OVERVIEW', 'Overview');
// The name of this module
//define('MI_QUOTES_NAME', 'YYYYY Module Name');

//define('MI_QUOTES_HELP_DIR', __DIR__);

//help multi-page
define('MI_QUOTES_DISCLAIMER', 'Disclaimer');
define('MI_QUOTES_LICENSE', 'License');
define('MI_QUOTES_SUPPORT', 'Support');
//define('MI_QUOTES_REQUIREMENTS', 'Requirements');
//define('MI_QUOTES_CREDITS', 'Credits');
//define('MI_QUOTES_HOWTO', 'How To');
//define('MI_QUOTES_UPDATE', 'Update');
//define('MI_QUOTES_INSTALL', 'Install');
//define('MI_QUOTES_HISTORY', 'History');
//define('MI_QUOTES_HELP1', 'YYYYY');
//define('MI_QUOTES_HELP2', 'YYYYY');
//define('MI_QUOTES_HELP3', 'YYYYY');
//define('MI_QUOTES_HELP4', 'YYYYY');
//define('MI_QUOTES_HELP5', 'YYYYY');
//define('MI_QUOTES_HELP6', 'YYYYY');

// Permissions Groups
define('MI_QUOTES_GROUPS', 'Groups access');
define('MI_QUOTES_GROUPS_DESC', 'Select general access permission for groups.');
define('MI_QUOTES_ADMINGROUPS', 'Admin Group Permissions');
define('MI_QUOTES_ADMINGROUPS_DESC', 'Which groups have access to tools and permissions page');

//define('MI_QUOTES_SHOW_SAMPLE_BUTTON', 'Import Sample Button?');
//define('MI_QUOTES_SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');

