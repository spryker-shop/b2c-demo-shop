<?php

/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

define('APPLICATION_ROOT_DIR', __DIR__);
define('APPLICATION_VENDOR_DIR', APPLICATION_ROOT_DIR . '/vendor');
define('APPLICATION_SOURCE_DIR', APPLICATION_ROOT_DIR . '/src');
define('APPLICATION', '');
define('APPLICATION_ENV', '');
define('APPLICATION_STORE', '');
define('APPLICATION_CODE_BUCKET', '');

require_once(__DIR__ . '/src/Generated/Client/Ide/AutoCompletion.php');
require_once(__DIR__ . '/src/Generated/Service/Ide/AutoCompletion.php');
require_once(__DIR__ . '/src/Generated/Yves/Ide/AutoCompletion.php');
require_once(__DIR__ . '/src/Generated/Zed/Ide/AutoCompletion.php');

$codeceptionShimFilePath = __DIR__ . '/vendor/codeception/codeception/shim.php';
if (file_exists($codeceptionShimFilePath)) {
    require_once($codeceptionShimFilePath);
}

$manualAutoload = APPLICATION_VENDOR_DIR . '/squizlabs/php_codesniffer/autoload.php';
if (!class_exists(\PHP_CodeSniffer\Config::class) && file_exists($manualAutoload)) {
    require $manualAutoload;
}

// Shim to not throw "Function opcache_invalidate not found" error when opcache is not enabled
if (!function_exists('opcache_invalidate')) {
    /**
     * @param string $script
     * @param bool $force
     *
     * @return void
     */
    function opcache_invalidate($script, $force = false)
    {
    }
}
