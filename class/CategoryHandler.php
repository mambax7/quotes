<?php declare(strict_types=1);

namespace XoopsModules\Quotes;

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

/** @var Helper $helper */
$moduleDirName = \basename(\dirname(__DIR__));

$permHelper = new Permission();

/**
 * Class CategoryHandler
 */
class CategoryHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     * @param null|Helper $helper
     */
    public function __construct(?\XoopsDatabase $db = null, public $helper = null)
    {
        parent::__construct($db, 'quotes_category', Category::class, 'id', 'title');
    }

    /**
     * @param bool $isNew
     *
     * @return \XoopsObject
     */
    #[\Override]
    public function create($isNew = true)
    {
        $obj         = parent::create($isNew);
        $obj->helper = $this->helper;

        return $obj;
    }

    /**
     * Hydrate a Category from the POSTed form fields, handle the image upload, and persist it.
     *
     * Shared by the admin and frontend save handlers so the field/upload logic lives in
     * ONE place. Callers MUST perform authorisation and CSRF validation BEFORE calling this,
     * and are responsible for the post-save redirect and any permission persistence.
     *
     * @param Helper $helper module helper (provides upload mimetypes/maxsize config)
     *
     * @return array{ok: bool, object: \XoopsObject, errors: string}
     */
    public function saveFromRequest(Helper $helper): array
    {
        $id     = \Xmf\Request::getInt('id', 0, 'POST');
        $object = $id > 0 ? $this->get($id) : $this->create();
        if (!\is_object($object)) {
            $object = $this->create();
        }

        $object->setVar('pid', \Xmf\Request::getInt('pid', 0, 'POST'));
        $object->setVar('title', \Xmf\Request::getString('title', '', 'POST'));
        $object->setVar('description', \Xmf\Request::getText('description', '', 'POST'));

        require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadDir = \Xoops\Helpers\Service\Path::moduleUpload('quotes', 'category') . '/';
        $uploader  = new \XoopsMediaUploader(
            $uploadDir,
            $helper->getConfig('mimetypes'),
            $helper->getConfig('maxsize'),
            null,
            null
        );
        $uploadFields = \Xmf\Request::getArray('xoops_upload_file', [], 'POST');
        $uploadField  = (string)($uploadFields[0] ?? '');
        if ('' !== $uploadField && $uploader->fetchMedia($uploadField)) {
            $uploader->setPrefix('image_');
            $uploader->fetchMedia($uploadField);
            if (!$uploader->upload()) {
                return ['ok' => false, 'object' => $object, 'errors' => \implode(' ', (array)$uploader->getErrors(false))];
            }
            $object->setVar('image', $uploader->getSavedFileName());
        } else {
            $object->setVar('image', \Xmf\Request::getString('image', '', 'POST'));
        }

        $object->setVar('weight', \Xmf\Request::getInt('weight', 0, 'POST'));
        $object->setVar('color', \Xmf\Request::getString('color', '', 'POST'));
        $object->setVar('online', ((1 === \Xmf\Request::getInt('online', 0, 'POST')) ? '1' : '0'));

        $ok = (bool)$this->insert($object);

        return ['ok' => $ok, 'object' => $object, 'errors' => $ok ? '' : $object->getHtmlErrors()];
    }
}
