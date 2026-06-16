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

use Xmf\Language;

// comment callback functions

/**
 * @param $category
 * @param $item_id
 */
function quotes_notify_iteminfo($category, $item_id)
{
    $moduleDirName = \basename(\dirname(__DIR__));

    if (empty($GLOBALS['xoopsModule']) || 'quotes' !== $GLOBALS['xoopsModule']->getVar('dirname')) {
        /** @var \XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $module        = $moduleHandler->getByDirname('quotes');
        /** @var \XoopsConfigHandler \$configHandler */
        $configHandler = xoops_getHandler('config');
        $config        = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
    } else {
        $module = $GLOBALS['xoopsModule'];
        $config = $GLOBALS['xoopsModuleConfig'];
    }

    Language::load('main', $moduleDirName);

    if ('global' === $category) {
        $item['name'] = '';
        $item['url']  = '';

        return $item;
    }

    if ('category' === $category) {
        // Assume we have a valid category id
        $sql    = 'SELECT title FROM ' . $GLOBALS['xoopsDB']->prefix('quotes_category') . ' WHERE id = ' . (int)$item_id;
        $result = $GLOBALS['xoopsDB']->query($sql);
        if (!$GLOBALS['xoopsDB']->isResultSet($result) || !($result instanceof \mysqli_result)) {
            return null;
        }
        $row = (($GLOBALS['xoopsDB']->isResultSet($result) && ($result instanceof \mysqli_result)) ? $GLOBALS['xoopsDB']->fetchArray($result) : false);
        if (false === $row) {
            return null;
        }
        $item['name'] = $row['title'];
        $item['url']  = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/category.php?op=view&id=' . (int)$item_id;

        return $item;
    }

    if ('file' === $category) {
        // Assume we have a valid link id
        $sql    = 'SELECT id, quote FROM ' . $GLOBALS['xoopsDB']->prefix('quotes_quote') . ' WHERE id = ' . (int)$item_id;
        $result = $GLOBALS['xoopsDB']->query($sql);
        if (!$GLOBALS['xoopsDB']->isResultSet($result) || !($result instanceof \mysqli_result)) {
            return null;
        }
        $row = (($GLOBALS['xoopsDB']->isResultSet($result) && ($result instanceof \mysqli_result)) ? $GLOBALS['xoopsDB']->fetchArray($result) : false);
        if (false === $row) {
            return null;
        }
        $item['name'] = $row['quote'];
        $item['url']  = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/quote.php?op=view&id=' . (int)$row['id'];

        return $item;
    }

    return null;
}
