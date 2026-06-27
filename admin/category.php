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

use Xmf\Module\Helper\Permission;
use Xmf\Request;

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = Request::getString('op', 'list', 'REQUEST');
$order = \strtolower(Request::getString('order', 'desc', 'GET'));
$order = \in_array($order, ['asc', 'desc'], true) ? $order : 'desc';
$sort  = Request::getString('sort', 'id', 'GET');
$sort  = \in_array($sort, ['id', 'pid', 'title', 'weight', 'color', 'online'], true) ? $sort : 'id';

$adminObject->displayNavigation(basename(__FILE__));
$permHelper = new Permission();
$uploadDir  = \Xoops\Helpers\Service\Path::moduleUpload('quotes', 'category') . '/';
$uploadUrl  = \Xoops\Helpers\Service\Url::moduleUpload('quotes', 'category') . '/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(_AM_QUOTES_CATEGORY_LIST, 'category.php', 'list');
        $adminObject->displayButton('left');

        $categoryObject = $categoryHandler->create();
        $form           = $categoryObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('category.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Shared hydrate/upload/insert logic (also used by the frontend save handler).
        $result         = $categoryHandler->saveFromRequest($helper);
        $categoryObject = $result['object'];
        //Permissions
        //===============================================================

        $mid = $GLOBALS['xoopsModule']->mid();
        /** @var \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = xoops_getHandler('groupperm');
        $id               = Request::getInt('id', 0, 'POST');

        /**
         * @param $myArray
         * @param $permissionGroup
         * @param $id
         * @param $grouppermHandler
         * @param $permissionName
         * @param $mid
         */
        function setPermissions($myArray, $permissionGroup, $id, $grouppermHandler, $permissionName, $mid): void
        {
            $permissionArray = $myArray;
            if ($id > 0) {
                $sql = 'DELETE FROM `' . $GLOBALS['xoopsDB']->prefix('group_permission') . '` WHERE `gperm_name` = ' . $GLOBALS['xoopsDB']->quote((string)$permissionName) . ' AND `gperm_itemid`= ' . (int)$id;
                $GLOBALS['xoopsDB']->exec($sql);
            }
            //admin
            $gperm = $grouppermHandler->create();
            $gperm->setVar('gperm_groupid', XOOPS_GROUP_ADMIN);
            $gperm->setVar('gperm_name', $permissionName);
            $gperm->setVar('gperm_modid', $mid);
            $gperm->setVar('gperm_itemid', $id);
            $grouppermHandler->insert($gperm);
            unset($gperm);
            //non-Admin groups
            if (is_array($permissionArray)) {
                foreach ($permissionArray as $key => $cat_groupperm) {
                    if ($cat_groupperm > 0) {
                        $gperm = $grouppermHandler->create();
                        $gperm->setVar('gperm_groupid', $cat_groupperm);
                        $gperm->setVar('gperm_name', $permissionName);
                        $gperm->setVar('gperm_modid', $mid);
                        $gperm->setVar('gperm_itemid', $id);
                        $grouppermHandler->insert($gperm);
                        unset($gperm);
                    }
                }
            } elseif ($permissionArray > 0) {
                $gperm = $grouppermHandler->create();
                $gperm->setVar('gperm_groupid', $permissionArray);
                $gperm->setVar('gperm_name', $permissionName);
                $gperm->setVar('gperm_modid', $mid);
                $gperm->setVar('gperm_itemid', $id);
                $grouppermHandler->insert($gperm);
                unset($gperm);
            }
        }

        //setPermissions for View items
        $permissionGroup   = 'groupsRead';
        $permissionName    = 'quotes_view';
        $permissionArray   = Request::getArray($permissionGroup, [], 'POST');
        $permissionArray[] = XOOPS_GROUP_ADMIN;
        //setPermissions($permissionArray, $permissionGroup, $id, $grouppermHandler, $permissionName, $mid);
        $permHelper->savePermissionForItem($permissionName, $id, $permissionArray);

        //setPermissions for Submit items
        $permissionGroup   = 'groupsSubmit';
        $permissionName    = 'quotes_submit';
        $permissionArray   = Request::getArray($permissionGroup, [], 'POST');
        $permissionArray[] = XOOPS_GROUP_ADMIN;
        //setPermissions($permissionArray, $permissionGroup, $id, $grouppermHandler, $permissionName, $mid);
        $permHelper->savePermissionForItem($permissionName, $id, $permissionArray);

        //setPermissions for Approve items
        $permissionGroup   = 'groupsModeration';
        $permissionName    = 'quotes_approve';
        $permissionArray   = Request::getArray($permissionGroup, [], 'POST');
        $permissionArray[] = XOOPS_GROUP_ADMIN;
        //setPermissions($permissionArray, $permissionGroup, $id, $grouppermHandler, $permissionName, $mid);
        $permHelper->savePermissionForItem($permissionName, $id, $permissionArray);

        /*
                    //Form quotes_view
                    $arr_quotes_view = Request::getArray('cat_gperms_read');
                    if ($id > 0) {
                        $sql
                            =
                            'DELETE FROM `' . $GLOBALS['xoopsDB']->prefix('group_permission') . "` WHERE `gperm_name`='quotes_view' AND `gperm_itemid`=$id;";
                        $GLOBALS['xoopsDB']->exec($sql);
                    }
                    //admin
                    $gperm = $grouppermHandler->create();
                    $gperm->setVar('gperm_groupid', XOOPS_GROUP_ADMIN);
                    $gperm->setVar('gperm_name', 'quotes_view');
                    $gperm->setVar('gperm_modid', $mid);
                    $gperm->setVar('gperm_itemid', $id);
                    $grouppermHandler->insert($gperm);
                    unset($gperm);
                    if (is_array($arr_quotes_view)) {
                        foreach ($arr_quotes_view as $key => $cat_groupperm) {
                            $gperm = $grouppermHandler->create();
                            $gperm->setVar('gperm_groupid', $cat_groupperm);
                            $gperm->setVar('gperm_name', 'quotes_view');
                            $gperm->setVar('gperm_modid', $mid);
                            $gperm->setVar('gperm_itemid', $id);
                            $grouppermHandler->insert($gperm);
                            unset($gperm);
                        }
                    } else {
                        $gperm = $grouppermHandler->create();
                        $gperm->setVar('gperm_groupid', $arr_quotes_view);
                        $gperm->setVar('gperm_name', 'quotes_view');
                        $gperm->setVar('gperm_modid', $mid);
                        $gperm->setVar('gperm_itemid', $id);
                        $grouppermHandler->insert($gperm);
                        unset($gperm);
                    }
        */

        //===============================================================

        if ($result['ok']) {
            redirect_header('category.php?op=list', 2, _AM_QUOTES_FORMOK);
        }

        echo $result['errors'];
        $form = $result['object']->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(_AM_QUOTES_ADD_CATEGORY, 'category.php?op=new', 'add');
        $adminObject->addItemButton(_AM_QUOTES_CATEGORY_LIST, 'category.php', 'list');
        $adminObject->displayButton('left');
        $categoryObject = $categoryHandler->get(Request::getInt('id', 0, 'GET'));
        $form           = $categoryObject->getForm();
        $form->display();
        break;
    case 'delete':
        $selectedIds = \array_filter(\array_map('intval', Request::getArray('category_id', [], 'POST')));
        $postedIds   = \array_filter(\array_map('intval', \explode(',', Request::getString('ids', '', 'POST'))));
        $deleteIds   = $postedIds ?: $selectedIds;

        if (1 === Request::getInt('ok', 0, 'POST')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('category.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ([] === $deleteIds) {
                $deleteIds = [Request::getInt('id', 0, 'POST')];
            }
            $deleted = 0;
            foreach ($deleteIds as $deleteId) {
                $categoryObject = $categoryHandler->get($deleteId);
                if (\is_object($categoryObject) && $categoryHandler->delete($categoryObject)) {
                    ++$deleted;
                }
            }
            if ($deleted > 0) {
                redirect_header('category.php', 3, _AM_QUOTES_FORMDELOK);
            } else {
                redirect_header('category.php', 3, _ERRORS);
            }
        } else {
            if ([] !== $deleteIds) {
                xoops_confirm(['ok' => 1, 'ids' => \implode(',', $deleteIds), 'op' => 'delete'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(_AM_QUOTES_FORMSUREDEL, \implode(', ', $deleteIds)));
                break;
            }
            $categoryObject = $categoryHandler->get(Request::getInt('id', 0, 'GET'));
            if (!\is_object($categoryObject)) {
                redirect_header('category.php', 3, _ERRORS);
            }
            xoops_confirm(['ok' => 1, 'id' => Request::getInt('id', 0, 'GET'), 'op' => 'delete'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(_AM_QUOTES_FORMSUREDEL, $categoryObject->getVar('title')));
        }
        break;
    case 'clone':
        // State-changing action: require a POST confirmation with a valid CSRF token.
        if (1 === Request::getInt('ok', 0, 'POST')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('category.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $id_field = Request::getInt('id', 0, 'POST');
            if ($utility::cloneRecord('quotes_category', 'id', $id_field)) {
                redirect_header('category.php', 3, _AM_QUOTES_CLONED_OK);
            } else {
                redirect_header('category.php', 3, _AM_QUOTES_CLONED_FAILED);
            }
        } else {
            $id_field = Request::getInt('id', 0, 'GET');
            xoops_confirm(['ok' => 1, 'id' => $id_field, 'op' => 'clone'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(_AM_QUOTES_FORMSURECLONE, $id_field));
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(_AM_QUOTES_ADD_CATEGORY, 'category.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                   = Request::getInt('start', 0, 'GET');
        $categoryPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id ASC, title');
        $criteria->setOrder('ASC');
        $criteria->setLimit($categoryPaginationLimit);
        $criteria->setStart($start);
        $categoryTempRows  = $categoryHandler->getCount();
        $categoryTempArray = $categoryHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>"._AM_QUOTES_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($categoryTempRows > $categoryPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $categoryTempRows,
                $categoryPaginationLimit,
                $start,
                'start',
                'op=list' . '&sort=' . $sort . '&order=' . $order
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
        }

        $GLOBALS['xoopsTpl']->assign('categoryRows', $categoryTempRows);
        $categoryArray = [];

        //    $fields = explode('|', id:int:8::NOT NULL::primary:ID:0|pid:int:8::NOT NULL:0::Parent:1|title:varchar:255::NOT NULL:::Category:2|description:text:0::NULL:::Description:3|image:varchar:255::NULL:::Image:4|weight:int:5::NOT NULL:0::Weight:5|color:varchar:10::NOT NULL:0::Color:6|online:tinyint:1::NOT NULL:1::Online:7);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($categoryPaginationLimit);
        $criteria->setStart($start);

        $categoryCount     = $categoryHandler->getCount($criteria);
        $categoryTempArray = $categoryHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($categoryCount > 0) {
            foreach (array_keys($categoryTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorid', _AM_QUOTES_CATEGORY_ID);
                $categoryArray['id'] = $categoryTempArray[$i]->getVar('id');

                $GLOBALS['xoopsTpl']->assign('selectorpid', _AM_QUOTES_CATEGORY_PID);
                $categoryArray['pid'] = $categoryTempArray[$i]->getVar('pid');

                $GLOBALS['xoopsTpl']->assign('selectortitle', _AM_QUOTES_CATEGORY_TITLE);
                $categoryArray['title'] = $categoryTempArray[$i]->getVar('title');
                $categoryArray['title'] = $utility::truncateHtml($categoryArray['title'], $helper->getConfig('truncatelength'));

                $GLOBALS['xoopsTpl']->assign('selectordescription', _AM_QUOTES_CATEGORY_DESCRIPTION);
                $categoryArray['description'] = $categoryTempArray[$i]->getVar('description');
                $categoryArray['description'] = $utility::truncateHtml($categoryArray['description'], $helper->getConfig('truncatelength'));

                $GLOBALS['xoopsTpl']->assign('selectorimage', _AM_QUOTES_CATEGORY_IMAGE);
                $categoryImage          = (string)$categoryTempArray[$i]->getVar('image');
                $categoryArray['image'] = '' !== $categoryImage ? "<img src='" . $uploadUrl . \Xoops\Helpers\Utility\HtmlBuilder::escape($categoryImage) . "' alt='' style='max-width:100px'>" : '';

                $selectorweight = $utility::selectSorting(_AM_QUOTES_CATEGORY_WEIGHT, 'weight', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorweight', $selectorweight);
                $categoryArray['weight'] = $categoryTempArray[$i]->getVar('weight');

                $selectorcolor = $utility::selectSorting(_AM_QUOTES_CATEGORY_COLOR, 'color', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorcolor', $selectorcolor);
                $categoryArray['color'] = $categoryTempArray[$i]->getVar('color');

                $selectoronline = $utility::selectSorting(_AM_QUOTES_CATEGORY_ONLINE, 'online', $helper);
                $GLOBALS['xoopsTpl']->assign('selectoronline', $selectoronline);
                $categoryArray['online']      = $categoryTempArray[$i]->getVar('online');
                $categoryId                    = (int)$categoryArray['id'];
                $categoryArray['edit_delete'] = "<a href='category.php?op=edit&amp;id={$categoryId}'><img src='{$pathIcon16}/edit.png' alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='category.php?op=delete&amp;id={$categoryId}'><img src='{$pathIcon16}/delete.png' alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='category.php?op=clone&amp;id={$categoryId}'><img src='{$pathIcon16}/editcopy.png' alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->appendByRef('categoryArrays', $categoryArray);
                unset($categoryArray);
            }
            unset($categoryTempArray);
            // Display Navigation
            if ($categoryCount > $categoryPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $categoryCount,
                    $categoryPaginationLimit,
                    $start,
                    'start',
                    'op=list' . '&sort=' . $sort . '&order=' . $order
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='category.php?op=edit&id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='category.php?op=delete&id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>"._AM_QUOTES_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='9'>There are noXXX category</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/quotes_admin_category.tpl'
            );
        }

        break;
}
require_once __DIR__ . '/admin_footer.php';
