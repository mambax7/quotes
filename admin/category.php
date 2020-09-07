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

use Xmf\Request;

require __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = \Xmf\Request::getString('op', 'list');
$order = \Xmf\Request::getString('order', 'desc');
$sort  = \Xmf\Request::getString('sort', '');

$adminObject->displayNavigation(basename(__FILE__));
/** @var \Xmf\Module\Helper\Permission $permHelper */
$permHelper = new \Xmf\Module\Helper\Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/quotes/category/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/quotes/category/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_QUOTES_CATEGORY_LIST, 'category.php', 'list');
        $adminObject->displayButton('left');

        $categoryObject = $categoryHandler->create();
        $form           = $categoryObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('category.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('id', 0)) {
            $categoryObject = $categoryHandler->get(Request::getInt('id', 0));
        } else {
            $categoryObject = $categoryHandler->create();
        }
        // Form save fields
        $categoryObject->setVar('pid', Request::getVar('pid', ''));
        $categoryObject->setVar('title', Request::getVar('title', ''));
        $categoryObject->setVar('description', Request::getText('description', ''));

        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadDir = XOOPS_UPLOAD_PATH . '/quotes/images/';
        $uploader  = new \XoopsMediaUploader(
            $uploadDir, $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null
        );
        if ($uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0])) {
            //$extension = preg_replace( '/^.+\.([^.]+)$/sU' , '' , $_FILES['attachedfile']['name']);
            //$imgName = str_replace(' ', '', $_POST['image']).'.'.$extension;

            $uploader->setPrefix('image_');
            $uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0]);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            } else {
                $categoryObject->setVar('image', $uploader->getSavedFileName());
            }
        } else {
            $categoryObject->setVar('image', Request::getVar('image', ''));
        }

        $categoryObject->setVar('weight', Request::getVar('weight', ''));
        $categoryObject->setVar('color', Request::getVar('color', ''));
        $categoryObject->setVar('online', ((1 == \Xmf\Request::getInt('online', 0)) ? '1' : '0'));
        //Permissions
        //===============================================================

        $mid = $GLOBALS['xoopsModule']->mid();
        /** @var \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = xoops_getHandler('groupperm');
        $id               = \Xmf\Request::getInt('id', 0);

        /**
         * @param $myArray
         * @param $permissionGroup
         * @param $id
         * @param $grouppermHandler
         * @param $permissionName
         * @param $mid
         */
        function setPermissions($myArray, $permissionGroup, $id, $grouppermHandler, $permissionName, $mid)
        {
            $permissionArray = $myArray;
            if ($id > 0) {
                $sql = 'DELETE FROM `' . $GLOBALS['xoopsDB']->prefix('group_permission') . "` WHERE `gperm_name` = '" . $permissionName . "' AND `gperm_itemid`= $id;";
                $GLOBALS['xoopsDB']->query($sql);
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
        $permissionArray   = \Xmf\Request::getArray($permissionGroup, '');
        $permissionArray[] = XOOPS_GROUP_ADMIN;
        //setPermissions($permissionArray, $permissionGroup, $id, $grouppermHandler, $permissionName, $mid);
        $permHelper->savePermissionForItem($permissionName, $id, $permissionArray);

        //setPermissions for Submit items
        $permissionGroup   = 'groupsSubmit';
        $permissionName    = 'quotes_submit';
        $permissionArray   = \Xmf\Request::getArray($permissionGroup, '');
        $permissionArray[] = XOOPS_GROUP_ADMIN;
        //setPermissions($permissionArray, $permissionGroup, $id, $grouppermHandler, $permissionName, $mid);
        $permHelper->savePermissionForItem($permissionName, $id, $permissionArray);

        //setPermissions for Approve items
        $permissionGroup   = 'groupsModeration';
        $permissionName    = 'quotes_approve';
        $permissionArray   = \Xmf\Request::getArray($permissionGroup, '');
        $permissionArray[] = XOOPS_GROUP_ADMIN;
        //setPermissions($permissionArray, $permissionGroup, $id, $grouppermHandler, $permissionName, $mid);
        $permHelper->savePermissionForItem($permissionName, $id, $permissionArray);

        /*
                    //Form quotes_view
                    $arr_quotes_view = \Xmf\Request::getArray('cat_gperms_read');
                    if ($id > 0) {
                        $sql
                            =
                            'DELETE FROM `' . $GLOBALS['xoopsDB']->prefix('group_permission') . "` WHERE `gperm_name`='quotes_view' AND `gperm_itemid`=$id;";
                        $GLOBALS['xoopsDB']->query($sql);
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

        if ($categoryHandler->insert($categoryObject)) {
            redirect_header('category.php?op=list', 2, AM_QUOTES_FORMOK);
        }

        echo $categoryObject->getHtmlErrors();
        $form = $categoryObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_QUOTES_ADD_CATEGORY, 'category.php?op=new', 'add');
        $adminObject->addItemButton(AM_QUOTES_CATEGORY_LIST, 'category.php', 'list');
        $adminObject->displayButton('left');
        $categoryObject = $categoryHandler->get(Request::getString('id', ''));
        $form           = $categoryObject->getForm();
        $form->display();
        break;

    case 'delete':
        $categoryObject = $categoryHandler->get(Request::getString('id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('category.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($categoryHandler->delete($categoryObject)) {
                redirect_header('category.php', 3, AM_QUOTES_FORMDELOK);
            } else {
                echo $categoryObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'id' => Request::getString('id', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_QUOTES_FORMSUREDEL, $categoryObject->getVar('title')));
        }
        break;

    case 'clone':

        $id_field = \Xmf\Request::getString('id', '');

        if ($utility::cloneRecord('quotes_category', 'id', $id_field)) {
            redirect_header('category.php', 3, AM_QUOTES_CLONED_OK);
        } else {
            redirect_header('category.php', 3, AM_QUOTES_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_QUOTES_ADD_CATEGORY, 'category.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                   = \Xmf\Request::getInt('start', 0);
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
                            <th class='center width5'>".AM_QUOTES_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($categoryTempRows > $categoryPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $categoryTempRows, $categoryPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
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

                $GLOBALS['xoopsTpl']->assign('selectorid', AM_QUOTES_CATEGORY_ID);
                $categoryArray['id'] = $categoryTempArray[$i]->getVar('id');

                $GLOBALS['xoopsTpl']->assign('selectorpid', AM_QUOTES_CATEGORY_PID);
                $categoryArray['pid'] = $categoryTempArray[$i]->getVar('pid');

                $GLOBALS['xoopsTpl']->assign('selectortitle', AM_QUOTES_CATEGORY_TITLE);
                $categoryArray['title'] = $categoryTempArray[$i]->getVar('title');
                $categoryArray['title'] = $utility::truncateHtml($categoryArray['title'], $helper->getConfig('truncatelength'));

                $GLOBALS['xoopsTpl']->assign('selectordescription', AM_QUOTES_CATEGORY_DESCRIPTION);
                $categoryArray['description'] = $categoryTempArray[$i]->getVar('description');
                $categoryArray['description'] = $utility::truncateHtml($categoryArray['description'], $helper->getConfig('truncatelength'));

                $GLOBALS['xoopsTpl']->assign('selectorimage', AM_QUOTES_CATEGORY_IMAGE);
                $categoryArray['image'] = "<img src='" . $uploadUrl . $categoryTempArray[$i]->getVar('image') . "' name='" . 'name' . "' id=" . 'id' . " alt='' style='max-width:100px'>";
                $categoryArray['image'] = $utility::truncateHtml($categoryArray['image'], $helper->getConfig('truncatelength'));

                $selectorweight = $utility::selectSorting(AM_QUOTES_CATEGORY_WEIGHT, 'weight', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorweight', $selectorweight);
                $categoryArray['weight'] = $categoryTempArray[$i]->getVar('weight');

                $selectorcolor = $utility::selectSorting(AM_QUOTES_CATEGORY_COLOR, 'color', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorcolor', $selectorcolor);
                $categoryArray['color'] = $categoryTempArray[$i]->getVar('color');

                $selectoronline = $utility::selectSorting(AM_QUOTES_CATEGORY_ONLINE, 'online', $helper);
                $GLOBALS['xoopsTpl']->assign('selectoronline', $selectoronline);
                $categoryArray['online']      = $categoryTempArray[$i]->getVar('online');
                $categoryArray['edit_delete'] = "<a href='category.php?op=edit&id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='category.php?op=delete&id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='category.php?op=clone&id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->append_by_ref('categoryArrays', $categoryArray);
                unset($categoryArray);
            }
            unset($categoryTempArray);
            // Display Navigation
            if ($categoryCount > $categoryPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $categoryCount, $categoryPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
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

            //                     <th class='center width5'>".AM_QUOTES_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='9'>There are noXXX category</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/quotes_admin_category.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
