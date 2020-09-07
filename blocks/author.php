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
use XoopsModules\Quotes\Helper;

/**
 * @param $options
 *
 * @return array
 */
function showQuotesAuthor($options)
{
    // require dirname(__DIR__) . '/class/author.php';
    ///  $moduleDirName = basename(dirname(__DIR__));
    //$myts = \MyTextSanitizer::getInstance();

    $block       = [];
    $blockType   = $options[0];
    $authorCount = $options[1];
    //$titleLenght = $options[2];

    /** @var Helper $helper */
    if (!class_exists(Helper::class)) {
        return false;
    }

    $helper = Helper::getInstance();

    /** @var \XoopsPersistableObjectHandler $authorHandler */
    $authorHandler = $helper->getHandler('Author');
    $criteria      = new \CriteriaCompo();
    array_shift($options);
    array_shift($options);
    array_shift($options);
    if ($blockType) {
        $criteria->add(new \Criteria('id', 0, '!='));
        $criteria->setSort('id');
        $criteria->setOrder('ASC');
    }

    $criteria->setLimit($authorCount);
    $authorArray = $authorHandler->getAll($criteria);
    foreach (array_keys($authorArray) as $i) {
    }

    return $block;
}

/**
 * @param $options
 *
 * @return string
 */
function editQuotesAuthor($options)
{
    //require dirname(__DIR__) . '/class/author.php';
    // $moduleDirName = basename(dirname(__DIR__));

    $form = MB_QUOTES_DISPLAY;
    $form .= "<input type='hidden' name='options[0]' value='" . $options[0] . "' >";
    $form .= "<input name='options[1]' size='5' maxlength='255' value='" . $options[1] . "' type='text' >&nbsp;<br>";
    $form .= MB_QUOTES_TITLELENGTH . " : <input name='options[2]' size='5' maxlength='255' value='" . $options[2] . "' type='text' ><br><br>";

    /** @var \XoopsModules\Quotes\Helper $helper */
    $helper = \XoopsModules\Quotes\Helper::getInstance();

    /** @var \XoopsPersistableObjectHandler $authorHandler */
    $authorHandler = $helper->getHandler('Author');

    $criteria = new \CriteriaCompo();
    array_shift($options);
    array_shift($options);
    array_shift($options);
    $criteria->add(new \Criteria('id', 0, '!='));
    $criteria->setSort('id');
    $criteria->setOrder('ASC');
    $authorArray = $authorHandler->getAll($criteria);
    $form        .= MB_QUOTES_CATTODISPLAY . "<br><select name='options[]' multiple='multiple' size='5'>";
    $form        .= "<option value='0' " . (false === in_array(0, $options) ? '' : "selected='selected'") . '>' . MB_QUOTES_ALLCAT . '</option>';
    foreach (array_keys($authorArray) as $i) {
        $id   = $authorArray[$i]->getVar('id');
        $form .= "<option value='" . $id . "' " . (false === in_array($id, $options) ? '' : "selected='selected'") . '>' . $authorArray[$i]->getVar('name') . '</option>';
    }
    $form .= '</select>';

    return $form;
}
