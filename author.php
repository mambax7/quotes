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

use XoopsModules\Quotes;
use Xmf\Request;

require __DIR__ . '/header.php';

$op = Request::getCmd('op', 'list');

if ('edit' !== $op) {
    if ('view' === $op) {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_author.tpl';
    } else {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_author_list0.tpl';
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
/** @var \XoopsPersistableObjectHandler $authorHandler */
$authorHandler = $helper->getHandler('Author');

$authorPaginationLimit = $helper->getConfig('userpager');

$criteria = new \CriteriaCompo();

$criteria->setOrder('DESC');
$criteria->setLimit($authorPaginationLimit);
$criteria->setStart($start);

$authorCount = $authorHandler->getCount($criteria);
$authorArray = $authorHandler->getAll($criteria);

$id = Request::getInt('id', 0, 'GET');

switch ($op) {
    case 'edit':
        $authorObject = $authorHandler->get(Request::getString('id', ''));
        $form         = $authorObject->getForm();
        $form->display();
        break;

    case 'view':
        //        viewItem();
        $authorPaginationLimit = 1;
        $myid                  = $id;
        //id
        $authorObject = $authorHandler->get($myid);

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id');
        $criteria->setOrder('DESC');
        $criteria->setLimit($authorPaginationLimit);
        $criteria->setStart($start);
        $author['id']      = $authorObject->getVar('id');
        $author['name']    = $authorObject->getVar('name');
        $author['country'] = strip_tags(\XoopsLists::getCountryList()[$authorObject->getVar('country')]);
        $author['bio']     = $authorObject->getVar('bio');
        $author['photo']   = $authorObject->getVar('photo');
        $author['created'] = formatTimestamp($authorObject->getVar('created'), 's');
        $author['updated'] = formatTimestamp($authorObject->getVar('updated'), 's');

        //       $GLOBALS['xoopsTpl']->append('author', $author);
        $keywords[] = $authorObject->getVar('name');

        $GLOBALS['xoopsTpl']->assign('author', $author);
        $start = $id;

        // Display Navigation
        if ($authorCount > $authorPaginationLimit) {
            $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTES_URL . '/author.php');
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav($authorCount, $authorPaginationLimit, $start, 'op=view&id');
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
        }

        break;
    case 'list':
    default:
        //        viewall();

        if ($authorCount > 0) {
            $GLOBALS['xoopsTpl']->assign('author', []);
            foreach (array_keys($authorArray) as $i) {
                $author['id']      = $authorArray[$i]->getVar('id');
                $author['name']    = $authorArray[$i]->getVar('name');
                $author['name']    = $utility::truncateHtml($author['name'], $helper->getConfig('truncatelength'));
                $author['country'] = strip_tags(\XoopsLists::getCountryList()[$authorArray[$i]->getVar('country')]);
                $author['bio']     = $authorArray[$i]->getVar('bio');
                $author['bio']     = $utility::truncateHtml($author['bio'], $helper->getConfig('truncatelength'));
                $author['photo']   = $authorArray[$i]->getVar('photo');
                $author['photo']   = $utility::truncateHtml($author['photo'], $helper->getConfig('truncatelength'));
                $author['created'] = formatTimestamp($authorArray[$i]->getVar('created'), 's');
                $author['updated'] = formatTimestamp($authorArray[$i]->getVar('updated'), 's');
                $GLOBALS['xoopsTpl']->append('author', $author);
                $keywords[] = $authorArray[$i]->getVar('name');
                unset($author);
            }
            // Display Navigation
            if ($authorCount > $authorPaginationLimit) {
                $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTES_URL . '/author.php');
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav($authorCount, $authorPaginationLimit, $start, 'start');
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        }
}

//keywords
if (isset($keywords)) {
    $utility::metaKeywords($helper->getConfig('keywords') . ', ' . implode(', ', $keywords));
}
//description
$utility::metaDescription(MD_QUOTES_AUTHOR_DESC);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTES_URL . '/author.php');
$GLOBALS['xoopsTpl']->assign('quotes_url', QUOTES_URL);
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));

$GLOBALS['xoopsTpl']->assign('bookmarks', $helper->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $helper->getConfig('fbcomments'));

$GLOBALS['xoopsTpl']->assign('admin', QUOTES_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);

require XOOPS_ROOT_PATH . '/footer.php';
