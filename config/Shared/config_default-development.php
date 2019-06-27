<?php

/**
 * This is the global runtime configuration for Yves and Generated_Yves_Zed in a development environment.
 */

use Monolog\Logger;
use Pyz\Shared\Console\ConsoleConstants;
use Pyz\Shared\Scheduler\SchedulerConfig;
use Spryker\Shared\Acl\AclConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Config\ConfigConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebExceptionErrorRenderer;
use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Oauth\OauthConstants;
use Spryker\Shared\OauthCustomerConnector\OauthCustomerConnectorConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\PropelOrm\PropelOrmConstants;
use Spryker\Shared\PropelQueryBuilder\PropelQueryBuilderConstants;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\Scheduler\SchedulerConstants;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConfig;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConstants;
use Spryker\Shared\Session\SessionConfig;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\SessionFile\SessionFileConstants;
use Spryker\Shared\SessionRedis\SessionRedisConstants;
use Spryker\Shared\WebProfiler\WebProfilerConstants;
use Spryker\Shared\ZedNavigation\ZedNavigationConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;

$CURRENT_STORE = Store::getInstance()->getStoreName();

// ---------- General environment
$config[KernelConstants::SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker';
$config[KernelConstants::STORE_PREFIX] = 'DEV';
$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG] = true;
$config[WebProfilerConstants::ENABLE_WEB_PROFILER]
    = $config[ConfigConstants::ENABLE_WEB_PROFILER]
    = true;

$config[ApplicationConstants::ZED_SSL_ENABLED] = false;
$config[ApplicationConstants::YVES_SSL_ENABLED] = false;

// ---------- Propel
$config[PropelConstants::PROPEL_DEBUG] = false;
$config[PropelOrmConstants::PROPEL_SHOW_EXTENDED_EXCEPTION] = true;
$config[PropelConstants::ZED_DB_USERNAME] = 'development';
$config[PropelConstants::ZED_DB_PASSWORD] = 'mate20mg';
$config[PropelConstants::ZED_DB_HOST] = '127.0.0.1';
$config[PropelConstants::ZED_DB_PORT] = 5432;
$config[PropelConstants::ZED_DB_ENGINE] = $config[PropelConstants::ZED_DB_ENGINE_PGSQL];
$config[PropelQueryBuilderConstants::ZED_DB_ENGINE] = $config[PropelConstants::ZED_DB_ENGINE_PGSQL];

// ---------- RabbitMQ
$config[RabbitMqEnv::RABBITMQ_API_HOST] = 'localhost';
$config[RabbitMqEnv::RABBITMQ_API_PORT] = '15672';
$config[RabbitMqEnv::RABBITMQ_API_USERNAME] = 'admin';
$config[RabbitMqEnv::RABBITMQ_API_PASSWORD] = 'mate20mg';

// ---------- Session
$config[SessionConstants::YVES_SESSION_COOKIE_SECURE] = false;
$config[SessionConstants::ZED_SESSION_COOKIE_SECURE] = false;
$config[SessionConstants::ZED_SESSION_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_1_YEAR;
$config[SessionRedisConstants::ZED_SESSION_TIME_TO_LIVE] = $config[SessionConstants::ZED_SESSION_TIME_TO_LIVE];
$config[SessionFileConstants::ZED_SESSION_TIME_TO_LIVE] = $config[SessionConstants::ZED_SESSION_TIME_TO_LIVE];

// ---------- Scheduler
$config[SchedulerConstants::ENABLED_SCHEDULERS] = [
    SchedulerConfig::SCHEDULER_JENKINS,
];
$config[SchedulerJenkinsConstants::JENKINS_CONFIGURATION] = [
    SchedulerConfig::SCHEDULER_JENKINS => [
        SchedulerJenkinsConfig::SCHEDULER_JENKINS_BASE_URL => 'http://localhost:10007/',
    ],
];

// ---------- Zed request
$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = true;
$config[ZedRequestConstants::SET_REPEAT_DATA] = true;
$config[ZedRequestConstants::YVES_REQUEST_REPEAT_DATA_PATH] = APPLICATION_ROOT_DIR . '/data/' . Store::getInstance()->getStoreName() . '/' . APPLICATION_ENV . '/yves-requests';

// ---------- Navigation
$config[ZedNavigationConstants::ZED_NAVIGATION_CACHE_ENABLED] = true;

// ---------- Error handling
$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebExceptionErrorRenderer::class;

// ---------- ACL
$config[AclConstants::ACL_USER_RULE_WHITELIST][] = [
    'bundle' => 'wdt',
    'controller' => '*',
    'action' => '*',
    'type' => 'allow',
];

// ---------- Auto-loader
$config[KernelConstants::AUTO_LOADER_UNRESOLVABLE_CACHE_ENABLED] = false;

// ---------- Logging
$config[LogConstants::LOG_LEVEL] = Logger::INFO;

$baseLogFilePath = sprintf('%s/data/%s/logs', APPLICATION_ROOT_DIR, $CURRENT_STORE);

$config[LogConstants::EXCEPTION_LOG_FILE_PATH_YVES] = $baseLogFilePath . '/YVES/exception.log';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_ZED] = $baseLogFilePath . '/ZED/exception.log';

// ----------- Glue Application
$config[GlueApplicationConstants::GLUE_APPLICATION_REST_DEBUG] = true;

// ----------- OAUTH
$config[OauthConstants::PRIVATE_KEY_PATH] = 'file://' . APPLICATION_ROOT_DIR . '/config/Zed/dev_only_private.key';
$config[OauthConstants::PUBLIC_KEY_PATH] = 'file://' . APPLICATION_ROOT_DIR . '/config/Zed/dev_only_public.key';
$config[OauthConstants::ENCRYPTION_KEY] = 'lxZFUEsBCJ2Yb14IF2ygAHI5N4+ZAUXXaSeeJm6+twsUmIen';

// ----------- AuthRestApi
$config[OauthCustomerConnectorConstants::OAUTH_CLIENT_IDENTIFIER] = 'frontend';
$config[OauthCustomerConnectorConstants::OAUTH_CLIENT_SECRET] = 'abc123';

// ---------- Api
$config[ApiConstants::ENABLE_API_DEBUG] = true;

// ---------- Calculation page
$config[CalculationPageConstants::ENABLE_CART_DEBUG] = true;

// ---------- Error page
$config[ErrorPageConstants::ENABLE_ERROR_404_STACK_TRACE] = true;

// ----------- Application
$config[ApplicationConstants::ENABLE_PRETTY_ERROR_HANDLER] = true;

// ---------- Console
$config[ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS] = true;
