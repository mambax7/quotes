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

use XoopsModules\Quotes;

$GLOBALS['xoopsOption']['template_main'] = 'quotes_index.tpl';
require __DIR__ . '/header.php';
require XOOPS_ROOT_PATH . '/header.php';
//require __DIR__ . '/include/config.php';

global $xoTheme;

// Define Stylesheet
/** @var xos_opal_Theme $xoTheme */
quotes_register_theme_assets($stylesheet);

$onlineQuotesCriteria = new \CriteriaCompo(new \Criteria('online', 1));
$onlineQuotesCriteria->setSort('created');
$onlineQuotesCriteria->setOrder('DESC');
$onlineQuotesCriteria->setLimit(3);

$onlineCategoriesCriteria = new \CriteriaCompo(new \Criteria('online', 1));

$latestQuotes = [];
$countryList  = \XoopsLists::getCountryList();
foreach ($quoteHandler->getAll($onlineQuotesCriteria) as $quoteObject) {
    $categoryObject = $categoryHandler->get((int)$quoteObject->getVar('cid'));
    $authorObject   = $authorHandler->get((int)$quoteObject->getVar('author_id'));
    $authorPhoto    = \is_object($authorObject) ? (string)$authorObject->getVar('photo') : '';
    $countryCode    = \is_object($authorObject) ? (string)$authorObject->getVar('country') : '';

    $latestQuotes[] = [
        'id'               => (int)$quoteObject->getVar('id'),
        'quote'            => quotes_render_rich_text($utility::truncateHtml((string)$quoteObject->getVar('quote', 'n'), 180)),
        'author'           => \is_object($authorObject) ? $authorObject->getVar('name') : '',
        'author_country'   => \strip_tags($countryList[$countryCode] ?? $countryCode),
        'author_photo_url' => quotes_index_author_photo_url($authorPhoto),
        'category'         => \is_object($categoryObject) ? $categoryObject->getVar('title') : '',
        'url'              => QUOTES_URL . '/quote.php?op=view&id=' . (int)$quoteObject->getVar('id'),
    ];
}

$GLOBALS['xoopsTpl']->assign('quotes_stats', [
    'quotes'     => $quoteHandler->getCount($onlineQuotesCriteria),
    'categories' => $categoryHandler->getCount($onlineCategoriesCriteria),
    'authors'    => $authorHandler->getCount(),
]);
$GLOBALS['xoopsTpl']->assign('latest_quotes', $latestQuotes);
// keywords
$utility::metaKeywords($helper->getConfig('keywords'));
// description
$utility::metaDescription(MD_QUOTES_DESC);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', QUOTES_URL . '/index.php');
$GLOBALS['xoopsTpl']->assign('quotes_url', QUOTES_URL);
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));

$GLOBALS['xoopsTpl']->assign('bookmarks', $helper->getConfig('bookmarks'));
$GLOBALS['xoopsTpl']->assign('fbcomments', $helper->getConfig('fbcomments'));

$GLOBALS['xoopsTpl']->assign('admin', QUOTES_ADMIN);
$GLOBALS['xoopsTpl']->assign('copyright', $copyright);

require XOOPS_ROOT_PATH . '/footer.php';

function quotes_index_author_photo_url(string $photo): string
{
    if ('' === $photo || 'blank.png' === \strtolower($photo)) {
        return '';
    }

    return QUOTES_UPLOAD_URL . '/author/' . \rawurlencode($photo);
}

function quotes_index_plain_text(string $text): string
{
    return \trim(\preg_replace('/\s+/u', ' ', \html_entity_decode(\strip_tags($text), \ENT_QUOTES | \ENT_HTML5, 'UTF-8')) ?? '');
}
