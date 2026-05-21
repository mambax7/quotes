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

use Xmf\Request;

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = \Xmf\Request::getString('op', 'list');
$order = \Xmf\Request::getString('order', 'desc');
$sort  = \Xmf\Request::getString('sort', '');

$adminObject->displayNavigation(basename(__FILE__));
/** @var \Xmf\Module\Helper\Permission $permHelper */
$permHelper = new \Xmf\Module\Helper\Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/quote/images/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/quote/images/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_QUOTE_AUTHORS_LIST, 'authors.php', 'list');
        $adminObject->displayButton('left');

        $authorsObject = $authorsHandler->create();
        $form          = $authorsObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('authors.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('id', 0)) {
            $authorsObject = $authorsHandler->get(Request::getInt('id', 0));
        } else {
            $authorsObject = $authorsHandler->create();
        }
        // Form save fields
        $authorsObject->setVar('name', Request::getVar('name', ''));
        $authorsObject->setVar('country', Request::getVar('country', ''));
        $authorsObject->setVar('bio', Request::getText('bio', ''));

        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadDir = XOOPS_UPLOAD_PATH . '/quote/images/';
        $uploader  = new \XoopsMediaUploader(
            $uploadDir,
            $helper->getConfig('mimetypes'),
            $helper->getConfig('maxsize'),
            null,
            null
        );
        if ($uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0])) {
            //$extension = preg_replace( '/^.+\.([^.]+)$/sU' , '' , $_FILES['attachedfile']['name']);
            //$imgName = str_replace(' ', '', $_POST['photo']).'.'.$extension;

            $uploader->setPrefix('photo_');
            $uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0]);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            } else {
                $authorsObject->setVar('photo', $uploader->getSavedFileName());
            }
        } else {
            $authorsObject->setVar('photo', Request::getVar('photo', ''));
        }

        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('created', '', 'POST'));

        $authorsObject->setVar('created', $dateTimeObj->getTimestamp());
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('updated', '', 'POST'));

        $authorsObject->setVar('updated', $dateTimeObj->getTimestamp());
        if ($authorsHandler->insert($authorsObject)) {
            redirect_header('authors.php?op=list', 2, AM_QUOTE_FORMOK);
        }

        echo $authorsObject->getHtmlErrors();
        $form = $authorsObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_QUOTE_ADD_AUTHORS, 'authors.php?op=new', 'add');
        $adminObject->addItemButton(AM_QUOTE_AUTHORS_LIST, 'authors.php', 'list');
        $adminObject->displayButton('left');
        $authorsObject = $authorsHandler->get(Request::getString('id', ''));
        $form          = $authorsObject->getForm();
        $form->display();
        break;
    case 'delete':
        $authorsObject = $authorsHandler->get(Request::getString('id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('authors.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($authorsHandler->delete($authorsObject)) {
                redirect_header('authors.php', 3, AM_QUOTE_FORMDELOK);
            } else {
                echo $authorsObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'id' => Request::getString('id', ''), 'op' => 'delete'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_QUOTE_FORMSUREDEL, $authorsObject->getVar('name')));
        }
        break;
    case 'clone':
        $id_field = \Xmf\Request::getString('id', '');

        if ($utility::cloneRecord('quote_authors', 'id', $id_field)) {
            redirect_header('authors.php', 3, AM_QUOTE_CLONED_OK);
        } else {
            redirect_header('authors.php', 3, AM_QUOTE_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_QUOTE_ADD_AUTHORS, 'authors.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                  = \Xmf\Request::getInt('start', 0);
        $authorsPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id ASC, name');
        $criteria->setOrder('ASC');
        $criteria->setLimit($authorsPaginationLimit);
        $criteria->setStart($start);
        $authorsTempRows  = $authorsHandler->getCount();
        $authorsTempArray = $authorsHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_QUOTE_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($authorsTempRows > $authorsPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $authorsTempRows,
                $authorsPaginationLimit,
                $start,
                'start',
                'op=list' . '&sort=' . $sort . '&order=' . $order
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }

        $GLOBALS['xoopsTpl']->assign('authorsRows', $authorsTempRows);
        $authorsArray = [];

        //    $fields = explode('|', id:int:8::NOT NULL:::ID:0|name:varchar:50::NOT NULL:::Name:1|country:varchar:3::NOT NULL:::Country:2|bio:text:::NOT NULL:::Bio:3|photo:varchar:50::NOT NULL:::Photo:4|created:int:11:UNSIGNED:NOT NULL:0::Created:5|updated:int:11::NOT NULL:0::Updated:6);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($authorsPaginationLimit);
        $criteria->setStart($start);

        $authorsCount     = $authorsHandler->getCount($criteria);
        $authorsTempArray = $authorsHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($authorsCount > 0) {
            foreach (array_keys($authorsTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorid', AM_QUOTE_AUTHORS_ID);
                $authorsArray['id'] = $authorsTempArray[$i]->getVar('id');

                $selectorname = $utility::selectSorting(AM_QUOTE_AUTHORS_NAME, 'name');
                $GLOBALS['xoopsTpl']->assign('selectorname', $selectorname);
                $authorsArray['name'] = $authorsTempArray[$i]->getVar('name');
                $authorsArray['name'] = $utility::truncateHtml($authorsArray['name'], $helper->getConfig('truncatelength'));

                $selectorcountry = $utility::selectSorting(AM_QUOTE_AUTHORS_COUNTRY, 'country');
                $GLOBALS['xoopsTpl']->assign('selectorcountry', $selectorcountry);
                $authorsArray['country'] = strip_tags((string) \XoopsLists::getCountryList()[$authorsTempArray[$i]->getVar('country')]);

                $GLOBALS['xoopsTpl']->assign('selectorbio', AM_QUOTE_AUTHORS_BIO);
                $authorsArray['bio'] = $authorsTempArray[$i]->getVar('bio');
                $authorsArray['bio'] = $utility::truncateHtml($authorsArray['bio'], $helper->getConfig('truncatelength'));

                $GLOBALS['xoopsTpl']->assign('selectorphoto', AM_QUOTE_AUTHORS_PHOTO);
                $authorsArray['photo'] = "<img src='" . $uploadUrl . $authorsTempArray[$i]->getVar('photo') . "' name='" . 'name' . "' id=" . 'id' . " alt='' style='max-width:100px'>";
                $authorsArray['photo'] = $utility::truncateHtml($authorsArray['photo'], $helper->getConfig('truncatelength'));

                $selectorcreated = $utility::selectSorting(AM_QUOTE_AUTHORS_CREATED, 'created');
                $GLOBALS['xoopsTpl']->assign('selectorcreated', $selectorcreated);
                $authorsArray['created'] = formatTimestamp($authorsTempArray[$i]->getVar('created'), 's');

                $selectorupdated = $utility::selectSorting(AM_QUOTE_AUTHORS_UPDATED, 'updated');
                $GLOBALS['xoopsTpl']->assign('selectorupdated', $selectorupdated);
                $authorsArray['updated']     = formatTimestamp($authorsTempArray[$i]->getVar('updated'), 's');
                $authorsArray['edit_delete'] = "<a href='authors.php?op=edit&id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='authors.php?op=delete&id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='authors.php?op=clone&id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->appendByRef('authorsArrays', $authorsArray);
                unset($authorsArray);
            }
            unset($authorsTempArray);
            // Display Navigation
            if ($authorsCount > $authorsPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $authorsCount,
                    $authorsPaginationLimit,
                    $start,
                    'start',
                    'op=list' . '&sort=' . $sort . '&order=' . $order
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='authors.php?op=edit&id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='authors.php?op=delete&id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_QUOTE_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='8'>There are noXXX authors</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/quote_admin_authors.tpl'
            );
        }

        break;
}
require_once __DIR__ . '/admin_footer.php';
