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
use XoopsModules\Quotes\Category;
use XoopsModules\Quotes\CategoryHandler;
use XoopsModules\Quotes\Helper;
use XoopsModules\Quotes\Utility;

/** @var Category $categoryObject */
/** @var CategoryHandler $categoryHandler */
/** @var Admin $adminObject */
/** @var Helper $helper */
require __DIR__ . '/header.php';

$utility = new Utility();
$op      = Request::getCmd('op', 'list', 'GET');

if ('edit' !== $op) {
    if ('view' === $op) {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_category.tpl';
    } else {
        $GLOBALS['xoopsOption']['template_main'] = 'quotes_category_list0.tpl';
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
$categoryHandler = $helper->getHandler('Category');

$categoryPaginationLimit = $helper->getConfig('userpager');

$criteria = new \CriteriaCompo();

$criteria->add(new \Criteria('online', 1));
$criteria->setSort('weight');
$criteria->setOrder('ASC');
$criteria->setLimit($categoryPaginationLimit);
$criteria->setStart($start);

$categoryCount = $categoryHandler->getCount($criteria);
$categoryArray = $categoryHandler->getAll($criteria);

$id = Request::getInt('id', 0, 'GET');

switch ($op) {
    case 'edit':
        $categoryObject = $categoryHandler->get(Request::getInt('id', 0, 'GET'));
        $form           = $categoryObject->getForm();
        $form->display();
        break;
    case 'view':
        //        viewItem();
        $categoryPaginationLimit = 1;
        $myid                    = $id;
        //id
        $categoryObject = $categoryHandler->get($myid);
        if (!\is_object($categoryObject)) {
            redirect_header(QUOTES_URL . '/category.php', 3, _NOPERM);
            exit;
        }

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id');
        $criteria->setOrder('DESC');
        $criteria->setLimit($categoryPaginationLimit);
        $criteria->setStart($start);
        $category['id']          = (int)$categoryObject->getVar('id');
        $category['pid']         = (int)$categoryObject->getVar('pid');
        $category['title']       = $categoryObject->getVar('title');
        $category['description'] = $categoryObject->getVar('description');
        $category['image']       = $categoryObject->getVar('image');
        $category['image_url']   = quotes_category_image_url((string)$category['image']);
        $category['visual_class'] = quotes_category_visual_class((string)$category['title']);
        $category['weight']      = (int)$categoryObject->getVar('weight');
        $category['color']       = quotes_category_color((string)$categoryObject->getVar('color'));
        $category['online']      = (int)$categoryObject->getVar('online');
        $category['url']         = QUOTES_URL . '/category.php?op=view&id=' . $category['id'];

        //       $GLOBALS['xoopsTpl']->append('category', $category);
        $keywords[] = $categoryObject->getVar('title');

        $categoryQuoteCriteria = new \CriteriaCompo(new \Criteria('online', 1));
        $categoryQuoteCriteria->add(new \Criteria('cid', $category['id']));
        $categoryQuoteCriteria->setSort('created');
        $categoryQuoteCriteria->setOrder('DESC');
        $categoryQuoteCriteria->setLimit(3);

        $categoryQuotes = [];
        $countryList    = \XoopsLists::getCountryList();
        foreach ($quoteHandler->getAll($categoryQuoteCriteria) as $quoteObject) {
            $authorObject = $authorHandler->get((int)$quoteObject->getVar('author_id'));
            $authorPhoto  = \is_object($authorObject) ? (string)$authorObject->getVar('photo') : '';
            $countryCode  = \is_object($authorObject) ? (string)$authorObject->getVar('country') : '';

            $categoryQuotes[] = [
                'id'               => (int)$quoteObject->getVar('id'),
                'quote'            => quotes_render_rich_text($utility::truncateHtml((string)$quoteObject->getVar('quote', 'n'), 180)),
                'author'           => \is_object($authorObject) ? $authorObject->getVar('name') : '',
                'author_country'   => \strip_tags($countryList[$countryCode] ?? $countryCode),
                'author_photo_url' => quotes_category_author_photo_url($authorPhoto),
                'category'         => $category['title'],
                'url'              => QUOTES_URL . '/quote.php?op=view&id=' . (int)$quoteObject->getVar('id'),
            ];
        }

        $GLOBALS['xoopsTpl']->assign('category', $category);
        $GLOBALS['xoopsTpl']->assign('category_quotes', $categoryQuotes);

        break;
    case 'list':
    default:
        //        viewall();

        if ($categoryCount > 0) {
            $GLOBALS['xoopsTpl']->assign('category', []);
            foreach (array_keys($categoryArray) as $i) {
                $category['id']          = (int)$categoryArray[$i]->getVar('id');
                $category['pid']         = (int)$categoryArray[$i]->getVar('pid');
                $category['title']       = $categoryArray[$i]->getVar('title');
                $category['title']       = $utility::truncateHtml($category['title'], $helper->getConfig('truncatelength'));
                $category['description'] = $categoryArray[$i]->getVar('description');
                $category['description'] = $utility::truncateHtml($category['description'], $helper->getConfig('truncatelength'));
                $category['image']       = $categoryArray[$i]->getVar('image');
                $category['image_url']   = quotes_category_image_url((string)$category['image']);
                $category['visual_class'] = quotes_category_visual_class((string)$category['title']);
                $category['weight']      = (int)$categoryArray[$i]->getVar('weight');
                $category['color']       = quotes_category_color((string)$categoryArray[$i]->getVar('color'));
                $category['online']      = (int)$categoryArray[$i]->getVar('online');
                $category['url']         = QUOTES_URL . '/category.php?op=view&id=' . $category['id'];
                $GLOBALS['xoopsTpl']->append('category', $category);
                $keywords[] = $categoryArray[$i]->getVar('title');
                unset($category);
            }
            // Display Navigation
            if ($categoryCount > $categoryPaginationLimit) {
                $GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTES_URL . '/category.php');
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav($categoryCount, $categoryPaginationLimit, $start, 'start');
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        }
}

//keywords
if (isset($keywords)) {
    $utility::metaKeywords($helper->getConfig('keywords') . ', ' . implode(', ', $keywords));
}
//description
$utility::metaDescription(MD_QUOTES_CATEGORY_DESC);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTES_URL . '/category.php');
$GLOBALS['xoopsTpl']->assign('quotes_url', QUOTES_URL);
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));

