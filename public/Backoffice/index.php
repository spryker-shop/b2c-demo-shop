<?php

use Spryker\Shared\Config\Application\Environment;
use Spryker\Shared\ErrorHandler\ErrorHandlerEnvironment;
use Spryker\Zed\Application\Communication\Bootstrap\BackofficeBootstrap;

require __DIR__ . '/maintenance/maintenance.php';

define('APPLICATION', 'ZED');
defined('APPLICATION_ROOT_DIR') || define('APPLICATION_ROOT_DIR', dirname(__DIR__, 2));

require_once APPLICATION_ROOT_DIR . '/vendor/autoload.php';

Environment::initialize();

$errorHandlerEnvironment = new ErrorHandlerEnvironment();
$errorHandlerEnvironment->initialize();

$bootstrap = new BackofficeBootstrap();
$bootstrap
    ->boot()
    ->run();
