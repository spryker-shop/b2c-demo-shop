<?php

use Monolog\Logger;
use Pyz\Shared\Console\ConsoleConstants;
use Spryker\Shared\AppCatalogGui\AppCatalogGuiConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Shared\DocumentationGeneratorRestApi\DocumentationGeneratorRestApiConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebExceptionErrorRenderer;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\EventBehavior\EventBehaviorConstants;
use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Shared\GlueBackendApiApplication\GlueBackendApiApplicationConstants;
use Spryker\Shared\GlueStorefrontApiApplication\GlueStorefrontApiApplicationConstants;
use Spryker\Shared\Http\HttpConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\MessageBroker\MessageBrokerConstants;
use Spryker\Shared\Newsletter\NewsletterConstants;
use Spryker\Shared\OauthClient\OauthClientConstants;
use Spryker\Shared\Product\ProductConstants;
use Spryker\Shared\ProductManagement\ProductManagementConstants;
use Spryker\Shared\Queue\QueueConfig;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\Router\RouterConstants;
use Spryker\Shared\Scheduler\SchedulerConstants;
use Spryker\Shared\SearchElasticsearch\SearchElasticsearchConstants;
use Spryker\Shared\SecurityBlocker\SecurityBlockerConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\SessionRedis\SessionRedisConstants;
use Spryker\Shared\StorageDatabase\StorageDatabaseConstants;
use Spryker\Shared\StorageRedis\StorageRedisConstants;
use Spryker\Shared\SymfonyMailer\SymfonyMailerConstants;
use Spryker\Shared\Testify\TestifyConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use Spryker\Zed\OauthDummy\OauthDummyConfig;
use SprykerShop\Shared\ErrorPage\ErrorPageConstants;

// ############################################################################
// ############################## TESTING IN CI ###############################
// ############################################################################

$dynamicStoreEnabled = (bool)getenv('SPRYKER_DYNAMIC_STORE_MODE');

$yvesHost = $dynamicStoreEnabled ? 'www.eu.spryker.test' : 'www.de.spryker.test';
$glueHost = $dynamicStoreEnabled ? 'glue.eu.spryker.test' : 'glue.de.spryker.test';
$glueBackendHost = $dynamicStoreEnabled ? 'gluebackend.eu.spryker.test' : 'gluebackend.de.spryker.test';
$glueStorefrontHost = $dynamicStoreEnabled ? 'gluestorefront.eu.spryker.test' : 'gluestorefront.de.spryker.test';
$backofficeHost = $dynamicStoreEnabled ? 'backoffice.eu.spryker.test' : 'backoffice.de.spryker.test';
$merchantPortalHost = $dynamicStoreEnabled ? 'mp.eu.spryker.test' : 'mp.de.spryker.test';
$backendGatewayHost = $dynamicStoreEnabled ? 'backend-gateway.eu.spryker.test' : 'backend-gateway.de.spryker.test';
$backendApiHost = $dynamicStoreEnabled ? 'backend-api.eu.spryker.test' : 'backend-api.de.spryker.test';

$isTestifyConstantsClassExists = class_exists(TestifyConstants::class);

// ----------------------------------------------------------------------------
// ------------------------------ CODEBASE ------------------------------------
// ----------------------------------------------------------------------------

// >>> Dev tools
$config[KernelConstants::ENABLE_CONTAINER_OVERRIDING] = true;
$config[ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS] = true;
$config[DocumentationGeneratorRestApiConstants::ENABLE_REST_API_DOCUMENTATION_GENERATION] = true;

// >>> ErrorHandler
$config[ErrorPageConstants::ENABLE_ERROR_404_STACK_TRACE] = true;
$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebExceptionErrorRenderer::class;
$config[ErrorHandlerConstants::IS_PRETTY_ERROR_HANDLER_ENABLED] = true;

// ----------------------------------------------------------------------------
// ------------------------------ SECURITY ------------------------------------
// ----------------------------------------------------------------------------

