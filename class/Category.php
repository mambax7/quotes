<?php declare(strict_types=1);

namespace XoopsModules\Quote;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Module: Quote
 *
 * @category        Module
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use XoopsModules\Quote;

//$permHelper = new \Xmf\Module\Helper\Permission();

/**
 * Class Category
 */
class Category extends \XoopsObject
{
    private $id;
    private $pid;
    private $title;
    private $description;
    private $image;
    private $weight;
    private $color;
    private $online;

    public $helper;
    public $permHelper;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        // /** @var Quote\Helper $helper */
        //        $this->helper = Quote\Helper::getInstance();
        $this->permHelper = new \Xmf\Module\Helper\Permission();

        $this->initVar('id', \XOBJ_DTYPE_INT);
        $this->initVar('pid', \XOBJ_DTYPE_INT);
        $this->initVar('title', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('description', \XOBJ_DTYPE_OTHER);
        $this->initVar('image', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('weight', \XOBJ_DTYPE_INT);
        $this->initVar('color', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('online', \XOBJ_DTYPE_INT);
    }

    /**
     * Get form
     *
     * @return Quote\Form\CategoryForm
     */
    public function getForm()
    {
        $form = new Form\CategoryForm($this);

        return $form;
    }

    /**
     * @return array|null
     */
    public function getGroupsRead()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_read', $this->getVar('id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsSubmit()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_submit', $this->getVar('id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsModeration()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_moderation', $this->getVar('id'));
    }
}
