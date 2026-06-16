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

function showQuotesAuthor(array $options): array
{
    if (!\class_exists(Helper::class) || '' !== quotes_mtools_dependency_error()) {
        return ['items' => []];
    }

    $limit       = \max(1, (int)($options[1] ?? 5));
    $titleLength = \max(20, (int)($options[2] ?? 90));
    $selectedIds = quotes_author_block_selected_ids($options);

    try {
        $helper        = Helper::getInstance();
        $authorHandler = $helper->getHandler('Author');
        $criteria      = new \CriteriaCompo();
        if ([] !== $selectedIds) {
            $criteria->add(new \Criteria('id', $selectedIds, 'IN'));
        }
        $criteria->setSort('name');
        $criteria->setOrder('ASC');
        $criteria->setLimit($limit);

        $items = [];
        $countries = \class_exists('XoopsLists') ? \XoopsLists::getCountryList() : [];
        foreach ($authorHandler->getAll($criteria) as $authorObject) {
            $photo = quotes_author_block_photo((string)$authorObject->getVar('photo'));
            $countryCode = (string)$authorObject->getVar('country');
            $items[] = [
                'id'      => (int)$authorObject->getVar('id'),
                'name'    => (string)$authorObject->getVar('name'),
                'country' => (string)($countries[$countryCode] ?? $countryCode),
                'bio'     => quotes_author_block_excerpt((string)$authorObject->getVar('bio', 'n'), $titleLength),
                'photo'   => '' !== $photo ? \XOOPS_UPLOAD_URL . '/quotes/author/' . \rawurlencode($photo) : '',
                'url'     => \XOOPS_URL . '/modules/quotes/author.php?op=view&id=' . (int)$authorObject->getVar('id'),
            ];
        }

        return [
            'items' => $items,
            'url'   => \XOOPS_URL . '/modules/quotes/author.php',
        ];
    } catch (\Throwable) {
        return ['items' => []];
    }
}

function editQuotesAuthor(array $options): string
{
    $limit       = \max(1, (int)($options[1] ?? 5));
    $titleLength = \max(20, (int)($options[2] ?? 90));
    $selectedIds = quotes_author_block_selected_ids($options);

    $form = quotes_author_block_input_row(\defined('MB_QUOTES_DISPLAY') ? \MB_QUOTES_DISPLAY : 'Items to display', 'options[1]', (string)$limit);
    $form .= quotes_author_block_input_row(\defined('MB_QUOTES_TITLELENGTH') ? \MB_QUOTES_TITLELENGTH : 'Text length', 'options[2]', (string)$titleLength);
    $form .= "<input type='hidden' name='options[0]' value='1'>";

    if (!\class_exists(Helper::class)) {
        return $form;
    }

    try {
        $helper        = Helper::getInstance();
        $authorHandler = $helper->getHandler('Author');
        $criteria      = new \CriteriaCompo();
        $criteria->setSort('name');
        $criteria->setOrder('ASC');

        $form .= "<label>" . quotes_author_block_escape(\defined('MB_QUOTES_CATTODISPLAY') ? \MB_QUOTES_CATTODISPLAY : 'Items to display') . "</label><br>";
        $form .= "<select name='options[]' multiple='multiple' size='6'>";
        $form .= "<option value='0'" . ([] === $selectedIds ? " selected='selected'" : '') . '>' . quotes_author_block_escape(\defined('MB_QUOTES_ALLCAT') ? \MB_QUOTES_ALLCAT : 'All') . '</option>';
        foreach ($authorHandler->getAll($criteria) as $authorObject) {
            $id       = (int)$authorObject->getVar('id');
            $selected = \in_array($id, $selectedIds, true) ? " selected='selected'" : '';
            $form     .= "<option value='{$id}'{$selected}>" . quotes_author_block_escape((string)$authorObject->getVar('name')) . '</option>';
        }
        $form .= '</select>';
    } catch (\Throwable) {
        return $form;
    }

    return $form;
}

function quotes_author_block_selected_ids(array $options): array
{
    $raw = \array_map('intval', \array_slice($options, 3));
    if (\in_array(0, $raw, true)) {
        return [];
    }

    return \array_values(\array_filter($raw, static fn (int $id): bool => $id > 0));
}

function quotes_author_block_excerpt(string $text, int $length): string
{
    $plain = \trim(\strip_tags($text));
    if (\mb_strlen($plain, 'UTF-8') <= $length) {
        return $plain;
    }

    return \rtrim(\mb_substr($plain, 0, $length - 1, 'UTF-8')) . '...';
}

function quotes_author_block_photo(string $photo): string
{
    return 'blank.png' === \strtolower($photo) ? '' : $photo;
}

function quotes_author_block_input_row(string $label, string $name, string $value): string
{
    return '<label>' . quotes_author_block_escape($label) . "</label><br><input name='" . quotes_author_block_escape($name) . "' size='5' maxlength='4' value='" . quotes_author_block_escape($value) . "' type='number' min='1'><br><br>";
}

function quotes_author_block_escape(string $value): string
{
    return \htmlspecialchars($value, \ENT_QUOTES | \ENT_SUBSTITUTE, 'UTF-8');
}
