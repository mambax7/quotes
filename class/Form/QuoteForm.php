<?php declare(strict_types=1);

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
 * @copyright       2000-2026 XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use Xmf\Module\Helper\Permission;
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

        $title = $this->targetObject->isNew() ? \_AM_QUOTES_QUOTE_ADD : \_AM_QUOTES_QUOTE_EDIT;
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new \XoopsFormHidden('id', $this->targetObject->getVar('id'));
        $this->addElement($hidden);
        unset($hidden);

        // Id
        $this->addElement(new \XoopsFormLabel(\_AM_QUOTES_QUOTE_ID, $this->targetObject->getVar('id'), 'id'));
        // Cid
        //$categoryHandler = $this->helper->getHandler('Category');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $categoryHandler */
        $categoryHandler = $this->helper->getHandler('Category');

        $allCategories = $categoryHandler->getList();
        if ($this->helper->isUserAdmin() || !\function_exists('quotes_user_can_submit_to_category')) {
            $categoryOptions = $allCategories;
        } else {
            $categoryOptions = [];
            foreach ($allCategories as $catId => $catTitle) {
                if (quotes_user_can_submit_to_category((int)$catId)) {
                    $categoryOptions[$catId] = $catTitle;
                }
            }
        }
        $category_id_select = new \XoopsFormSelect(\_AM_QUOTES_QUOTE_CID, 'cid', $this->targetObject->getVar('cid'));
        $category_id_select->addOptionArray($categoryOptions);
        $this->addElement($category_id_select, false);
        // Author_id
        //$authorHandler = $this->helper->getHandler('Authors');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $authorHandler */
        $authorHandler = $this->helper->getHandler('Author');

        $authors_id_select = new \XoopsFormSelect(\_AM_QUOTES_QUOTE_AUTHOR_ID, 'author_id', $this->targetObject->getVar('author_id'));
        $authors_id_select->addOption(0, '-------------');
        $authors_id_select->addOptionArray($authorHandler->getList());
        $this->addElement($authors_id_select, false);

        // Inline "add a new author" (full fields) — only when adding a quote. The field names match
        // AuthorForm so AuthorHandler::saveFromRequest() can hydrate the new author from the same POST.
        if ($this->targetObject->isNew()) {
            $newAuthorTray = new \XoopsFormElementTray(\_AM_QUOTES_NEWAUTHOR, '<br>');
            $newAuthorTray->addElement(new \XoopsFormText(\_AM_QUOTES_AUTHOR_NAME, 'name', 50, 255, ''));
            $newAuthorTray->addElement(new \XoopsFormSelectCountry(\_AM_QUOTES_AUTHOR_COUNTRY, 'country', ''));
            $newAuthorTray->addElement(new \XoopsFormTextArea(\_AM_QUOTES_AUTHOR_BIO, 'bio', '', 4, 50));
            $newAuthorTray->addElement(new \XoopsFormFile(\_AM_QUOTES_AUTHOR_PHOTO, 'photo', $this->helper->getConfig('maxsize')));
            $this->addElement($newAuthorTray);
            $this->addElement(new \XoopsFormLabel('', \_AM_QUOTES_NEWAUTHOR_HELP));
        }
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
            //$this->addElement( new \XoopsFormEditor(_AM_QUOTES_QUOTE_QUOTE, 'quote', $editorOptions), false  );
            if ($this->helper->isUserAdmin()) {
                $descEditor = new \XoopsFormEditor(\_AM_QUOTES_QUOTE_QUOTE, $this->helper->getConfig('quotesEditorAdmin'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            } else {
                $descEditor = new \XoopsFormEditor(\_AM_QUOTES_QUOTE_QUOTE, $this->helper->getConfig('quotesEditorUser'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea(\_AM_QUOTES_QUOTE_QUOTE, 'description', $this->targetObject->getVar('description', 'e'), 5, 50);
        }
        $this->addElement($descEditor);
        // Admin-only: publish state + dates. Non-admin writes are forced to pending and created=now
        // server-side (see QuoteHandler::saveFromRequest), so these are hidden from non-admins.
        if ($this->helper->isUserAdmin()) {
            // Online
            $online       = $this->targetObject->isNew() ? 0 : $this->targetObject->getVar('online');
            $check_online = new \XoopsFormCheckBox(\_AM_QUOTES_QUOTE_ONLINE, 'online', $online);
            $check_online->addOption(1, ' ');
            $this->addElement($check_online);
            // Created
            $this->addElement(new \XoopsFormTextDateSelect(\_AM_QUOTES_QUOTE_CREATED, 'created', 0, \formatTimestamp($this->targetObject->getVar('created'), 's')));
            // Updated
            $this->addElement(new \XoopsFormTextDateSelect(\_AM_QUOTES_QUOTE_UPDATED, 'updated', 0, \formatTimestamp($this->targetObject->getVar('updated'), 's')));
        }

        $this->addElement(new \XoopsFormHidden('op', 'save'));
        $this->addElement(new \XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
