<?php declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

use XoopsModules\Quotes\Helper;

require_once \dirname(__DIR__) . '/bootstrap.php';

if (\function_exists('xoops_loadLanguage')) {
    \xoops_loadLanguage('blocks', 'quotes');
    \xoops_loadLanguage('main', 'quotes');
}

function showQuotesQuote(array $options): array
{
    if (!\class_exists(Helper::class) || '' !== quotes_mtools_dependency_error()) {
        return ['items' => []];
    }

    $limit       = \max(1, (int)($options[1] ?? 5));
    $titleLength = \max(20, (int)($options[2] ?? 140));
    $selectedIds = quotes_block_selected_ids($options);

    try {
        $helper          = Helper::getInstance();
        $quoteHandler    = $helper->getHandler('Quote');
        $authorHandler   = $helper->getHandler('Author');
        $categoryHandler = $helper->getHandler('Category');

        $criteria = new \CriteriaCompo();
        $criteria->add(new \Criteria('online', 1));
        if ([] !== $selectedIds) {
            $criteria->add(new \Criteria('id', $selectedIds, 'IN'));
        }
        $criteria->setSort('created');
        $criteria->setOrder('DESC');
        $criteria->setLimit($limit);

        $items = [];
        foreach ($quoteHandler->getAll($criteria) as $quoteObject) {
            $authorId       = (int)$quoteObject->getVar('author_id');
            $authorObject   = $authorHandler->get($authorId);
            $categoryObject = $categoryHandler->get((int)$quoteObject->getVar('cid'));
            $quoteText      = (string)$quoteObject->getVar('quote', 'n');

            $items[] = [
                'id'       => (int)$quoteObject->getVar('id'),
                'quote'    => quotes_block_plain($quoteText),
                'full'     => $quoteText,
                'author'   => \is_object($authorObject) ? (string)$authorObject->getVar('name') : '',
                'author_url' => $authorId > 0 ? \XOOPS_URL . '/modules/quotes/author.php?op=view&id=' . $authorId : '',
                'category' => \is_object($categoryObject) ? (string)$categoryObject->getVar('title') : '',
                'date'     => \formatTimestamp((int)$quoteObject->getVar('created'), 's'),
                'url'      => \XOOPS_URL . '/modules/quotes/quote.php?op=view&id=' . (int)$quoteObject->getVar('id'),
            ];
        }

        return [
            'items' => $items,
            'url'   => \XOOPS_URL . '/modules/quotes/quote.php',
        ];
    } catch (\Throwable) {
        return ['items' => []];
    }
}

function editQuotesQuote(array $options): string
{
    $limit       = \max(1, (int)($options[1] ?? 5));
    $titleLength = \max(20, (int)($options[2] ?? 140));
    $selectedIds = quotes_block_selected_ids($options);

    $form = quotes_block_input_row(\defined('MB_QUOTES_DISPLAY') ? \MB_QUOTES_DISPLAY : 'Items to display', 'options[1]', (string)$limit);
    $form .= quotes_block_input_row(\defined('MB_QUOTES_TITLELENGTH') ? \MB_QUOTES_TITLELENGTH : 'Text length', 'options[2]', (string)$titleLength);
    $form .= "<input type='hidden' name='options[0]' value='1'>";

    if (!\class_exists(Helper::class)) {
        return $form;
    }

    try {
        $helper       = Helper::getInstance();
        $quoteHandler = $helper->getHandler('Quote');
        $criteria     = new \CriteriaCompo(new \Criteria('online', 1));
        $criteria->setSort('id');
        $criteria->setOrder('ASC');
        $quoteArray = $quoteHandler->getAll($criteria);

        $form .= "<label>" . quotes_block_escape(\defined('MB_QUOTES_CATTODISPLAY') ? \MB_QUOTES_CATTODISPLAY : 'Items to display') . "</label><br>";
        $form .= "<select name='options[]' multiple='multiple' size='6'>";
        $form .= "<option value='0'" . ([] === $selectedIds ? " selected='selected'" : '') . '>' . quotes_block_escape(\defined('MB_QUOTES_ALLCAT') ? \MB_QUOTES_ALLCAT : 'All') . '</option>';
        foreach ($quoteArray as $quoteObject) {
            $id       = (int)$quoteObject->getVar('id');
            $selected = \in_array($id, $selectedIds, true) ? " selected='selected'" : '';
            $label    = quotes_block_excerpt((string)$quoteObject->getVar('quote', 'n'), 70);
            $form     .= "<option value='{$id}'{$selected}>" . quotes_block_escape($label) . '</option>';
        }
        $form .= '</select>';
    } catch (\Throwable) {
        return $form;
    }

    return $form;
}

function quotes_block_selected_ids(array $options): array
{
    $selected = \array_slice($options, 3);
    $selected = \array_values(\array_filter(\array_map('intval', $selected), static fn (int $id): bool => $id > 0));

    return \in_array(0, \array_map('intval', \array_slice($options, 3)), true) ? [] : $selected;
}

function quotes_block_excerpt(string $text, int $length): string
{
    $plain = quotes_block_plain($text);
    if (\mb_strlen($plain, 'UTF-8') <= $length) {
        return $plain;
    }

    return \rtrim(\mb_substr($plain, 0, $length - 1, 'UTF-8')) . '...';
}

function quotes_block_plain(string $text): string
{
    return \trim(\preg_replace('/\s+/u', ' ', \html_entity_decode(\strip_tags($text), \ENT_QUOTES | \ENT_HTML5, 'UTF-8')) ?? '');
}

function quotes_block_input_row(string $label, string $name, string $value): string
{
    return '<label>' . quotes_block_escape($label) . "</label><br><input name='" . quotes_block_escape($name) . "' size='5' maxlength='4' value='" . quotes_block_escape($value) . "' type='number' min='1'><br><br>";
}

function quotes_block_escape(string $value): string
{
    return \htmlspecialchars($value, \ENT_QUOTES | \ENT_SUBSTITUTE, 'UTF-8');
}
