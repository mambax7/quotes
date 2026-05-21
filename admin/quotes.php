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
        $adminObject->addItemButton(AM_QUOTE_QUOTES_LIST, 'quotes.php', 'list');
        $adminObject->displayButton('left');

        $quotesObject = $quotesHandler->create();
        $form         = $quotesObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('quotes.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('id', 0)) {
            $quotesObject = $quotesHandler->get(Request::getInt('id', 0));
        } else {
            $quotesObject = $quotesHandler->create();
        }
        // Form save fields
        $quotesObject->setVar('cid', Request::getVar('cid', ''));
        $quotesObject->setVar('author_id', Request::getVar('author_id', ''));
        $quotesObject->setVar('quote', Request::getText('quote', ''));
        $quotesObject->setVar('online', ((1 == \Xmf\Request::getInt('online', 0)) ? '1' : '0'));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('created', '', 'POST'));

        $quotesObject->setVar('created', $dateTimeObj->getTimestamp());
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('updated', '', 'POST'));

        $quotesObject->setVar('updated', $dateTimeObj->getTimestamp());
        if ($quotesHandler->insert($quotesObject)) {
            redirect_header('quotes.php?op=list', 2, AM_QUOTE_FORMOK);
        }

        echo $quotesObject->getHtmlErrors();
        $form = $quotesObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_QUOTE_ADD_QUOTES, 'quotes.php?op=new', 'add');
        $adminObject->addItemButton(AM_QUOTE_QUOTES_LIST, 'quotes.php', 'list');
        $adminObject->displayButton('left');
        $quotesObject = $quotesHandler->get(Request::getString('id', ''));
        $form         = $quotesObject->getForm();
        $form->display();
        break;
    case 'delete':
        $quotesObject = $quotesHandler->get(Request::getString('id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('quotes.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($quotesHandler->delete($quotesObject)) {
                redirect_header('quotes.php', 3, AM_QUOTE_FORMDELOK);
            } else {
                echo $quotesObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'id' => Request::getString('id', ''), 'op' => 'delete'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_QUOTE_FORMSUREDEL, $quotesObject->getVar('quote')));
        }
        break;
    case 'clone':
        $id_field = \Xmf\Request::getString('id', '');

        if ($utility::cloneRecord('quote_quotes', 'id', $id_field)) {
            redirect_header('quotes.php', 3, AM_QUOTE_CLONED_OK);
        } else {
            redirect_header('quotes.php', 3, AM_QUOTE_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_QUOTE_ADD_QUOTES, 'quotes.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                 = \Xmf\Request::getInt('start', 0);
        $quotesPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id ASC, quote');
        $criteria->setOrder('ASC');
        $criteria->setLimit($quotesPaginationLimit);
        $criteria->setStart($start);
        $quotesTempRows  = $quotesHandler->getCount();
        $quotesTempArray = $quotesHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_QUOTE_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($quotesTempRows > $quotesPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $quotesTempRows,
                $quotesPaginationLimit,
                $start,
                'start',
                'op=list' . '&sort=' . $sort . '&order=' . $order
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }

        $GLOBALS['xoopsTpl']->assign('quotesRows', $quotesTempRows);
        $quotesArray = [];

        //    $fields = explode('|', id:int:11::NOT NULL::primary:ID:0|cid:int:8::NOT NULL:0::Category:1|author_id:int:::NOT NULL:::Author:2|quote:text:0::NOT NULL:::Quote:3|online:tinyint:1::NOT NULL:1::Online:4|created:int:11:UNSIGNED:NOT NULL:::Created:5|updated:int:11:UNSIGNED:NOT NULL:0::Updated:6);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($quotesPaginationLimit);
        $criteria->setStart($start);

        $quotesCount     = $quotesHandler->getCount($criteria);
        $quotesTempArray = $quotesHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($quotesCount > 0) {
            foreach (array_keys($quotesTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorid', AM_QUOTE_QUOTES_ID);
                $quotesArray['id'] = $quotesTempArray[$i]->getVar('id');

                $GLOBALS['xoopsTpl']->assign('selectorcid', AM_QUOTE_QUOTES_CID);
                $quotesArray['cid'] = $categoryHandler->get($quotesTempArray[$i]->getVar('cid'))->getVar('title');

                $selectorauthor_id = $utility::selectSorting(AM_QUOTE_QUOTES_AUTHOR_ID, 'author_id');
                $GLOBALS['xoopsTpl']->assign('selectorauthor_id', $selectorauthor_id);
                $quotesArray['author_id'] = $authorsHandler->get($quotesTempArray[$i]->getVar('author_id'))->getVar('name');

                $GLOBALS['xoopsTpl']->assign('selectorquote', AM_QUOTE_QUOTES_QUOTE);
                $quotesArray['quote'] = $quotesTempArray[$i]->getVar('quote');
                $quotesArray['quote'] = $utility::truncateHtml($quotesArray['quote'], $helper->getConfig('truncatelength'));

                $GLOBALS['xoopsTpl']->assign('selectoronline', AM_QUOTE_QUOTES_ONLINE);
                $quotesArray['online'] = $quotesTempArray[$i]->getVar('online');

                $selectorcreated = $utility::selectSorting(AM_QUOTE_QUOTES_CREATED, 'created');
                $GLOBALS['xoopsTpl']->assign('selectorcreated', $selectorcreated);
                $quotesArray['created'] = formatTimestamp($quotesTempArray[$i]->getVar('created'), 's');

                $selectorupdated = $utility::selectSorting(AM_QUOTE_QUOTES_UPDATED, 'updated');
                $GLOBALS['xoopsTpl']->assign('selectorupdated', $selectorupdated);
                $quotesArray['updated']     = formatTimestamp($quotesTempArray[$i]->getVar('updated'), 's');
                $quotesArray['edit_delete'] = "<a href='quotes.php?op=edit&id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='quotes.php?op=delete&id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='quotes.php?op=clone&id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->appendByRef('quotesArrays', $quotesArray);
                unset($quotesArray);
            }
            unset($quotesTempArray);
            // Display Navigation
            if ($quotesCount > $quotesPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $quotesCount,
                    $quotesPaginationLimit,
                    $start,
                    'start',
                    'op=list' . '&sort=' . $sort . '&order=' . $order
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='quotes.php?op=edit&id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='quotes.php?op=delete&id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_QUOTE_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='8'>There are noXXX quotes</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/quote_admin_quotes.tpl'
            );
        }

        break;
}
require_once __DIR__ . '/admin_footer.php';
