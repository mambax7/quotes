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
use XoopsModules\Quote;

require __DIR__ . '/header.php';

$op = \Xmf\Request::getCmd('op', 'list');

if ('edit' !== $op) {
    if ('view' === $op) {
        $GLOBALS['xoopsOption']['template_main'] = 'quote_quotes.tpl';
    } else {
        $GLOBALS['xoopsOption']['template_main'] = 'quote_quotes_list0.tpl';
    }
}
require_once XOOPS_ROOT_PATH . '/header.php';

global $xoTheme;

$start = \Xmf\Request::getInt('start', 0);
// Define Stylesheet
/** @var xos_opal_Theme $xoTheme */
$xoTheme->addStylesheet($stylesheet);

$db = \XoopsDatabaseFactory::getDatabaseConnection();

// Get Handler
/** @var \XoopsPersistableObjectHandler $quotesHandler */
$quotesHandler = $helper->getHandler('Quotes');

$quotesPaginationLimit = $helper->getConfig('userpager');

$criteria = new \CriteriaCompo();

$criteria->setOrder('DESC');
$criteria->setLimit($quotesPaginationLimit);
$criteria->setStart($start);

$quotesCount = $quotesHandler->getCount($criteria);
$quotesArray = $quotesHandler->getAll($criteria);

$id = \Xmf\Request::getInt('id', 0, 'GET');

switch ($op) {
    case 'edit':
        $quotesObject = $quotesHandler->get(Request::getString('id', ''));
        $form         = $quotesObject->getForm();
        $form->display();
        break;
    case 'view':
        //        viewItem();
        $quotesPaginationLimit = 1;
        $myid                  = $id;
        //id
        $quotesObject = $quotesHandler->get($myid);

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id');
        $criteria->setOrder('DESC');
        $criteria->setLimit($quotesPaginationLimit);
        $criteria->setStart($start);
        $quotes['id'] = $quotesObject->getVar('id');
        /** @var \XoopsPersistableObjectHandler $categoryHandler */
        $categoryHandler = $helper->getHandler('Category');

        $quotes['cid'] = $categoryHandler->get($quotesObject->getVar('cid'))->getVar('title');
        /** @var \XoopsPersistableObjectHandler $authorsHandler */
        $authorsHandler = $helper->getHandler('Authors');

        $quotes['author_id'] = $authorsHandler->get($quotesObject->getVar('author_id'))->getVar('name');
        $quotes['quote']     = $quotesObject->getVar('quote');
        $quotes['online']    = $quotesObject->getVar('online');
        $quotes['created']   = formatTimestamp($quotesObject->getVar('created'), 's');
        $quotes['updated']   = formatTimestamp($quotesObject->getVar('updated'), 's');

        //       $GLOBALS['xoopsTpl']->append('quotes', $quotes);
        $keywords[] = $quotesObject->getVar('quote');

        $GLOBALS['xoopsTpl']->assign('quotes', $quotes);
        $start = $id;

        // Display Navigation
        if ($quotesCount > $quotesPaginationLimit) {
            $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTE_URL . '/quotes.php');
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav($quotesCount, $quotesPaginationLimit, $start, 'op=view&id');
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
        }

        break;
    case 'list':
    default:
        //        viewall();

        if ($quotesCount > 0) {
            $GLOBALS['xoopsTpl']->assign('quotes', []);
            foreach (array_keys($quotesArray) as $i) {
                $quotes['id'] = $quotesArray[$i]->getVar('id');
                /** @var \XoopsPersistableObjectHandler $categoryHandler */
                $categoryHandler = $helper->getHandler('Category');

                $quotes['cid'] = $categoryHandler->get($quotesArray[$i]->getVar('cid'))->getVar('title');
                /** @var \XoopsPersistableObjectHandler $authorsHandler */
                $authorsHandler = $helper->getHandler('Authors');

                $quotes['author_id'] = $authorsHandler->get($quotesArray[$i]->getVar('author_id'))->getVar('name');
                $quotes['quote']     = $quotesArray[$i]->getVar('quote');
                $quotes['quote']     = $utility::truncateHtml($quotes['quote'], $helper->getConfig('truncatelength'));
                $quotes['online']    = $quotesArray[$i]->getVar('online');
                $quotes['created']   = formatTimestamp($quotesArray[$i]->getVar('created'), 's');
                $quotes['updated']   = formatTimestamp($quotesArray[$i]->getVar('updated'), 's');
                $GLOBALS['xoopsTpl']->append('quotes', $quotes);
                $keywords[] = $quotesArray[$i]->getVar('quote');
                unset($quotes);
            }
            // Display Navigation
            if ($quotesCount > $quotesPaginationLimit) {
                $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTE_URL . '/quotes.php');
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav($quotesCount, $quotesPaginationLimit, $start, 'start');
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        }
}

//keywords
if (isset($keywords)) {
    $utility::metaKeywords($helper->getConfig('keywords') . ', ' . implode(', ', $keywords));
}
//description
$utility::metaDescription(MD_QUOTE_QUOTES_DESC);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTE_URL . '/quotes.php');
$GLOBALS['xoopsTpl']->assign('quote_url', QUOTE_URL);
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));

$GLOBALS['xoopsTpl']->assign('bookmarks', $helper->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $helper->getConfig('fbcomments'));

$GLOBALS['xoopsTpl']->assign('admin', QUOTE_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);

require XOOPS_ROOT_PATH . '/footer.php';
