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

use Xmf\Request;
use XoopsModules\Quotes\Helper;

require_once \dirname(__DIR__, 2) . '/mainfile.php';
require __DIR__ . '/bootstrap.php';

$mtoolsDependencyError = quotes_mtools_dependency_error();
if ('' !== $mtoolsDependencyError) {
    redirect_header(XOOPS_URL, 3, $mtoolsDependencyError);
    exit;
}

require __DIR__ . '/include/common.php';

//require XOOPS_ROOT_PATH.'/modules/quotes/class/author.php';
$com_itemid = Request::getInt('com_itemid', 0, 'GET');
if ($com_itemid > 0) {
    /** @var \XoopsPersistableObjectHandler $authorHandler */
    $helper        = Helper::getInstance();
    $authorHandler = $helper->getHandler('Author');

    $author         = $authorHandler->get($com_itemid);
    $com_replytitle = $author->getVar('name');
    require XOOPS_ROOT_PATH . '/include/comment_new.php';
}
