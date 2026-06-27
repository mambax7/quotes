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
use XoopsModules\Quotes\AuthorHandler;
use XoopsModules\Quotes\CategoryHandler;
use XoopsModules\Quotes\Helper;
use XoopsModules\Quotes\Quote;
use XoopsModules\Quotes\QuoteHandler;

/** @var Quote $quoteObject */
/** @var QuoteHandler $quoteHandler */
/** @var AuthorHandler $authorHandler */
/** @var CategoryHandler $categoryHandler */
/** @var Helper $helper */
require __DIR__ . '/header.php';

$op = Request::getString('op', 'list', 'REQUEST');

if (!\in_array($op, ['edit', 'save'], true)) {
    if ('view' === $op) {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_quote.tpl';
    } else {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_quote_list0.tpl';
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
$quoteHandler = $helper->getHandler('Quote');

$quotePaginationLimit = $helper->getConfig('userpager');

$criteria = new \CriteriaCompo();

$criteria->add(new \Criteria('online', 1));
$criteria->setSort('created');
$criteria->setOrder('DESC');
$criteria->setLimit($quotePaginationLimit);
$criteria->setStart($start);

$quoteCount = $quoteHandler->getCount($criteria);
$quoteArray = $quoteHandler->getAll($criteria);

$id = Request::getInt('id', 0, 'GET');

switch ($op) {
    case 'edit':
        $editId      = Request::getInt('id', 0, 'GET');
        $quoteObject = $quoteHandler->get($editId);
        if ($editId > 0) {
            // Editing an existing quote: admin OR owner-with-permission (server-side).
            if (!quotes_user_can_edit_quote($quoteObject)) {
                redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'quote.php'), 3, _NOPERM);
            }
        } elseif (!quotes_user_can_submit()) {
            // Creating a new quote: per-category submit right (unchanged).
            redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'quote.php'), 3, _NOPERM);
        }
        $form = $quoteObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'quote.php'), 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $saveId           = Request::getInt('id', 0, 'POST');
        $authorIdOverride = null;
        if ($saveId > 0) {
            // Edit: re-load + ownership gate (do not trust POST).
            if (!quotes_user_can_edit_quote($quoteHandler->get($saveId))) {
                redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'quote.php'), 3, _NOPERM);
            }
        } else {
            // Create: per-category submit right on the target category.
            if (!quotes_user_can_submit_to_category(Request::getInt('cid', 0, 'POST'))) {
                redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'quote.php'), 3, _NOPERM);
            }
            // Resolve the author: a filled "new author" name wins over the dropdown selection.
            $newAuthorName = \trim(Request::getString('name', '', 'POST'));
            if ('' !== $newAuthorName) {
                $authorResult = $authorHandler->saveFromRequest($helper, $helper->isUserAdmin());
                if (!$authorResult['ok']) {
                    echo $authorResult['errors'];
                    $quoteHandler->create()->getForm()->display();
                    break;
                }
                $authorIdOverride = (int)$authorResult['object']->getVar('id');
            } elseif (Request::getInt('author_id', 0, 'POST') <= 0) {
                redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'quote.php'), 3, _AM_QUOTES_NEED_AUTHOR);
            }
        }
        $result = $quoteHandler->saveFromRequest($helper, $helper->isUserAdmin(), $authorIdOverride);
        if ($result['ok']) {
            redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'quote.php', ['op' => 'view', 'id' => (int)$result['object']->getVar('id')]), 2, _AM_QUOTES_FORMOK);
        }
        echo $result['errors'];
        $form = $result['object']->getForm();
        $form->display();
        break;
    case 'view':
        //        viewItem();
        $quotePaginationLimit = 1;
        $myid                 = $id;
        //id
        $quoteObject = $quoteHandler->get($myid);
        if (!\is_object($quoteObject)) {
            redirect_header(\Xoops\Helpers\Service\Url::module('quotes', 'quote.php'), 3, _NOPERM);
            exit;
        }

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id');
        $criteria->setOrder('DESC');
        $criteria->setLimit($quotePaginationLimit);
        $criteria->setStart($start);
        $categoryObject = $categoryHandler->get((int)$quoteObject->getVar('cid'));
        $authorObject   = $authorHandler->get((int)$quoteObject->getVar('author_id'));

        $quote['id']          = (int)$quoteObject->getVar('id');
        $quote['category_id'] = (int)$quoteObject->getVar('cid');
        $quote['category']    = \is_object($categoryObject) ? $categoryObject->getVar('title') : '';
        $quote['author_id']   = (int)$quoteObject->getVar('author_id');
        $authorPhoto          = \is_object($authorObject) ? (string)$authorObject->getVar('photo') : '';
        $quote['author']      = \is_object($authorObject) ? $authorObject->getVar('name') : '';
        $quote['author_photo_url'] = quotes_author_photo_url($authorPhoto);
        $quote['quote']       = quotes_render_rich_text((string)$quoteObject->getVar('quote', 'n'));
        $quote['online']      = (int)$quoteObject->getVar('online');
        $quote['created']     = formatTimestamp($quoteObject->getVar('created'), 's');
        $quote['updated']     = (int)$quoteObject->getVar('updated') > 0 ? formatTimestamp($quoteObject->getVar('updated'), 's') : '';
        $quote['url']         = \Xoops\Helpers\Service\Url::module('quotes', 'quote.php', ['op' => 'view', 'id' => $quote['id']]);
        $quote['can_edit']    = quotes_user_can_edit_quote($quoteObject);

        //       $GLOBALS['xoopsTpl']->append('quote', $quote);
        $keywords[] = $quoteObject->getVar('quote');

        $GLOBALS['xoopsTpl']->assign('quote', $quote);
        $GLOBALS['xoopsTpl']->assign('quote_nav', quotes_author_quote_nav($quoteHandler, $quote['author_id'], $quote['id']));

        break;
    case 'list':
    default:
        //        viewall();

        if ($quoteCount > 0) {
            $GLOBALS['xoopsTpl']->assign('quote', []);
            $countryList = \XoopsLists::getCountryList();
            foreach (array_keys($quoteArray) as $i) {
                $categoryObject = $categoryHandler->get((int)$quoteArray[$i]->getVar('cid'));
                $authorObject   = $authorHandler->get((int)$quoteArray[$i]->getVar('author_id'));
                $authorPhoto    = \is_object($authorObject) ? (string)$authorObject->getVar('photo') : '';
                $countryCode    = \is_object($authorObject) ? (string)$authorObject->getVar('country') : '';

                $quote['id']          = (int)$quoteArray[$i]->getVar('id');
                $quote['category_id'] = (int)$quoteArray[$i]->getVar('cid');
                $quote['category']    = \is_object($categoryObject) ? $categoryObject->getVar('title') : '';
                $quote['author_id']   = (int)$quoteArray[$i]->getVar('author_id');
                $quote['author']      = \is_object($authorObject) ? $authorObject->getVar('name') : '';
                $quote['author_country'] = \strip_tags($countryList[$countryCode] ?? $countryCode);
                $quote['author_photo_url'] = quotes_author_photo_url($authorPhoto);
                $quote['quote']       = quotes_render_rich_text($utility::truncateHtml((string)$quoteArray[$i]->getVar('quote', 'n'), 180));
                $quote['online']      = (int)$quoteArray[$i]->getVar('online');
                $quote['created']     = formatTimestamp($quoteArray[$i]->getVar('created'), 's');
                $quote['updated']     = (int)$quoteArray[$i]->getVar('updated') > 0 ? formatTimestamp($quoteArray[$i]->getVar('updated'), 's') : '';
                $quote['url']         = \Xoops\Helpers\Service\Url::module('quotes', 'quote.php', ['op' => 'view', 'id' => $quote['id']]);
                $quote['can_edit']    = quotes_user_can_edit_quote($quoteArray[$i]);
                $GLOBALS['xoopsTpl']->append('quote', $quote);
                $keywords[] = $quoteArray[$i]->getVar('quote');
                unset($quote);
            }
            // Display Navigation
            if ($quoteCount > $quotePaginationLimit) {
                $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \Xoops\Helpers\Service\Url::module('quotes', 'quote.php'));
                // SHOWCASE: data-driven pagination via xoops/smartyextensions render_pagination (S1, BS5, windowed).
                $GLOBALS['xoopsTpl']->assign('pagination', [
                    'total' => $quoteCount,
                    'limit' => $quotePaginationLimit,
                    'start' => $start,
                    'url'   => \Xoops\Helpers\Service\Url::module('quotes', 'quote.php') . '?start={start}',
                ]);
            }
        }
}

