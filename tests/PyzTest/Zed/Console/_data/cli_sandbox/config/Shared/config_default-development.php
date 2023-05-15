<?php

use Monolog\Logger;
use Pyz\Shared\Console\ConsoleConstants;
use Spryker\Shared\Acl\AclConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebExceptionErrorRenderer;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\PropelOrm\PropelOrmConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\Twig\TwigConstants;
use Spryker\Shared\ZedNavigation\ZedNavigationConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use Twig\Cache\FilesystemCache;

$config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN] = $config[ApplicationConstants::HOST_YVES];
$config[SessionConstants::YVES_SESSION_COOKIE_SECURE] = false;

$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = true;

$config[TwigConstants::ZED_TWIG_OPTIONS] = [
    'cache' => new FilesystemCache(
        sprintf(
            '%s/data/%s/cache/%s/twig',
            APPLICATION_ROOT_DIR,
            APPLICATION_CODE_BUCKET,
            APPLICATION,
        ),
        FilesystemCache::FORCE_BYTECODE_INVALIDATION,
    ),
];

$config[TwigConstants::YVES_TWIG_OPTIONS] = [
    'cache' => new FilesystemCache(
        sprintf(
            '%s/data/%s/cache/%s/twig',
            APPLICATION_ROOT_DIR,
            APPLICATION_CODE_BUCKET,
            APPLICATION,
        ),
        FilesystemCache::FORCE_BYTECODE_INVALIDATION,
    ),
];

$config[ZedNavigationConstants::ZED_NAVIGATION_CACHE_ENABLED] = true;

$config[AclConstants::ACL_USER_RULE_WHITELIST][] = [
    'bundle' => 'wdt',
    'controller' => '*',
    'action' => '*',
    'type' => 'allow',
];

$config[PropelConstants::PROPEL_DEBUG] = true;
$config[PropelOrmConstants::PROPEL_SHOW_EXTENDED_EXCEPTION] = true;

$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebExceptionErrorRenderer::class;

$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG] = true;
$config[ZedRequestConstants::SET_REPEAT_DATA] = true;
$config[KernelConstants::STORE_PREFIX] = 'DEV';

$config[LogConstants::LOG_LEVEL] = Logger::INFO;

$config[ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS] = true;
