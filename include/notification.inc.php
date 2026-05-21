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

use Xmf\Language;

// comment callback functions

/**
 * @param $category
 * @param $item_id
 */
function quote_notify_iteminfo($category, $item_id)
{
    $moduleDirName = \basename(\dirname(__DIR__));

    if (empty($GLOBALS['xoopsModule']) || 'quote' !== $GLOBALS['xoopsModule']->getVar('dirname')) {
        /** @var \XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $module        = $moduleHandler->getByDirname('quote');
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
        $sql           = 'SELECT _title FROM ' . $GLOBALS['xoopsDB']->prefix('quote_cat') . ' WHERE _cid = ' . $item_id;
        $result        = $GLOBALS['xoopsDB']->query($sql); // TODO: error check
        $resultArrayay = (($GLOBALS['xoopsDB']->isResultSet($result) && ($result instanceof \mysqli_result)) ? $GLOBALS['xoopsDB']->fetchArray($result) : false);
        $item['name']  = $resultArrayay['_title'];
        $item['url']   = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/cat_view.php?_cid=' . $item_id;

        return $item;
    }

    if ('' == $category) {
        // Assume we have a valid link id
        $sql           = 'SELECT _cid, _title FROM ' . $GLOBALS['xoopsDB']->prefix('quote_category') . ' WHERE _lid = ' . $item_id;
        $result        = $GLOBALS['xoopsDB']->query($sql); // TODO: error check
        $resultArrayay = (($GLOBALS['xoopsDB']->isResultSet($result) && ($result instanceof \mysqli_result)) ? $GLOBALS['xoopsDB']->fetchArray($result) : false);
        $item['name']  = $resultArrayay['title'];
        $item['url']   = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/quote_visit.php?_cid=' . $resultArrayay['_cid'] . '&amp;_lid=' . $item_id;

        return $item;
    }

    return null;
}
