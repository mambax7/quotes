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

use Xmf\Module\Admin;
use Xmf\Module\Helper\Permission;
use Xmf\Request;
use XoopsModules\Quotes\AuthorHandler;
use XoopsModules\Quotes\Helper;
use XoopsModules\Quotes\Utility;

/** @var Admin $adminObject */
/** @var Helper $helper */
/** @var Utility $utility */
/** @var AuthorHandler $authorHandler */
require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = Request::getString('op', 'list', 'REQUEST');
$order = \strtolower(Request::getString('order', 'desc', 'GET'));
$order = \in_array($order, ['asc', 'desc'], true) ? $order : 'desc';
$sort  = Request::getString('sort', 'id', 'GET');
$sort  = \in_array($sort, ['id', 'name', 'country', 'created', 'updated'], true) ? $sort : 'id';

$helper  = Helper::getInstance();
$utility = new Utility();

$adminObject->displayNavigation(basename(__FILE__));
$permHelper = new Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/quotes/author/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/quotes/author/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_QUOTES_AUTHOR_LIST, 'author.php', 'list');
        $adminObject->displayButton('left');

        $authorObject = $authorHandler->create();
        $form         = $authorObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('author.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('id', 0, 'POST')) {
            $authorObject = $authorHandler->get(Request::getInt('id', 0, 'POST'));
        } else {
            $authorObject = $authorHandler->create();
        }
        // Form save fields
        $authorObject->setVar('name', Request::getString('name', '', 'POST'));
        $authorObject->setVar('country', Request::getString('country', '', 'POST'));
        $authorObject->setVar('bio', Request::getText('bio', '', 'POST'));

        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadDir = XOOPS_UPLOAD_PATH . '/quotes/author/';
        $uploader  = new \XoopsMediaUploader(
            $uploadDir,
            $helper->getConfig('mimetypes'),
            $helper->getConfig('maxsize'),
            null,
            null
        );
        $uploadFields = Request::getArray('xoops_upload_file', [], 'POST');
        $uploadField  = (string)($uploadFields[0] ?? '');
        if ('' !== $uploadField && $uploader->fetchMedia($uploadField)) {
            //$extension = preg_replace( '/^.+\.([^.]+)$/sU' , '' , $_FILES['attachedfile']['name']);
            //$imgName = str_replace(' ', '', $_POST['photo']).'.'.$extension;

            $uploader->setPrefix('photo_');
            $uploader->fetchMedia($uploadField);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            } else {
                $authorObject->setVar('photo', $uploader->getSavedFileName());
            }
        } else {
            $authorObject->setVar('photo', Request::getString('photo', '', 'POST'));
        }

        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('created', '', 'POST'));

        $authorObject->setVar('created', $dateTimeObj instanceof \DateTimeInterface ? $dateTimeObj->getTimestamp() : time());
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('updated', '', 'POST'));

        $authorObject->setVar('updated', $dateTimeObj instanceof \DateTimeInterface ? $dateTimeObj->getTimestamp() : time());
        if ($authorHandler->insert($authorObject)) {
            redirect_header('author.php?op=list', 2, AM_QUOTES_FORMOK);
        }

        echo $authorObject->getHtmlErrors();
        $form = $authorObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_QUOTES_ADD_AUTHOR, 'author.php?op=new', 'add');
        $adminObject->addItemButton(AM_QUOTES_AUTHOR_LIST, 'author.php', 'list');
        $adminObject->displayButton('left');
        $authorObject = $authorHandler->get(Request::getInt('id', 0, 'GET'));
        $form         = $authorObject->getForm();
        $form->display();
        break;
    case 'delete':
        $selectedIds = \array_filter(\array_map('intval', Request::getArray('author_id', [], 'POST')));
        $postedIds   = \array_filter(\array_map('intval', \explode(',', Request::getString('ids', '', 'POST'))));
        $deleteIds   = $postedIds ?: $selectedIds;

        if (1 === Request::getInt('ok', 0, 'POST')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('author.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ([] === $deleteIds) {
                $deleteIds = [Request::getInt('id', 0, 'POST')];
            }
            $deleted = 0;
            foreach ($deleteIds as $deleteId) {
                $authorObject = $authorHandler->get($deleteId);
                if (\is_object($authorObject) && $authorHandler->delete($authorObject)) {
                    ++$deleted;
                }
            }
            if ($deleted > 0) {
                redirect_header('author.php', 3, AM_QUOTES_FORMDELOK);
            } else {
                redirect_header('author.php', 3, _ERRORS);
            }
        } else {
            if ([] !== $deleteIds) {
                xoops_confirm(['ok' => 1, 'ids' => \implode(',', $deleteIds), 'op' => 'delete'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_QUOTES_FORMSUREDEL, \implode(', ', $deleteIds)));
                break;
            }
            $authorObject = $authorHandler->get(Request::getInt('id', 0, 'GET'));
            if (!\is_object($authorObject)) {
                redirect_header('author.php', 3, _ERRORS);
            }
            xoops_confirm(['ok' => 1, 'id' => Request::getInt('id', 0, 'GET'), 'op' => 'delete'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_QUOTES_FORMSUREDEL, $authorObject->getVar('name')));
        }
        break;
    case 'clone':
        $id_field = Request::getInt('id', 0, 'GET');

        if ($utility::cloneRecord('quotes_author', 'id', $id_field)) {
            redirect_header('author.php', 3, AM_QUOTES_CLONED_OK);
        } else {
            redirect_header('author.php', 3, AM_QUOTES_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_QUOTES_ADD_AUTHOR, 'author.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                 = Request::getInt('start', 0, 'GET');
        $authorPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id ASC, name');
        $criteria->setOrder('ASC');
        $criteria->setLimit($authorPaginationLimit);
        $criteria->setStart($start);
        $authorTempRows  = $authorHandler->getCount();
        $authorTempArray = $authorHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_QUOTES_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($authorTempRows > $authorPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $authorTempRows,
                $authorPaginationLimit,
                $start,
                'start',
                'op=list' . '&sort=' . $sort . '&order=' . $order
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
        }

        $GLOBALS['xoopsTpl']->assign('authorRows', $authorTempRows);
        $authorArray = [];

        //    $fields = explode('|', id:int:8::NOT NULL:::ID:0|name:varchar:50::NOT NULL:::Name:1|country:varchar:3::NOT NULL:::Country:2|bio:text:::NOT NULL:::Bio:3|photo:varchar:50::NOT NULL:::Photo:4|created:int:11:UNSIGNED:NOT NULL:0::Created:5|updated:int:11::NOT NULL:0::Updated:6);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($authorPaginationLimit);
        $criteria->setStart($start);

        $authorCount     = $authorHandler->getCount($criteria);
        $authorTempArray = $authorHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($authorCount > 0) {
            foreach (array_keys($authorTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorid', AM_QUOTES_AUTHOR_ID);
                $authorArray['id'] = $authorTempArray[$i]->getVar('id');

                $selectorname = $utility::selectSorting(AM_QUOTES_AUTHOR_NAME, 'name', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorname', $selectorname);
                $authorArray['name'] = $authorTempArray[$i]->getVar('name');
                $authorArray['name'] = $utility::truncateHtml($authorArray['name'], $helper->getConfig('truncatelength'));

                $selectorcountry = $utility::selectSorting(AM_QUOTES_AUTHOR_COUNTRY, 'country', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorcountry', $selectorcountry);
                //                $authorArray['country'] = strip_tags(\XoopsLists::getCountryList($authorTempArray[$i]->getVar('country')));
                //                $authorArray['country'] = strip_tags(\XoopsLists::getCountryList()[$authorTempArray[$i]->getVar('country')]);
                $countryCode            = (string)$authorTempArray[$i]->getVar('country');
                $authorArray['country'] = \XoopsLists::getCountryList()[$countryCode] ?? $countryCode;

                $GLOBALS['xoopsTpl']->assign('selectorbio', AM_QUOTES_AUTHOR_BIO);
                $authorArray['bio'] = $authorTempArray[$i]->getVar('bio');
                $authorArray['bio'] = $utility::truncateHtml($authorArray['bio'], $helper->getConfig('truncatelength'));

                $GLOBALS['xoopsTpl']->assign('selectorphoto', AM_QUOTES_AUTHOR_PHOTO);
                $authorPhoto          = (string)$authorTempArray[$i]->getVar('photo');
                $authorArray['photo'] = '' !== $authorPhoto ? "<img src='" . $uploadUrl . \htmlspecialchars($authorPhoto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "' alt='' style='max-width:100px'>" : '';

                $selectorcreated = $utility::selectSorting(AM_QUOTES_AUTHOR_CREATED, 'created', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorcreated', $selectorcreated);
                $authorArray['created'] = formatTimestamp($authorTempArray[$i]->getVar('created'), 's');

                $selectorupdated = $utility::selectSorting(AM_QUOTES_AUTHOR_UPDATED, 'updated', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorupdated', $selectorupdated);
                $authorArray['updated']     = formatTimestamp($authorTempArray[$i]->getVar('updated'), 's');
                $authorId                    = (int)$authorArray['id'];
                $authorArray['edit_delete'] = "<a href='author.php?op=edit&amp;id={$authorId}'><img src='{$pathIcon16}/edit.png' alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='author.php?op=delete&amp;id={$authorId}'><img src='{$pathIcon16}/delete.png' alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='author.php?op=clone&amp;id={$authorId}'><img src='{$pathIcon16}/editcopy.png' alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->appendByRef('authorArrays', $authorArray);
                unset($authorArray);
            }
            unset($authorTempArray);
            // Display Navigation
            if ($authorCount > $authorPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $authorCount,
                    $authorPaginationLimit,
                    $start,
                    'start',
                    'op=list' . '&sort=' . $sort . '&order=' . $order
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='author.php?op=edit&id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='author.php?op=delete&id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_QUOTES_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='8'>There are noXXX author</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/quotes_admin_author.tpl'
            );
        }

        break;
}
require_once __DIR__ . '/admin_footer.php';
