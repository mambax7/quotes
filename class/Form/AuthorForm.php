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
 * Class AuthorForm
 */
class AuthorForm extends \XoopsThemeForm
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

        $title = $this->targetObject->isNew() ? \_AM_QUOTES_AUTHOR_ADD : \_AM_QUOTES_AUTHOR_EDIT;
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new \XoopsFormHidden('id', $this->targetObject->getVar('id'));
        $this->addElement($hidden);
        unset($hidden);

        // Id
        $this->addElement(new \XoopsFormLabel(\_AM_QUOTES_AUTHOR_ID, $this->targetObject->getVar('id'), 'id'));
        // Name
        $this->addElement(new \XoopsFormText(\_AM_QUOTES_AUTHOR_NAME, 'name', 50, 255, $this->targetObject->getVar('name')), false);
        // Country
        $this->addElement(new \XoopsFormSelectCountry(\_AM_QUOTES_AUTHOR_COUNTRY, 'country', $this->targetObject->getVar('country')), false);
        // Bio
        if (\class_exists('XoopsFormEditor')) {
            $editorOptions           = [];
            $editorOptions['name']   = 'bio';
            $editorOptions['value']  = $this->targetObject->getVar('bio', 'e');
            $editorOptions['rows']   = 5;
            $editorOptions['cols']   = 40;
            $editorOptions['width']  = '100%';
            $editorOptions['height'] = '400px';
            //$editorOptions['editor'] = xoops_getModuleOption('quotes_editor', 'quotes');
            //$this->addElement( new \XoopsFormEditor(_AM_QUOTES_AUTHOR_BIO, 'bio', $editorOptions), false  );
            if ($this->helper->isUserAdmin()) {
                $descEditor = new \XoopsFormEditor(\_AM_QUOTES_AUTHOR_BIO, $this->helper->getConfig('quotesEditorAdmin'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            } else {
                $descEditor = new \XoopsFormEditor(\_AM_QUOTES_AUTHOR_BIO, $this->helper->getConfig('quotesEditorUser'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea(\_AM_QUOTES_AUTHOR_BIO, 'description', $this->targetObject->getVar('description', 'e'), 5, 50);
        }
        $this->addElement($descEditor);
        // Photo
        $photo = $this->targetObject->getVar('photo') ?: 'blank.png';

        $uploadDir   = '/uploads/quotes/author/';
        $imgtray     = new \XoopsFormElementTray(\_AM_QUOTES_AUTHOR_PHOTO, '<br>');
        $imgpath     = \sprintf(\_AM_QUOTES_FORMIMAGE_PATH, $uploadDir);
        $imageselect = new \XoopsFormSelect($imgpath, 'photo', $photo);
        $imageArray  = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $uploadDir);
        foreach ($imageArray as $image) {
            $imageselect->addOption($image, $image);
        }
        $imageselect->setExtra("onchange='showImgSelected(\"image_photo\", \"photo\", \"" . $uploadDir . '", "", "' . XOOPS_URL . "\")'");
        $imgtray->addElement($imageselect);
        $imgtray->addElement(new \XoopsFormLabel('', "<br><img src='" . XOOPS_URL . '/' . $uploadDir . '/' . $photo . "' name='image_photo' id='image_photo' alt='' style='max-width:300px' >"));
        $fileseltray = new \XoopsFormElementTray('', '<br>');
        $fileseltray->addElement(new \XoopsFormFile(\_AM_QUOTES_FORMUPLOAD, 'photo', $this->helper->getConfig('maxsize')));
        $fileseltray->addElement(new \XoopsFormLabel(''));
        $imgtray->addElement($fileseltray);
        $this->addElement($imgtray);
        if ($this->helper->isUserAdmin()) {
            // Created
            $this->addElement(new \XoopsFormTextDateSelect(\_AM_QUOTES_AUTHOR_CREATED, 'created', 0, \formatTimestamp($this->targetObject->getVar('created'), 's')));
            // Updated
            $this->addElement(new \XoopsFormTextDateSelect(\_AM_QUOTES_AUTHOR_UPDATED, 'updated', 0, \formatTimestamp($this->targetObject->getVar('updated'), 's')));
        }

        $this->addElement(new \XoopsFormHidden('op', 'save'));
        $this->addElement(new \XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
