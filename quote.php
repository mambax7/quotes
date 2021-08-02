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
use XoopsModules\Quotes\{
    AuthorHandler,
    CategoryHandler,
    Quote,
    QuoteHandler,
    Helper,
    Utility
};

/** @var Quote $quoteObject */
/** @var QuoteHandler $quoteHandler */
/** @var AuthorHandler $authorHandler */
/** @var CategoryHandler $categoryHandler */
/** @var Helper $helper */

require __DIR__ . '/header.php';

$op = Request::getCmd('op', 'list');

if ('edit' !== $op) {
    if ('view' === $op) {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_quote.tpl';
    } else {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_quote_list0.tpl';
    }
}
require_once XOOPS_ROOT_PATH . '/header.php';

global $xoTheme;

$start = Request::getInt('start', 0);
// Define Stylesheet
/** @var xos_opal_Theme $xoTheme */
$xoTheme->addStylesheet($stylesheet);

$db = \XoopsDatabaseFactory::getDatabaseConnection();

// Get Handler
$quoteHandler = $helper->getHandler('Quote');

$quotePaginationLimit = $helper->getConfig('userpager');

$criteria = new \CriteriaCompo();

$criteria->setOrder('DESC');
$criteria->setLimit($quotePaginationLimit);
$criteria->setStart($start);

$quoteCount = $quoteHandler->getCount($criteria);
$quoteArray = $quoteHandler->getAll($criteria);

$id = Request::getInt('id', 0, 'GET');

switch ($op) {
    case 'edit':
        $quoteObject = $quoteHandler->get(Request::getString('id', ''));
        $form        = $quoteObject->getForm();
        $form->display();
        break;

    case 'view':
        //        viewItem();
        $quotePaginationLimit = 1;
        $myid                 = $id;
        //id
        $quoteObject = $quoteHandler->get($myid);

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id');
        $criteria->setOrder('DESC');
        $criteria->setLimit($quotePaginationLimit);
        $criteria->setStart($start);
        $quote['id'] = $quoteObject->getVar('id');
        $categoryHandler = $helper->getHandler('Category');

        $quote['cid']       = $categoryHandler->get($quoteObject->getVar('cid'))->getVar('title');
        $quote['author_id'] = $authorHandler->get($quoteObject->getVar('author_id'))->getVar('name');
        $quote['quote']     = $quoteObject->getVar('quote');
        $quote['online']    = $quoteObject->getVar('online');
        $quote['created']   = formatTimestamp($quoteObject->getVar('created'), 's');
        $quote['updated']   = formatTimestamp($quoteObject->getVar('updated'), 's');

        //       $GLOBALS['xoopsTpl']->append('quote', $quote);
        $keywords[] = $quoteObject->getVar('quote');

        $GLOBALS['xoopsTpl']->assign('quote', $quote);
        $start = $id;

        // Display Navigation
        if ($quoteCount > $quotePaginationLimit) {
            $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTES_URL . '/quote.php');
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav($quoteCount, $quotePaginationLimit, $start, 'op=view&id');
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
        }

        break;
    case 'list':
    default:
        //        viewall();

        if ($quoteCount > 0) {
            $GLOBALS['xoopsTpl']->assign('quote', []);
            foreach (array_keys($quoteArray) as $i) {
                $quote['id'] = $quoteArray[$i]->getVar('id');
                $categoryHandler = $helper->getHandler('Category');

                $quote['cid']       = $categoryHandler->get($quoteArray[$i]->getVar('cid'))->getVar('title');
                $quote['author_id'] = $authorHandler->get($quoteArray[$i]->getVar('author_id'))->getVar('title');
                $quote['quote']     = $quoteArray[$i]->getVar('quote');
                $quote['quote']     = $utility::truncateHtml($quote['quote'], $helper->getConfig('truncatelength'));
                $quote['online']    = $quoteArray[$i]->getVar('online');
                $quote['created']   = formatTimestamp($quoteArray[$i]->getVar('created'), 's');
                $quote['updated']   = formatTimestamp($quoteArray[$i]->getVar('updated'), 's');
                $GLOBALS['xoopsTpl']->append('quote', $quote);
                $keywords[] = $quoteArray[$i]->getVar('quote');
                unset($quote);
            }
            // Display Navigation
            if ($quoteCount > $quotePaginationLimit) {
                $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTES_URL . '/quote.php');
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav($quoteCount, $quotePaginationLimit, $start, 'start');
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        }
}

//keywords
if (isset($keywords)) {
    $utility::metaKeywords($helper->getConfig('keywords') . ', ' . implode(', ', $keywords));
}
//description
$utility::metaDescription(MD_QUOTES_QUOTE_DESC);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTES_URL . '/quote.php');
$GLOBALS['xoopsTpl']->assign('quotes_url', QUOTES_URL);
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));

$GLOBALS['xoopsTpl']->assign('bookmarks', $helper->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $helper->getConfig('fbcomments'));

$GLOBALS['xoopsTpl']->assign('admin', QUOTES_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);

require XOOPS_ROOT_PATH . '/footer.php';
