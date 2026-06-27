<?php declare(strict_types=1);

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

use Xmf\Module\Admin;
use Xmf\Request;

/** @var Admin $adminObject */
require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
require XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
if ('' !== Request::getString('submit', '', 'POST')) {
    redirect_header(\Xoops\Helpers\Service\Url::module((string)$GLOBALS['xoopsModule']->dirname(), 'admin/permissions.php'), 1, _AM_QUOTES_PERMISSIONS_GPERMUPDATED);
}
// Check admin have access to this page
/*$group = $GLOBALS['xoopsUser']->getGroups ();
$groups = xoops_getModuleOption ( 'admin_groups', $thisDirname );
if (count ( array_intersect ( $group, $groups ) ) <= 0) {
    redirect_header ( 'index.php', 3, _NOPERM );
}*/
$adminObject->displayNavigation(basename(__FILE__));

$permission                = Request::getInt('permission', 1, 'POST');
$permission                = \max(1, \min(4, $permission));
$selected                  = ['', '', '', ''];
$selected[$permission - 1] = ' selected';

echo "
<form method='post' name='fselperm' action='permissions.php'>
    <table border=0>
        <tr>
            <td>
                <select name='permission' onChange='document.fselperm.submit()'>
                    <option value='1'" . $selected[0] . '>' . _AM_QUOTES_PERMISSIONS_GLOBAL . "</option>
                    <option value='2'" . $selected[1] . '>' . _AM_QUOTES_PERMISSIONS_APPROVE . "</option>
                    <option value='3'" . $selected[2] . '>' . _AM_QUOTES_PERMISSIONS_SUBMIT . "</option>
                    <option value='4'" . $selected[3] . '>' . _AM_QUOTES_PERMISSIONS_VIEW . '</option>
                </select>
            </td>
        </tr>
    </table>
</form>';

$module_id = $GLOBALS['xoopsModule']->getVar('mid');
switch ($permission) {
    case 1:
        $formTitle   = _AM_QUOTES_PERMISSIONS_GLOBAL;
        $permName    = 'quotes_ac';
        $permDesc    = _AM_QUOTES_PERMISSIONS_GLOBAL_DESC;
        $globalPerms = [
            '4'  => _AM_QUOTES_PERMISSIONS_GLOBAL_4,
            '8'  => _AM_QUOTES_PERMISSIONS_GLOBAL_8,
            '16' => _AM_QUOTES_PERMISSIONS_GLOBAL_16,
            '32' => _AM_QUOTES_PERMISSIONS_GLOBAL_32,
        ];
        break;
    case 2:
        $formTitle = _AM_QUOTES_PERMISSIONS_APPROVE;
        $permName  = 'quotes_approve';
        $permDesc  = _AM_QUOTES_PERMISSIONS_APPROVE_DESC;
        break;
    case 3:
        $formTitle = _AM_QUOTES_PERMISSIONS_SUBMIT;
        $permName  = 'quotes_submit';
        $permDesc  = _AM_QUOTES_PERMISSIONS_SUBMIT_DESC;
        break;
    case 4:
        $formTitle = _AM_QUOTES_PERMISSIONS_VIEW;
        $permName  = 'quotes_view';
        $permDesc  = _AM_QUOTES_PERMISSIONS_VIEW_DESC;
        break;
}

$permform = new \XoopsGroupPermForm($formTitle, $module_id, $permName, $permDesc, 'admin/permissions.php');
if (1 == $permission) {
    foreach ($globalPerms as $perm_id => $perm_name) {
        $permform->addItem($perm_id, $perm_name);
    }
    echo $permform->render();
    echo '<br><br>';
} else {
    $criteria = new \CriteriaCompo();
    $criteria->setSort('title');
    $criteria->setOrder('ASC');
    $category_count = $categoryHandler->getCount($criteria);
    $categoryArray  = $categoryHandler->getObjects($criteria);
    unset($criteria);
    foreach (array_keys($categoryArray) as $i) {
        $permform->addItem($categoryArray[$i]->getVar('id'), $categoryArray[$i]->getVar('title'));
    }
    // Check if category exist before rendering the form and redirect, if there aren't category
    if ($category_count > 0) {
        echo $permform->render();
        echo '<br><br>';
    } else {
        redirect_header('category.php?op=new', 3, _AM_QUOTES_PERMISSIONS_NOPERMSSET);
        //exit ();
    }
}
unset($permform);
require_once __DIR__ . '/admin_footer.php';
