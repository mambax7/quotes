<?php
/**
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * PHP version 5
 *
 * @category        Module
 * @author          XOOPS Development Team
 * @copyright       XOOPS Project
 * @link            https://xoops.org
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Mtools\{Common\Blocksadmin,
    Helper
};

/** @var Admin $adminObject */
/** @var Helper $helper */

require_once __DIR__ . '/admin_header.php';
//xoops_cp_header();

$moduleDirName      = $helper->getDirname();
$moduleDirNameUpper = mb_strtoupper($moduleDirName); //$capsDirName

/** @var \XoopsMySQLDatabase $xoopsDB */
$xoopsDB = \XoopsDatabaseFactory::getDatabaseConnection();
$blocksadmin = new Blocksadmin($xoopsDB, $helper);

if (!is_object($GLOBALS['xoopsUser']) || !is_object($xoopsModule)
    || !$GLOBALS['xoopsUser']->isAdmin($xoopsModule->mid())) {
    exit(constant('CO_' . $moduleDirNameUpper . '_' . 'ERROR403'));
}
if ($GLOBALS['xoopsUser']->isAdmin($xoopsModule->mid())) {
    require_once XOOPS_ROOT_PATH . '/class/xoopsblock.php';
    $op = 'list';
    if (isset($_POST)) {
        foreach ($_POST as $k => $v) {
            ${$k} = $v;
        }
    }
    /*
    if (Request::hasVar('op', 'GET')) {
        if ('edit' === $_GET['op'] || 'delete' === $_GET['op'] || 'delete_ok' === $_GET['op'] || 'clone' === $_GET['op']
            || 'edit' === $_GET['op']) {
            $op  = $_GET['op'];
            $bid = \Xmf\Request::getInt('bid', 0, 'GET');
        }
    */

    $op = Request::getString('op', $op);
    if (in_array($op, ['edit', 'delete', 'delete_ok', 'clone'])) {
        $bid = Request::getInt('bid', 0 );
    }

    //==================================================

    if ('list' === $op) {
        xoops_cp_header();
        //        mpu_adm_menu();
        $blocksadmin->listBlocks();
        require_once __DIR__ . '/admin_footer.php';
        exit();
    }

//    if ('order' === $op) {
//        if (!$GLOBALS['xoopsSecurity']->check()) {
//            redirect_header($_SERVER['SCRIPT_NAME'], 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
//        }
//        foreach (array_keys($bid) as $i) {
//            if ($oldtitle[$i] != $title[$i] || $oldweight[$i] != $weight[$i] || $oldvisible[$i] != $visible[$i]
//                || $oldside[$i] != $side[$i]
//                || $oldbcachetime[$i] != $bcachetime[$i]) {
//                setOrder($bid[$i], $title[$i], $weight[$i], $visible[$i], $side[$i], $bcachetime[$i], $bmodule[$i]);
//            }
//            if (!empty($bmodule[$i]) && count($bmodule[$i]) > 0) {
//                $sql = sprintf('DELETE FROM `%s` WHERE block_id = %u', $xoopsDB->prefix('block_module_link'), $bid[$i]);
//                $xoopsDB->query($sql);
//                if (in_array(0, $bmodule[$i])) {
//                    $sql = sprintf('INSERT INTO `%s` (block_id, module_id) VALUES (%u, %d)', $xoopsDB->prefix('block_module_link'), $bid[$i], 0);
//                    $xoopsDB->query($sql);
//                } else {
//                    foreach ($bmodule[$i] as $bmid) {
//                        $sql = sprintf('INSERT INTO `%s` (block_id, module_id) VALUES (%u, %d)', $xoopsDB->prefix('block_module_link'), $bid[$i], (int)$bmid);
//                        $xoopsDB->query($sql);
//                    }
//                }
//            }
//            $sql = sprintf('DELETE FROM `%s` WHERE gperm_itemid = %u', $xoopsDB->prefix('group_permission'), $bid[$i]);
//            $xoopsDB->query($sql);
//            if (!empty($groups[$i])) {
//                foreach ($groups[$i] as $grp) {
//                    $sql = sprintf("INSERT INTO `%s` (gperm_groupid, gperm_itemid, gperm_modid, gperm_name) VALUES (%u, %u, 1, 'block_read')", $xoopsDB->prefix('group_permission'), $grp, $bid[$i]);
//                    $xoopsDB->query($sql);
//                }
//            }
//        }
//        redirect_header($_SERVER['SCRIPT_NAME'], 1, constant('CO_' . $moduleDirNameUpper . '_' . 'UPDATE_SUCCESS'));
//    }

    if ('clone' === $op) {
        $blocksadmin->cloneBlock($bid);
    }

    if ('delete' === $op) {

        if (Request::hasVar('ok', 'REQUEST') && 1 === Request::getInt('ok', 0)) {
//            if (!$GLOBALS['xoopsSecurity']->check()) {
//                redirect_header($helper->url('admin/blocksadmin.php'), 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
//            }
            $blocksadmin->deleteBlock($bid);
        } else {
            xoops_cp_header();
            xoops_confirm(['ok' => 1, 'op' => 'delete', 'bid' => $bid], 'blocksadmin.php', constant('CO_' . $moduleDirNameUpper . '_' . 'DELETE_BLOCK_CONFIRM'), constant('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM'), true);
            xoops_cp_footer();
        }
    }

    if ('edit' === $op) {
        $blocksadmin->editBlock($bid);
    }

    if ('edit_ok' === $op) {
        $blocksadmin->updateBlock($bid, $btitle, $bside, $bweight, $bvisible, $bcachetime, $bmodule, $options, $groups);
    }

    if ('clone_ok' === $op) {
        $blocksadmin->isBlockCloned($bid, $bside, $bweight, $bvisible, $bcachetime, $bmodule, $options);
    }
} else {
    echo constant('CO_' . $moduleDirNameUpper . '_' . 'ERROR403');
}

require_once __DIR__ . '/admin_footer.php';