$config[SessionConstants::ZED_SSL_ENABLED]
    = $config[SessionConstants::YVES_SSL_ENABLED]
    = $config[RouterConstants::YVES_IS_SSL_ENABLED]
    = $config[RouterConstants::ZED_IS_SSL_ENABLED]
    = $config[HttpConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $config[HttpConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $config[ApplicationConstants::ZED_SSL_ENABLED]
    = $config[ApplicationConstants::YVES_SSL_ENABLED]
    = false;

$trustedHosts
    = $config[HttpConstants::ZED_TRUSTED_HOSTS]
    = $config[HttpConstants::YVES_TRUSTED_HOSTS]
    = [
    $yvesHost,
    $glueHost,
    $backofficeHost,
    $backendGatewayHost,
    $backendApiHost,
    'localhost',
];

$config[KernelConstants::DOMAIN_WHITELIST] = array_merge($trustedHosts, $config[KernelConstants::DOMAIN_WHITELIST]);

// ----------------------------------------------------------------------------
// ------------------------------ AUTHENTICATION ------------------------------
// ----------------------------------------------------------------------------

require 'common/config_oauth.php';

// ----------------------------------------------------------------------------
// ------------------------------ SERVICES ------------------------------------
// ----------------------------------------------------------------------------

require 'common/config_logs-files.php';

// >>> DATABASE
// Look at:
// config_default-ci.mysql.php
// config_default-ci.pgsql.php

// >>> SEARCH

$config[SearchElasticsearchConstants::HOST] = 'localhost';
$config[SearchElasticsearchConstants::TRANSPORT] = 'http';
$config[SearchElasticsearchConstants::PORT] = 9200;

// >>> STORAGE

$config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION] = true;
$config[StorageRedisConstants::STORAGE_REDIS_SCHEME] = 'tcp';
$config[StorageRedisConstants::STORAGE_REDIS_HOST] = '127.0.0.1';
$config[StorageRedisConstants::STORAGE_REDIS_PORT] = 6379;
$config[StorageRedisConstants::STORAGE_REDIS_PASSWORD] = false;
$config[StorageRedisConstants::STORAGE_REDIS_DATABASE] = 3;

$config[StorageDatabaseConstants::DB_DEBUG] = false;
$config[StorageDatabaseConstants::DB_DATABASE] = 'DE_test_zed';
$config[StorageDatabaseConstants::DB_HOST] = '127.0.0.1';
$config[StorageDatabaseConstants::DB_PASSWORD] = '';
// Look also at:
// config_default-ci.mysql.php
// config_default-ci.pgsql.php

// >>> SESSION

$config[SessionRedisConstants::YVES_SESSION_REDIS_SCHEME] = $config[StorageRedisConstants::STORAGE_REDIS_SCHEME];
$config[SessionRedisConstants::YVES_SESSION_REDIS_HOST] = $config[StorageRedisConstants::STORAGE_REDIS_HOST];
$config[SessionRedisConstants::YVES_SESSION_REDIS_PORT] = $config[StorageRedisConstants::STORAGE_REDIS_PORT];
$config[SessionRedisConstants::YVES_SESSION_REDIS_PASSWORD] = $config[StorageRedisConstants::STORAGE_REDIS_PASSWORD];
$config[SessionRedisConstants::YVES_SESSION_REDIS_DATABASE] = 1;

$config[SessionRedisConstants::ZED_SESSION_REDIS_SCHEME] = $config[StorageRedisConstants::STORAGE_REDIS_SCHEME];
$config[SessionRedisConstants::ZED_SESSION_REDIS_HOST] = $config[StorageRedisConstants::STORAGE_REDIS_HOST];
$config[SessionRedisConstants::ZED_SESSION_REDIS_PORT] = $config[StorageRedisConstants::STORAGE_REDIS_PORT];
$config[SessionRedisConstants::ZED_SESSION_REDIS_PASSWORD] = $config[StorageRedisConstants::STORAGE_REDIS_PASSWORD];
$config[SessionRedisConstants::ZED_SESSION_REDIS_DATABASE] = 2;

// >>> SECURITY BLOCKER

$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_PERSISTENT_CONNECTION] = true;
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_SCHEME] = 'tcp';
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_HOST] = '127.0.0.1';
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_PORT] = 6379;
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_PASSWORD] = false;
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_DATABASE] = 7;

$config[SecurityBlockerConstants::SECURITY_BLOCKER_BLOCKING_TTL] = 600;
$config[SecurityBlockerConstants::SECURITY_BLOCKER_BLOCK_FOR] = 300;
$config[SecurityBlockerConstants::SECURITY_BLOCKER_BLOCKING_NUMBER_OF_ATTEMPTS] = 10;

$config[SecurityBlockerConstants::SECURITY_BLOCKER_AGENT_BLOCK_FOR] = 360;
$config[SecurityBlockerConstants::SECURITY_BLOCKER_AGENT_BLOCKING_NUMBER_OF_ATTEMPTS] = 9;

// >>> SCHEDULER

$config[SchedulerConstants::ENABLED_SCHEDULERS] = [];

// >>> QUEUE

$config[EventConstants::EVENT_CHUNK] = 5000;
$config[QueueConstants::QUEUE_ADAPTER_CONFIGURATION][EventConstants::EVENT_QUEUE][QueueConfig::CONFIG_MAX_WORKER_NUMBER] = 1;

$config[EventBehaviorConstants::EVENT_BEHAVIOR_TRIGGERING_ACTIVE] = getenv('TEST_GROUP') === 'acceptance';

$currentRegion = getenv('SPRYKER_CURRENT_REGION') ?: null;
$config[RabbitMqEnv::RABBITMQ_CONNECTIONS] = array_map(static function ($storeName) use ($currentRegion, $dynamicStoreEnabled) {
    return [
        RabbitMqEnv::RABBITMQ_CONNECTION_NAME => $storeName . '-connection',
        RabbitMqEnv::RABBITMQ_HOST => 'localhost',
        RabbitMqEnv::RABBITMQ_PORT => '5672',
        RabbitMqEnv::RABBITMQ_PASSWORD => 'guest',
        RabbitMqEnv::RABBITMQ_USERNAME => 'guest',
        RabbitMqEnv::RABBITMQ_VIRTUAL_HOST => '/',
        RabbitMqEnv::RABBITMQ_STORE_NAMES => $dynamicStoreEnabled ? [] : [$storeName],
        RabbitMqEnv::RABBITMQ_DEFAULT_CONNECTION => $dynamicStoreEnabled ? $storeName === $currentRegion : $storeName === APPLICATION_STORE,
    ];
}, $dynamicStoreEnabled ? [$currentRegion] : Store::getInstance()->getAllowedStores());