//keywords
if (isset($keywords)) {
    $utility::metaKeywords($helper->getConfig('keywords') . ', ' . implode(', ', $keywords));
}
//description
$utility::metaDescription(_MD_QUOTES_QUOTE_DESC);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \Xoops\Helpers\Service\Url::module('quotes', 'quote.php'));
$GLOBALS['xoopsTpl']->assign('quotes_url', \Xoops\Helpers\Service\Url::module('quotes'));
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));

$GLOBALS['xoopsTpl']->assign('bookmarks', $helper->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $helper->getConfig('fbcomments'));

$GLOBALS['xoopsTpl']->assign('admin', QUOTES_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);

require XOOPS_ROOT_PATH . '/footer.php';

function quotes_author_photo_url(string $photo): string
{
    if ('' === $photo || 'blank.png' === \strtolower($photo)) {
        return '';
    }

    return \Xoops\Helpers\Service\Url::moduleUpload('quotes', 'author/' . \rawurlencode($photo));
}

function quotes_plain_text(string $text): string
{
    return \trim(\preg_replace('/\s+/u', ' ', \html_entity_decode(\strip_tags($text), \ENT_QUOTES | \ENT_HTML5, 'UTF-8')) ?? '');
}

function quotes_author_quote_nav(\XoopsPersistableObjectHandler $quoteHandler, int $authorId, int $quoteId): array
{
    if ($authorId <= 0 || $quoteId <= 0) {
        return ['prev' => '', 'next' => '', 'count' => 0, 'index' => 0];
    }

    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('author_id', $authorId));
    $criteria->add(new \Criteria('online', 1));
    $criteria->setSort('id');
    $criteria->setOrder('ASC');

    $quoteIds = [];
    foreach ($quoteHandler->getAll($criteria) as $authorQuoteObject) {
        $quoteIds[] = (int)$authorQuoteObject->getVar('id');
    }

    $quoteCount = \count($quoteIds);
    if ($quoteCount <= 1) {
        return ['prev' => '', 'next' => '', 'count' => $quoteCount, 'index' => $quoteCount];
    }

    $currentIndex = \array_search($quoteId, $quoteIds, true);
    if (false === $currentIndex) {
        return ['prev' => '', 'next' => '', 'count' => $quoteCount, 'index' => 0];
    }

    return [
        'prev'  => $currentIndex > 0 ? \Xoops\Helpers\Service\Url::module('quotes', 'quote.php', ['op' => 'view', 'id' => $quoteIds[$currentIndex - 1]]) : '',
        'next'  => ($currentIndex + 1) < $quoteCount ? \Xoops\Helpers\Service\Url::module('quotes', 'quote.php', ['op' => 'view', 'id' => $quoteIds[$currentIndex + 1]]) : '',
        'count' => $quoteCount,
        'index' => $currentIndex + 1,
    ];
}
