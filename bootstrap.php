<?php declare(strict_types=1);

/**
 * Quotes module bootstrap.
 *
 * Consumer modules should register their own namespace here, then load the
 * public mtools bootstrap instead of reaching into mtools/preloads internals.
 */

require_once __DIR__ . '/preloads/autoloader.php';

if (defined('XOOPS_ROOT_PATH')) {
    $mtoolsBootstrap = XOOPS_ROOT_PATH . '/modules/mtools/bootstrap.php';
    if (is_file($mtoolsBootstrap)) {
        require_once $mtoolsBootstrap;
    }
}

require_once __DIR__ . '/include/mtools_dependency.php';

