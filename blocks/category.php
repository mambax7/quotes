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

function showQuotesCategory(array $options): array
{
    if (!\class_exists(Helper::class) || '' !== quotes_mtools_dependency_error()) {
        return ['items' => []];
    }

    $limit       = \max(1, (int)($options[1] ?? 5));
    $titleLength = \max(20, (int)($options[2] ?? 80));
    $selectedIds = quotes_category_block_selected_ids($options);

    try {
        $helper          = Helper::getInstance();
        $categoryHandler = $helper->getHandler('Category');
        $criteria        = new \CriteriaCompo(new \Criteria('online', 1));
        if ([] !== $selectedIds) {
            $criteria->add(new \Criteria('id', $selectedIds, 'IN'));
        }
        $criteria->setSort('weight');
        $criteria->setOrder('ASC');
        $criteria->setLimit($limit);

        $items = [];
        foreach ($categoryHandler->getAll($criteria) as $categoryObject) {
            $image = quotes_category_block_image((string)$categoryObject->getVar('image'));
            $items[] = [
                'id'          => (int)$categoryObject->getVar('id'),
                'title'       => (string)$categoryObject->getVar('title'),
                'description' => quotes_category_block_excerpt((string)$categoryObject->getVar('description', 'n'), $titleLength),
                'color'       => quotes_category_block_color((string)$categoryObject->getVar('color')),
                'image'       => '' !== $image ? \Xoops\Helpers\Service\Url::moduleUpload('quotes', 'category/' . \rawurlencode($image)) : '',
                'url'         => \Xoops\Helpers\Service\Url::module('quotes', 'category.php', ['op' => 'view', 'id' => (int)$categoryObject->getVar('id')]),
            ];
        }

        return [
            'items' => $items,
            'url'   => \Xoops\Helpers\Service\Url::module('quotes', 'category.php'),
        ];
    } catch (\Throwable) {
        return ['items' => []];
    }
}

function editQuotesCategory(array $options): string
{
    $limit       = \max(1, (int)($options[1] ?? 5));
    $titleLength = \max(20, (int)($options[2] ?? 80));
    $selectedIds = quotes_category_block_selected_ids($options);

    $form = quotes_category_block_input_row(\defined('_MB_QUOTES_DISPLAY') ? \_MB_QUOTES_DISPLAY : 'Items to display', 'options[1]', (string)$limit);
    $form .= quotes_category_block_input_row(\defined('_MB_QUOTES_TITLELENGTH') ? \_MB_QUOTES_TITLELENGTH : 'Text length', 'options[2]', (string)$titleLength);
    $form .= "<input type='hidden' name='options[0]' value='1'>";

    if (!\class_exists(Helper::class)) {
        return $form;
    }

    try {
        $helper          = Helper::getInstance();
        $categoryHandler = $helper->getHandler('Category');
        $criteria        = new \CriteriaCompo(new \Criteria('online', 1));
        $criteria->setSort('title');
        $criteria->setOrder('ASC');

        $form .= "<label>" . quotes_category_block_escape(\defined('_MB_QUOTES_CATTODISPLAY') ? \_MB_QUOTES_CATTODISPLAY : 'Items to display') . "</label><br>";
        $form .= "<select name='options[]' multiple='multiple' size='6'>";
        $form .= "<option value='0'" . ([] === $selectedIds ? " selected='selected'" : '') . '>' . quotes_category_block_escape(\defined('_MB_QUOTES_ALLCAT') ? \_MB_QUOTES_ALLCAT : 'All') . '</option>';
        foreach ($categoryHandler->getAll($criteria) as $categoryObject) {
            $id       = (int)$categoryObject->getVar('id');
            $selected = \in_array($id, $selectedIds, true) ? " selected='selected'" : '';
            $form     .= "<option value='{$id}'{$selected}>" . quotes_category_block_escape((string)$categoryObject->getVar('title')) . '</option>';
        }
        $form .= '</select>';
    } catch (\Throwable) {
        return $form;
    }

    return $form;
}

function quotes_category_block_selected_ids(array $options): array
{
    $raw = \array_map('intval', \array_slice($options, 3));
    if (\in_array(0, $raw, true)) {
        return [];
    }

    return \array_values(\array_filter($raw, static fn (int $id): bool => $id > 0));
}

function quotes_category_block_excerpt(string $text, int $length): string
{
    $plain = \trim(\strip_tags($text));
    if (\mb_strlen($plain, 'UTF-8') <= $length) {
        return $plain;
    }

    return \rtrim(\mb_substr($plain, 0, $length - 1, 'UTF-8')) . '...';
}

function quotes_category_block_image(string $image): string
{
    return 'blank.png' === \strtolower($image) ? '' : $image;
}

function quotes_category_block_color(string $value): string
{
    return \preg_match('/^#[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $value) ? $value : '#64748b';
}

function quotes_category_block_input_row(string $label, string $name, string $value): string
{
    return '<label>' . quotes_category_block_escape($label) . "</label><br><input name='" . quotes_category_block_escape($name) . "' size='5' maxlength='4' value='" . quotes_category_block_escape($value) . "' type='number' min='1'><br><br>";
}

function quotes_category_block_escape(string $value): string
{
    return \Xoops\Helpers\Utility\HtmlBuilder::escape($value);
}
