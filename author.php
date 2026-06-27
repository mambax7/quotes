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

use Xmf\Request;
use XoopsModules\Quotes\Author;
use XoopsModules\Quotes\AuthorHandler;
use XoopsModules\Quotes\Helper;
use XoopsModules\Quotes\Utility;

/** @var Author $authorObject */
/** @var AuthorHandler $authorHandler */
/** @var Helper $helper */
/** @var Utility $utility */
require __DIR__ . '/header.php';

$op = Request::getString('op', 'list', 'REQUEST');

if (!\in_array($op, ['edit', 'save'], true)) {
    if ('view' === $op) {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_author.tpl';
    } else {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_author_list0.tpl';
    }
}
require_once XOOPS_ROOT_PATH . '/header.php';

global $xoTheme;

$start = Request::getInt('start', 0, 'GET');
// Define Stylesheet
/** @var xos_opal_Theme $xoTheme */
quotes_register_theme_assets($stylesheet);

$db = \XoopsDatabaseFactory::getDatabaseConnection();

// Get Handler
$authorHandler = $helper->getHandler('Author');

$authorPaginationLimit = $helper->getConfig('userpager');

$criteria = new \CriteriaCompo();

$criteria->setSort('name');
$criteria->setOrder('ASC');
$criteria->setLimit($authorPaginationLimit);
$criteria->setStart($start);

$authorCount = $authorHandler->getCount($criteria);
$authorArray = $authorHandler->getAll($criteria);

$id = Request::getInt('id', 0, 'GET');

