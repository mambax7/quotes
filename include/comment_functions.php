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

use XoopsModules\Quotes\Helper;

/** @var Helper $helper */
/**
 * CommentsUpdate
 *
 * @return bool
 */
function quotesCommentsUpdate(mixed $itemId, mixed $commentCount)
{
    $helper = Helper::getInstance();
    /** @var \XoopsPersistableObjectHandler $helper- >getHandler('Author') */
    if (!$helper->getHandler('Author')->updateAll('comments', (int)$commentCount, new \Criteria('lid', (int)$itemId))) {
        return false;
    }

    return true;
}

/**
 * CommentsApprove
 *
 * @param string $comment
 */
function quotesCommentsApprove(&$comment): void
{
    // notification mail here
}
