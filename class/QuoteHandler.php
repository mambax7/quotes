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
 * Class QuoteHandler
 */
class QuoteHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     * @param null|Helper $helper
     */
    public function __construct(?\XoopsDatabase $db = null, public $helper = null)
    {
        parent::__construct($db, 'quotes_quote', Quote::class, 'id', 'quote');
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
     * Hydrate a Quote from the POSTed form fields and persist it.
     *
     * Shared by the admin and frontend save handlers so the field/date logic lives in
     * ONE place. Callers MUST perform authorisation and CSRF validation BEFORE calling this,
     * and are responsible for the post-save redirect.
     *
     * @param Helper $helper module helper (kept for signature parity with the other handlers)
     *
     * @return array{ok: bool, object: \XoopsObject, errors: string}
     */
    public function saveFromRequest(Helper $helper, bool $isAdmin = true, ?int $authorIdOverride = null): array
    {
        $id     = \Xmf\Request::getInt('id', 0, 'POST');
        $object = $id > 0 ? $this->get($id) : $this->create();
        if (!\is_object($object)) {
            $object = $this->create();
        }
        $isNew = $object->isNew();

        // Content fields any permitted editor may change.
        $object->setVar('quote', \Xmf\Request::getText('quote', '', 'POST'));
        $object->setVar('author_id', $authorIdOverride ?? \Xmf\Request::getInt('author_id', 0, 'POST'));

        // Owner stamp — set once on create, NEVER taken from POST, never changed on edit.
        if ($isNew) {
            $object->setVar('uid', $this->currentUid());
        }

        // Create-only / admin-only fields. A non-admin editing an existing quote may not
        // recategorise or backdate it — these are preserved from the stored row.
        if ($isNew || $isAdmin) {
            $object->setVar('cid', \Xmf\Request::getInt('cid', 0, 'POST'));
            $dateTimeObj = \DateTime::createFromFormat(\_SHORTDATESTRING, \Xmf\Request::getString('created', '', 'POST'));
            $object->setVar('created', $dateTimeObj instanceof \DateTimeInterface ? $dateTimeObj->getTimestamp() : \time());
        }

        // Approval has priority over the edit/submit permission: any non-admin write (create OR
        // edit) goes to pending (online = 0) UNLESS the user holds the "Auto approve" right
        // (quotes_ac item 16). Admins keep full control of the published state. So a registered
        // user editing their own published quote sends it back for re-approval.
        $canPublish = $isAdmin || (new \Xmf\Module\Helper\Permission())->checkPermission('quotes_ac', 16);
        $object->setVar('online', $canPublish ? ((1 === \Xmf\Request::getInt('online', 0, 'POST')) ? '1' : '0') : '0');

        $object->setVar('updated', \time());

        $ok = (bool)$this->insert($object);

        return ['ok' => $ok, 'object' => $object, 'errors' => $ok ? '' : $object->getHtmlErrors()];
    }

    /**
     * Current front-end user id, or 0 for anonymous.
     */
    private function currentUid(): int
    {
        return ($GLOBALS['xoopsUser'] instanceof \XoopsUser) ? (int)$GLOBALS['xoopsUser']->getVar('uid') : 0;
    }
}
