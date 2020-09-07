<?php

declare(strict_types=1);

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

use Xmf\Request;
use Xmf\Module\Admin;
use XoopsModules\Quotes;
use XoopsModules\Mtools;
/** @var Admin $adminObject */
/** @var Helper $helper */

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();

$adminObject->displayNavigation(basename(__FILE__));

echo <<<EOF
<form method="post" class="form-inline">
<div class="form-group">
<input name="show" class="btn btn-default" type="submit" value="Show SQL">
</div>
<div class="form-group">
<input name="migrate" class="btn btn-default" type="submit" value="Do Migration">
</div>
<div class="form-group">
<input name="schema" class="btn btn-default" type="submit" value="Write Schema">
</div>
</form>
EOF;

/** @var Mtools\Common\Configurator $configurator */
$configurator = new Mtools\Common\Configurator($helper->path());

/** @var \XoopsModules\Mtools\Common\Migrate $migrator */
$migrator = new \XoopsModules\Mtools\Common\Migrate($configurator);

$op        = \Xmf\Request::getCmd('op', 'show');
$opShow    = \Xmf\Request::getCmd('show', null, 'POST');
$opMigrate = \Xmf\Request::getCmd('migrate', null, 'POST');
$opSchema  = \Xmf\Request::getCmd('schema', null, 'POST');
$op        = !empty($opShow) ? 'show' : $op;
$op        = !empty($opMigrate) ? 'migrate' : $op;
$op        = !empty($opSchema) ? 'schema' : $op;

$message = '';

switch ($op) {
    case 'show':
    default:
        $queue = $migrator->getSynchronizeDDL();
        if (!empty($queue)) {
            echo "<pre>\n";
            foreach ($queue as $line) {
                echo $line . ";\n";
            }
            echo "</pre>\n";
        }
        break;
    case 'migrate':
        $migrator->synchronizeSchema();
        $message = constant('CO_' . $moduleDirNameUpper . '_' . 'MIGRATE_OK');
        break;
    case 'schema':
        xoops_confirm(['op' => 'confirmwrite'], 'migrate.php', constant('CO_' . $moduleDirNameUpper . '_' . 'MIGRATE_WARNING'), constant('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM'));
        break;
    case 'confirmwrite':
        if ($GLOBALS['xoopsSecurity']->check()) {
            $migrator->saveCurrentSchema();

            $message = constant('CO_' . $moduleDirNameUpper . '_' . 'MIGRATE_SCHEMA_OK');
        }
        break;
}

echo "<div>$message</div>";

require_once __DIR__ . '/admin_footer.php';