switch ($op) {
    case 'edit':
        $editId       = Request::getInt('id', 0, 'GET');
        $authorObject = $authorHandler->get($editId);
        if ($editId > 0) {
            if (!quotes_user_can_edit_author($authorObject)) {
                redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'author.php'), 3, _NOPERM);
            }
        } elseif (!quotes_user_can_submit()) {
            redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'author.php'), 3, _NOPERM);
        }
        $form = $authorObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'author.php'), 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $saveId = Request::getInt('id', 0, 'POST');
        if ($saveId > 0) {
            if (!quotes_user_can_edit_author($authorHandler->get($saveId))) {
                redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'author.php'), 3, _NOPERM);
            }
        } elseif (!quotes_user_can_submit()) {
            redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'author.php'), 3, _NOPERM);
        }
        $result = $authorHandler->saveFromRequest($helper, $helper->isUserAdmin());
        if ($result['ok']) {
            redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'author.php', ['op' => 'view', 'id' => (int)$result['object']->getVar('id')]), 2, _AM_QUOTES_FORMOK);
        }
        echo $result['errors'];
        $form = $result['object']->getForm();
        $form->display();
        break;
    case 'view':
        //        viewItem();
        $authorPaginationLimit = 1;
        $myid                  = $id;
        //id
        $authorObject = $authorHandler->get($myid);
        if (!\is_object($authorObject)) {
            redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'author.php'), 3, _NOPERM);
            exit;
        }

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id');
        $criteria->setOrder('DESC');
        $criteria->setLimit($authorPaginationLimit);
        $criteria->setStart($start);
        $countryList       = \XoopsLists::getCountryList();
        $author['id']      = (int)$authorObject->getVar('id');
        $author['name']    = $authorObject->getVar('name');
        $country           = $authorObject->getVar('country');
        $author['country'] = \strip_tags($countryList[(string)$country] ?? (string)$country);
        $author['bio']     = quotes_render_rich_text((string)$authorObject->getVar('bio', 'n'));
        $author['photo']   = $authorObject->getVar('photo');
        $author['photo_url'] = quotes_author_photo_url((string)$author['photo']);
        $author['created'] = formatTimestamp($authorObject->getVar('created'), 's');
        $author['updated'] = formatTimestamp($authorObject->getVar('updated'), 's');
        $author['url']     = \Xoops\Helpers\Service\Url::module('quotes', 'author.php', ['op' => 'view', 'id' => $author['id']]);
        $author['can_edit'] = quotes_user_can_edit_author($authorObject);

        $quoteStart    = \max(0, Request::getInt('qstart', 0, 'GET'));
        $quoteCriteria = new \CriteriaCompo();
        $quoteCriteria->add(new \Criteria('author_id', $author['id']));
        $quoteCriteria->add(new \Criteria('online', 1));
        $quoteCount = $quoteHandler->getCount($quoteCriteria);

        $quoteCriteria->setSort('created');
        $quoteCriteria->setOrder('DESC');
        $quoteCriteria->setLimit(1);
        $quoteCriteria->setStart($quoteStart);

        $authorQuote = [];
        foreach ($quoteHandler->getAll($quoteCriteria) as $quoteObject) {
            $authorQuote = [
                'id'    => (int)$quoteObject->getVar('id'),
                'quote' => quotes_render_rich_text((string)$quoteObject->getVar('quote', 'n')),
                'url'   => \Xoops\Helpers\Service\Url::module('quotes', 'quote.php', ['op' => 'view', 'id' => (int)$quoteObject->getVar('id')]),
            ];
            break;
        }

        $GLOBALS['xoopsTpl']->assign('author_quote', $authorQuote);
        $GLOBALS['xoopsTpl']->assign('author_quote_nav', [
            'prev'  => $quoteStart > 0 ? \Xoops\Helpers\Service\Url::module('quotes', 'author.php', ['op' => 'view', 'id' => $author['id'], 'qstart' => $quoteStart - 1]) : '',
            'next'  => ($quoteStart + 1) < $quoteCount ? \Xoops\Helpers\Service\Url::module('quotes', 'author.php', ['op' => 'view', 'id' => $author['id'], 'qstart' => $quoteStart + 1]) : '',
            'count' => $quoteCount,
            'index' => $quoteCount > 0 ? $quoteStart + 1 : 0,
        ]);

        //       $GLOBALS['xoopsTpl']->append('author', $author);
        $keywords[] = $authorObject->getVar('name');

        $GLOBALS['xoopsTpl']->assign('author', $author);
        $start = $id;

        // Display Navigation
        if ($authorCount > $authorPaginationLimit) {
            $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \Xoops\Helpers\Service\Url::module('quotes', 'author.php'));
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
            $countryList = \XoopsLists::getCountryList();
            foreach (array_keys($authorArray) as $i) {
                $author['id']      = (int)$authorArray[$i]->getVar('id');
                $author['name']    = $authorArray[$i]->getVar('name');
                $author['name']    = $utility::truncateHtml($author['name'], $helper->getConfig('truncatelength'));
                $country           = (string)$authorArray[$i]->getVar('country');
                $author['country'] = \strip_tags($countryList[$country] ?? $country);
                $author['bio']     = $authorArray[$i]->getVar('bio');
                $author['bio']     = $utility::truncateHtml($author['bio'], $helper->getConfig('truncatelength'));
                $author['photo']   = $authorArray[$i]->getVar('photo');
                $author['photo_url'] = quotes_author_photo_url((string)$author['photo']);
                $author['created'] = formatTimestamp($authorArray[$i]->getVar('created'), 's');
                $author['updated'] = formatTimestamp($authorArray[$i]->getVar('updated'), 's');
                $author['url']     = \Xoops\Helpers\Service\Url::module('quotes', 'author.php', ['op' => 'view', 'id' => $author['id']]);
                $author['can_edit'] = quotes_user_can_edit_author($authorArray[$i]);
                $GLOBALS['xoopsTpl']->append('author', $author);
                $keywords[] = $authorArray[$i]->getVar('name');
                unset($author);
            }
            // Display Navigation
            if ($authorCount > $authorPaginationLimit) {
                $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \Xoops\Helpers\Service\Url::module('quotes', 'author.php'));
                // SHOWCASE: data-driven pagination via xoops/smartyextensions render_pagination (S1, BS5, windowed).
                $GLOBALS['xoopsTpl']->assign('pagination', [
                    'total' => $authorCount,
                    'limit' => $authorPaginationLimit,
                    'start' => $start,
                    'url'   => \Xoops\Helpers\Service\Url::module('quotes', 'author.php') . '?start={start}',
                ]);
            }
        }
}

//keywords
if (isset($keywords)) {
    $utility::metaKeywords($helper->getConfig('keywords') . ', ' . implode(', ', $keywords));
}
//description
$utility::metaDescription(_MD_QUOTES_AUTHOR_DESC);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \Xoops\Helpers\Service\Url::module('quotes', 'author.php'));
$GLOBALS['xoopsTpl']->assign('quotes_url', \Xoops\Helpers\Service\Url::module('quotes'));
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));

$GLOBALS['xoopsTpl']->assign('bookmarks', $helper->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $helper->getConfig('fbcomments'));

$GLOBALS['xoopsTpl']->assign('admin', QUOTES_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);

require XOOPS_ROOT_PATH . '/footer.php';

function quotes_author_photo_url(string $photo): string
{
    if ('blank.png' === \strtolower($photo)) {
        return '';
    }

    return '' !== $photo ? \Xoops\Helpers\Service\Url::moduleUpload('quotes', 'author/' . \rawurlencode($photo)) : '';
}
