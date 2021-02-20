<?php

declare(strict_types=1);

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
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GPL 2.0 or later
 */

use Xmf\Module\Helper\Permission;
use XoopsModules\Quotes;
use XoopsModules\Quotes\Form;

//$permHelper = new \Xmf\Module\Helper\Permission();

/**
 * Class Quote
 */
class Quote extends \XoopsObject
{
    public $helper, $permHelper;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
        //        /** @var  Quotes\Helper $helper */
        //        $this->helper = Quotes\Helper::getInstance();
        $this->permHelper = new Permission();

        $this->initVar('id', XOBJ_DTYPE_INT);
        $this->initVar('cid', XOBJ_DTYPE_INT);
        $this->initVar('author_id', XOBJ_DTYPE_INT);
        $this->initVar('quote', XOBJ_DTYPE_OTHER);
        $this->initVar('online', XOBJ_DTYPE_INT);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
    }

    /**
     * Get form
     *
     * @param null
     * @return Quotes\Form\QuoteForm
     */
    public function getForm(): Form\QuoteForm
    {
        $form = new Form\QuoteForm($this);
        return $form;
    }

    /**
     * @return array|null
     */
    public function getGroupsRead(): ?array
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_read', $this->getVar('id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsSubmit(): ?array
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_submit', $this->getVar('id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsModeration(): ?array
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_moderation', $this->getVar('id'));
    }
}

