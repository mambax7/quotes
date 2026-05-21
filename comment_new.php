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

use XoopsModules\Quote;

require_once \dirname(__DIR__, 2) . '/mainfile.php';
//require XOOPS_ROOT_PATH.'/modules/quote/class/author.php';
$com_itemid = \Xmf\Request::getInt('com_itemid', 0);
if ($com_itemid > 0) {
    /** @var \XoopsPersistableObjectHandler $authorHandler */
    $authorHandler = $helper->getHandler('Author');

    $author         = $authorHandler->get($com_itemid);
    $com_replytitle = $author->getVar('name');
    require XOOPS_ROOT_PATH . '/include/comment_new.php';
}
