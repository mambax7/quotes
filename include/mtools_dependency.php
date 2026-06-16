<?php declare(strict_types=1);

use XoopsModules\Mtools;

if (!function_exists('quotes_mtools_dependency_error')) {
    function quotes_mtools_dependency_error(): string
    {
        if (!class_exists(Mtools\Bootstrap::class)) {
            return 'The mtools module files are missing. Install mtools before installing or running Quotes.';
        }

        $status = Mtools\Bootstrap::checkRuntime('1.0.0', '1.1.0');

        return $status['ok'] ? '' : Mtools\Bootstrap::statusMessage($status);
    }
}

