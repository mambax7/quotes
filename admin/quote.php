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
use XoopsModules\Quotes\Helper;
use XoopsModules\Quotes\Utility;

/** @var Admin $adminObject */
/** @var Helper $helper */
/** @var Utility $utility */
require_once __DIR__ . '/admin_header.php';
xoops_cp_header();

//It recovered the value of argument op in URL$
$op    = Request::getString('op', 'list', 'REQUEST');
$order = \strtolower(Request::getString('order', 'desc', 'GET'));
$order = \in_array($order, ['asc', 'desc'], true) ? $order : 'desc';
$sort  = Request::getString('sort', 'id', 'GET');
$sort  = \in_array($sort, ['id', 'cid', 'author_id', 'quote', 'online', 'created', 'updated'], true) ? $sort : 'id';

$adminObject->displayNavigation(basename(__FILE__));
$permHelper = new Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/quotes/quote/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/quotes/quote/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_QUOTES_QUOTE_LIST, 'quote.php', 'list');
        $adminObject->displayButton('left');

        $quoteObject = $quoteHandler->create();
        $form        = $quoteObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('quote.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('id', 0, 'POST')) {
            $quoteObject = $quoteHandler->get(Request::getInt('id', 0, 'POST'));
        } else {
            $quoteObject = $quoteHandler->create();
        }
        // Form save fields
        $quoteObject->setVar('cid', Request::getInt('cid', 0, 'POST'));
        $quoteObject->setVar('author_id', Request::getInt('author_id', 0, 'POST'));
        $quoteObject->setVar('quote', Request::getText('quote', '', 'POST'));
        $quoteObject->setVar('online', ((1 === Request::getInt('online', 0, 'POST')) ? '1' : '0'));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('created', '', 'POST'));

        $quoteObject->setVar('created', $dateTimeObj instanceof \DateTimeInterface ? $dateTimeObj->getTimestamp() : time());
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('updated', '', 'POST'));

        $quoteObject->setVar('updated', $dateTimeObj instanceof \DateTimeInterface ? $dateTimeObj->getTimestamp() : time());
        if ($quoteHandler->insert($quoteObject)) {
            redirect_header('quote.php?op=list', 2, AM_QUOTES_FORMOK);
        }

        echo $quoteObject->getHtmlErrors();
        $form = $quoteObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_QUOTES_ADD_QUOTE, 'quote.php?op=new', 'add');
        $adminObject->addItemButton(AM_QUOTES_QUOTE_LIST, 'quote.php', 'list');
        $adminObject->displayButton('left');
        $quoteObject = $quoteHandler->get(Request::getInt('id', 0, 'GET'));
        $form        = $quoteObject->getForm();
        $form->display();
        break;
    case 'delete':
        $selectedIds = \array_filter(\array_map('intval', Request::getArray('quote_id', [], 'POST')));
        $postedIds   = \array_filter(\array_map('intval', \explode(',', Request::getString('ids', '', 'POST'))));
        $deleteIds   = $postedIds ?: $selectedIds;

        if (1 === Request::getInt('ok', 0, 'POST')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('quote.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ([] === $deleteIds) {
                $deleteIds = [Request::getInt('id', 0, 'POST')];
            }
            $deleted = 0;
            foreach ($deleteIds as $deleteId) {
                $quoteObject = $quoteHandler->get($deleteId);
                if (\is_object($quoteObject) && $quoteHandler->delete($quoteObject)) {
                    ++$deleted;
                }
            }
            if ($deleted > 0) {
                redirect_header('quote.php', 3, AM_QUOTES_FORMDELOK);
            } else {
                redirect_header('quote.php', 3, _ERRORS);
            }
        } else {
            if ([] !== $deleteIds) {
                xoops_confirm(['ok' => 1, 'ids' => \implode(',', $deleteIds), 'op' => 'delete'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_QUOTES_FORMSUREDEL, \implode(', ', $deleteIds)));
                break;
            }
            $quoteObject = $quoteHandler->get(Request::getInt('id', 0, 'GET'));
            if (!\is_object($quoteObject)) {
                redirect_header('quote.php', 3, _ERRORS);
            }
            xoops_confirm(['ok' => 1, 'id' => Request::getInt('id', 0, 'GET'), 'op' => 'delete'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_QUOTES_FORMSUREDEL, $quoteObject->getVar('quote')));
        }
        break;
    case 'clone':
        $id_field = Request::getInt('id', 0, 'GET');

        if ($utility::cloneRecord('quotes_quote', 'id', $id_field)) {
            redirect_header('quote.php', 3, AM_QUOTES_CLONED_OK);
        } else {
            redirect_header('quote.php', 3, AM_QUOTES_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_QUOTES_ADD_QUOTE, 'quote.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                = Request::getInt('start', 0, 'GET');
        $quotePaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id ASC, quote');
        $criteria->setOrder('ASC');
        $criteria->setLimit($quotePaginationLimit);
        $criteria->setStart($start);
        $quoteTempRows  = $quoteHandler->getCount();
        $quoteTempArray = $quoteHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_QUOTES_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($quoteTempRows > $quotePaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $quoteTempRows,
                $quotePaginationLimit,
                $start,
                'start',
                'op=list' . '&sort=' . $sort . '&order=' . $order
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
        }

        $GLOBALS['xoopsTpl']->assign('quoteRows', $quoteTempRows);
        $quoteArray = [];

        //    $fields = explode('|', id:int:11::NOT NULL::primary:ID:0|cid:int:8::NOT NULL:0::Category:1|author_id:int:::NOT NULL:::Author:2|quote:text:0::NOT NULL:::Quote:3|online:tinyint:1::NOT NULL:1::Online:4|created:int:11:UNSIGNED:NOT NULL:::Created:5|updated:int:11:UNSIGNED:NOT NULL:0::Updated:6);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($quotePaginationLimit);
        $criteria->setStart($start);

        $quoteCount     = $quoteHandler->getCount($criteria);
        $quoteTempArray = $quoteHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($quoteCount > 0) {
            foreach (array_keys($quoteTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorid', AM_QUOTES_QUOTE_ID);
                $quoteArray['id'] = $quoteTempArray[$i]->getVar('id');

                $GLOBALS['xoopsTpl']->assign('selectorcid', AM_QUOTES_QUOTE_CID);
                $quoteArray['cid'] = $categoryHandler->get($quoteTempArray[$i]->getVar('cid'))->getVar('title');

                $selectorauthor_id = $utility::selectSorting(AM_QUOTES_QUOTE_AUTHOR_ID, 'author_id', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorauthor_id', $selectorauthor_id);
                $quoteArray['author_id'] = $authorHandler->get($quoteTempArray[$i]->getVar('author_id'))->getVar('name');

                $GLOBALS['xoopsTpl']->assign('selectorquote', AM_QUOTES_QUOTE_QUOTE);
                $quoteArray['quote'] = $quoteTempArray[$i]->getVar('quote');
                $quoteArray['quote'] = $utility::truncateHtml($quoteArray['quote'], $helper->getConfig('truncatelength'));

                $GLOBALS['xoopsTpl']->assign('selectoronline', AM_QUOTES_QUOTE_ONLINE);
                $quoteArray['online'] = $quoteTempArray[$i]->getVar('online');

                $selectorcreated = $utility::selectSorting(AM_QUOTES_QUOTE_CREATED, 'created', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorcreated', $selectorcreated);
                $quoteArray['created'] = formatTimestamp($quoteTempArray[$i]->getVar('created'), 's');

                $selectorupdated = $utility::selectSorting(AM_QUOTES_QUOTE_UPDATED, 'updated', $helper);
                $GLOBALS['xoopsTpl']->assign('selectorupdated', $selectorupdated);
                $quoteArray['updated']     = formatTimestamp($quoteTempArray[$i]->getVar('updated'), 's');
                $quoteId                    = (int)$quoteArray['id'];
                $quoteArray['edit_delete'] = "<a href='quote.php?op=edit&amp;id={$quoteId}'><img src='{$pathIcon16}/edit.png' alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='quote.php?op=delete&amp;id={$quoteId}'><img src='{$pathIcon16}/delete.png' alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='quote.php?op=clone&amp;id={$quoteId}'><img src='{$pathIcon16}/editcopy.png' alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->appendByRef('quoteArrays', $quoteArray);
                unset($quoteArray);
            }
            unset($quoteTempArray);
            // Display Navigation
            if ($quoteCount > $quotePaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $quoteCount,
                    $quotePaginationLimit,
                    $start,
                    'start',
                    'op=list' . '&sort=' . $sort . '&order=' . $order
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='quote.php?op=edit&id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='quote.php?op=delete&id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_QUOTES_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='8'>There are noXXX quote</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/quotes_admin_quote.tpl'
            );
        }

        break;
}
require_once __DIR__ . '/admin_footer.php';
