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
use XoopsModules\Quotes;

//$permHelper = new \Xmf\Module\Helper\Permission();

/**
 * Class Author
 */
class Author extends \XoopsObject
{
    private $id;
    private $name;
    private $country;
    private $bio;
    private $photo;
    private $created;
    private $updated;

    public $helper;
    public $permHelper;

    /**
     * Constructor
     */
    public function __construct()
    {
        // /** @var Quotes\Helper $helper */
        //        $this->helper = Quotes\Helper::getInstance();
        $this->permHelper = new Permission();

        $this->initVar('id', \XOBJ_DTYPE_INT);
        $this->initVar('name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('country', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('bio', \XOBJ_DTYPE_OTHER);
        $this->initVar('photo', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('uid', \XOBJ_DTYPE_INT);
        $this->initVar('created', \XOBJ_DTYPE_INT);
        $this->initVar('updated', \XOBJ_DTYPE_INT);
    }

    /**
     * Get form
     *
     * @return Quotes\Form\AuthorForm
     */
    public function getForm(): Form\AuthorForm
    {
        $form = new Form\AuthorForm($this);

        return $form;
    }

    public function getGroupsRead(): ?array
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_read', $this->getVar('id'));
    }

    public function getGroupsSubmit(): ?array
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_submit', $this->getVar('id'));
    }

    public function getGroupsModeration(): ?array
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_moderation', $this->getVar('id'));
    }
}
