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
use XoopsModules\Quotes\{
    Helper
};

/** @var Helper $helper */

$moduleDirName = \basename(\dirname(__DIR__));

$permHelper = new Permission();

/**
 * Class AuthorHandler
 */
class AuthorHandler extends \XoopsPersistableObjectHandler
{
    /**
     * @var Helper
     */
    public $helper;

    /**
     * Constructor
     * @param null|\XoopsDatabase $db
     * @param null|Helper         $helper
     */

    public function __construct(\XoopsDatabase $db = null, $helper = null)
    {
        $this->helper = $helper;
        parent::__construct($db, 'quotes_author', Author::class, 'id', 'name');
    }

    /**
     * @param bool $isNew
     *
     * @return \XoopsObject
     */
    public function create($isNew = true)
    {
        $obj         = parent::create($isNew);
        $obj->helper = $this->helper;

        return $obj;
    }
}