$GLOBALS['xoopsTpl']->assign('bookmarks', $helper->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $helper->getConfig('fbcomments'));

$GLOBALS['xoopsTpl']->assign('admin', QUOTES_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);

require XOOPS_ROOT_PATH . '/footer.php';

function quotes_category_image_url(string $image): string
{
    if ('blank.png' === \strtolower($image)) {
        return '';
    }

    return '' !== $image ? QUOTES_UPLOAD_URL . '/category/' . \rawurlencode($image) : '';
}

function quotes_category_author_photo_url(string $photo): string
{
    if ('' === $photo || 'blank.png' === \strtolower($photo)) {
        return '';
    }

    return QUOTES_UPLOAD_URL . '/author/' . \rawurlencode($photo);
}

function quotes_category_plain_text(string $text): string
{
    return \trim(\preg_replace('/\s+/u', ' ', \html_entity_decode(\strip_tags($text), \ENT_QUOTES | \ENT_HTML5, 'UTF-8')) ?? '');
}

function quotes_category_color(string $color): string
{
    return 1 === \preg_match('/^#[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $color) ? $color : '#456268';
}

function quotes_category_visual_class(string $title): string
{
    $normalized = \strtolower(\trim($title));

    return match ($normalized) {
        'science' => 'quotes-category-visual--science',
        'politics' => 'quotes-category-visual--politics',
        'arts' => 'quotes-category-visual--arts',
        default => 'quotes-category-visual--default',
    };
}