// ---------- LOGGER

$config[LogConstants::LOG_LEVEL] = Logger::CRITICAL;

// >>> SYMFONY_MAILER

$config[SymfonyMailerConstants::SMTP_PORT] = 1025;

// ----------------------------------------------------------------------------
// ------------------------------ ZED (Gateway) -------------------------------
// ----------------------------------------------------------------------------

$config[ZedRequestConstants::ZED_API_SSL_ENABLED] = false;
$config[ZedRequestConstants::HOST_ZED_API]
    = $backendGatewayHost;

$config[SessionConstants::ZED_SESSION_COOKIE_NAME]
    = $config[SessionConstants::ZED_SESSION_COOKIE_DOMAIN]
    = $backofficeHost;
$config[ZedRequestConstants::BASE_URL_ZED_API] = sprintf(
    'http://%s',
    $backendGatewayHost,
);
$config[ZedRequestConstants::BASE_URL_SSL_ZED_API] = sprintf(
    'https://%s',
    $backendGatewayHost,
);

// ----------------------------------------------------------------------------
// ------------------------------ BACKOFFICE ----------------------------------
// ----------------------------------------------------------------------------

$config[ApplicationConstants::BASE_URL_ZED] = sprintf(
    'http://%s',
    $backofficeHost,
);

// ----------------------------------------------------------------------------
// ------------------------------ FRONTEND ------------------------------------
// ----------------------------------------------------------------------------

$config[ApplicationConstants::HOST_YVES]
    = $config[SessionConstants::YVES_SESSION_COOKIE_NAME]
    = $config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN]
    = $yvesHost;
$config[ApplicationConstants::BASE_URL_YVES]
    = $config[CustomerConstants::BASE_URL_YVES]
    = $config[ProductManagementConstants::BASE_URL_YVES]
    = $config[NewsletterConstants::BASE_URL_YVES]
    = sprintf(
        'http://%s',
        $yvesHost,
    );

// ----------------------------------------------------------------------------
// ------------------------------ API -----------------------------------------
// ----------------------------------------------------------------------------

$config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN]
    = sprintf(
        'http://%s',
        $glueHost,
    );

if ($isTestifyConstantsClassExists) {
    $config[TestifyConstants::GLUE_APPLICATION_DOMAIN] = $config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN];
}

$config[GlueApplicationConstants::GLUE_APPLICATION_CORS_ALLOW_ORIGIN] = '*';

// ----------------------------------------------------------------------------
// ------------------------------ OMS -----------------------------------------
// ----------------------------------------------------------------------------

require 'common/config_oms-development.php';

// ----------------------------------------------------------------------------
// ------------------------------ OAUTH ---------------------------------------
// ----------------------------------------------------------------------------
$config[OauthClientConstants::OAUTH_PROVIDER_NAME_FOR_MESSAGE_BROKER] = OauthDummyConfig::PROVIDER_NAME;
$config[OauthClientConstants::OAUTH_PROVIDER_NAME_FOR_PAYMENT_AUTHORIZE] = OauthDummyConfig::PROVIDER_NAME;
$config[AppCatalogGuiConstants::OAUTH_PROVIDER_NAME] = OauthDummyConfig::PROVIDER_NAME;

//-----------------------------------------------------------------------------
//----------------------------------- ACP -------------------------------------
//-----------------------------------------------------------------------------
$config[ProductConstants::PUBLISHING_TO_MESSAGE_BROKER_ENABLED] = false;

// ----------------------------------------------------------------------------
// ------------------------------ MessageBroker -----------------------------------------
// ----------------------------------------------------------------------------
$config[MessageBrokerConstants::IS_ENABLED] = true;

// ----------------------------------------------------------------------------
// ------------------------------ Glue Backend API -------------------------------
// ----------------------------------------------------------------------------
$config[GlueBackendApiApplicationConstants::GLUE_BACKEND_API_HOST] = $glueBackendHost;
$config[GlueBackendApiApplicationConstants::PROJECT_NAMESPACES] = [
    'Pyz',
];

if ($isTestifyConstantsClassExists) {
    $config[TestifyConstants::GLUE_BACKEND_API_DOMAIN] = sprintf('http://%s', $glueBackendHost);
}

// ----------------------------------------------------------------------------
// ------------------------------ Glue Storefront API -------------------------------
// ----------------------------------------------------------------------------
$config[GlueStorefrontApiApplicationConstants::GLUE_STOREFRONT_API_HOST] = $glueStorefrontHost;
