<?php

declare(strict_types=1);

namespace XoopsModules\Quotes\Form;

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

use Xmf\Module\Helper\Permission;
use Xmf\Request;
use XoopsModules\Quotes;

require_once \dirname(__DIR__, 2) . '/include/common.php';

$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Quotes\Helper::getInstance();
$permHelper = new Permission();

\xoops_load('XoopsFormLoader');

/**
 * Class QuoteForm
 */
class QuoteForm extends \XoopsThemeForm
{
    public $targetObject;
    public $helper;

    /**
     * Constructor
     *
     * @param $target
     */
    public function __construct($target)
    {
        $this->helper       = $target->helper;
        $this->targetObject = $target;

        $title = $this->targetObject->isNew() ? \AM_QUOTES_QUOTE_ADD : \AM_QUOTES_QUOTE_EDIT;
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new \XoopsFormHidden('id', $this->targetObject->getVar('id'));
        $this->addElement($hidden);
        unset($hidden);

        // Id
        $this->addElement(new \XoopsFormLabel(\AM_QUOTES_QUOTE_ID, $this->targetObject->getVar('id'), 'id'));
        // Cid
        //$categoryHandler = $this->helper->getHandler('Category');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $categoryHandler */
        $categoryHandler = $this->helper->getHandler('Category');

        $category_id_select = new \XoopsFormSelect(\AM_QUOTES_QUOTE_CID, 'cid', $this->targetObject->getVar('cid'));
        $category_id_select->addOptionArray($categoryHandler->getList());
        $this->addElement($category_id_select, false);
        // Author_id
        //$authorHandler = $this->helper->getHandler('Authors');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $authorHandler */
        $authorHandler = $this->helper->getHandler('Author');

        $authors_id_select = new \XoopsFormSelect(\AM_QUOTES_QUOTE_AUTHOR_ID, 'author_id', $this->targetObject->getVar('author_id'));
        $authors_id_select->addOptionArray($authorHandler->getList());
        $this->addElement($authors_id_select, false);
        // Quote
        if (\class_exists('XoopsFormEditor')) {
            $editorOptions           = [];
            $editorOptions['name']   = 'quote';
            $editorOptions['value']  = $this->targetObject->getVar('quote', 'e');
            $editorOptions['rows']   = 5;
            $editorOptions['cols']   = 40;
            $editorOptions['width']  = '100%';
            $editorOptions['height'] = '400px';
            //$editorOptions['editor'] = xoops_getModuleOption('quotes_editor', 'quotes');
            //$this->addElement( new \XoopsFormEditor(AM_QUOTES_QUOTE_QUOTE, 'quote', $editorOptions), false  );
            if ($this->helper->isUserAdmin()) {
                $descEditor = new \XoopsFormEditor(\AM_QUOTES_QUOTE_QUOTE, $this->helper->getConfig('quotesEditorAdmin'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            } else {
                $descEditor = new \XoopsFormEditor(\AM_QUOTES_QUOTE_QUOTE, $this->helper->getConfig('quotesEditorUser'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea(\AM_QUOTES_QUOTE_QUOTE, 'description', $this->targetObject->getVar('description', 'e'), 5, 50);
        }
        $this->addElement($descEditor);
        // Online
        $online       = $this->targetObject->isNew() ? 0 : $this->targetObject->getVar('online');
        $check_online = new \XoopsFormCheckBox(\AM_QUOTES_QUOTE_ONLINE, 'online', $online);
        $check_online->addOption(1, ' ');
        $this->addElement($check_online);
        // Created
        $this->addElement(new \XoopsFormTextDateSelect(\AM_QUOTES_QUOTE_CREATED, 'created', 0, \formatTimestamp($this->targetObject->getVar('created'), 's')));
        // Updated
        $this->addElement(new \XoopsFormTextDateSelect(\AM_QUOTES_QUOTE_UPDATED, 'updated', 0, \formatTimestamp($this->targetObject->getVar('updated'), 's')));

        $this->addElement(new \XoopsFormHidden('op', 'save'));
        $this->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    }
}
