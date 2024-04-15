<?php

use Generated\Shared\Transfer\AddPaymentMethodTransfer;
use Generated\Shared\Transfer\AddReviewsTransfer;
use Generated\Shared\Transfer\AssetAddedTransfer;
use Generated\Shared\Transfer\AssetDeletedTransfer;
use Generated\Shared\Transfer\AssetUpdatedTransfer;
use Generated\Shared\Transfer\CancelPaymentTransfer;
use Generated\Shared\Transfer\CapturePaymentTransfer;
use Generated\Shared\Transfer\ConfigureTaxAppTransfer;
use Generated\Shared\Transfer\DeletePaymentMethodTransfer;
use Generated\Shared\Transfer\DeleteTaxAppTransfer;
use Generated\Shared\Transfer\InitializeProductExportTransfer;
use Generated\Shared\Transfer\OrderStatusChangedTransfer;
use Generated\Shared\Transfer\PaymentAuthorizationFailedTransfer;
use Generated\Shared\Transfer\PaymentAuthorizedTransfer;
use Generated\Shared\Transfer\PaymentCanceledTransfer;
use Generated\Shared\Transfer\PaymentCancellationFailedTransfer;
use Generated\Shared\Transfer\PaymentCapturedTransfer;
use Generated\Shared\Transfer\PaymentCaptureFailedTransfer;
use Generated\Shared\Transfer\PaymentCreatedTransfer;
use Generated\Shared\Transfer\PaymentRefundedTransfer;
use Generated\Shared\Transfer\PaymentRefundFailedTransfer;
use Generated\Shared\Transfer\ProductCreatedTransfer;
use Generated\Shared\Transfer\ProductDeletedTransfer;
use Generated\Shared\Transfer\ProductExportedTransfer;
use Generated\Shared\Transfer\ProductUpdatedTransfer;
use Generated\Shared\Transfer\RefundPaymentTransfer;
use Generated\Shared\Transfer\SearchEndpointAvailableTransfer;
use Generated\Shared\Transfer\SearchEndpointRemovedTransfer;
use Generated\Shared\Transfer\SubmitPaymentTaxInvoiceTransfer;
use Monolog\Logger;
use Pyz\Shared\Console\ConsoleConstants;
use Pyz\Shared\Scheduler\SchedulerConfig;
use Pyz\Yves\ShopApplication\YvesBootstrap;
use Pyz\Zed\Application\Communication\ZedBootstrap;
use Pyz\Zed\Oms\OmsConfig;
use Spryker\Client\RabbitMq\Model\RabbitMqAdapter;
use Spryker\Glue\Log\Plugin\GlueLoggerConfigPlugin;
use Spryker\Service\FlysystemLocalFileSystem\Plugin\Flysystem\LocalFilesystemBuilderPlugin;
use Spryker\Shared\Acl\AclConstants;
use Spryker\Shared\AppCatalogGui\AppCatalogGuiConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Application\Log\Config\SprykerLoggerConfig;
use Spryker\Shared\AvailabilityNotification\AvailabilityNotificationConstants;
use Spryker\Shared\CartsRestApi\CartsRestApiConstants;
use Spryker\Shared\Category\CategoryConstants;
use Spryker\Shared\CmsGui\CmsGuiConstants;
use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Shared\DocumentationGeneratorRestApi\DocumentationGeneratorRestApiConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebHtmlErrorRenderer;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\EventBehavior\EventBehaviorConstants;
use Spryker\Shared\FileManager\FileManagerConstants;
use Spryker\Shared\FileManagerGui\FileManagerGuiConstants;
use Spryker\Shared\FileSystem\FileSystemConstants;
use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Shared\GlueBackendApiApplication\GlueBackendApiApplicationConstants;
use Spryker\Shared\GlueJsonApiConvention\GlueJsonApiConventionConstants;
use Spryker\Shared\GlueStorefrontApiApplication\GlueStorefrontApiApplicationConstants;
use Spryker\Shared\Http\HttpConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Mail\MailConstants;
use Spryker\Shared\MessageBroker\MessageBrokerConstants;
use Spryker\Shared\MessageBrokerAws\MessageBrokerAwsConstants;
use Spryker\Shared\Monitoring\MonitoringConstants;
use Spryker\Shared\Newsletter\NewsletterConstants;
use Spryker\Shared\Oauth\OauthConstants;
use Spryker\Shared\OauthAuth0\OauthAuth0Constants;
use Spryker\Shared\OauthClient\OauthClientConstants;
use Spryker\Shared\OauthCryptography\OauthCryptographyConstants;
use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\Payment\PaymentConstants;
use Spryker\Shared\Product\ProductConstants;
use Spryker\Shared\ProductConfiguration\ProductConfigurationConstants;
use Spryker\Shared\ProductLabel\ProductLabelConstants;
use Spryker\Shared\ProductManagement\ProductManagementConstants;
use Spryker\Shared\ProductRelation\ProductRelationConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\PropelQueryBuilder\PropelQueryBuilderConstants;
use Spryker\Shared\PropelReplicationCache\PropelReplicationCacheConstants;
use Spryker\Shared\PushNotificationWebPushPhp\PushNotificationWebPushPhpConstants;
use Spryker\Shared\Queue\QueueConfig;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Shared\Quote\QuoteConstants;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\Router\RouterConstants;
use Spryker\Shared\Sales\SalesConstants;
use Spryker\Shared\Scheduler\SchedulerConstants;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConfig;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConstants;
use Spryker\Shared\SearchElasticsearch\SearchElasticsearchConstants;
use Spryker\Shared\SearchHttp\SearchHttpConstants;
use Spryker\Shared\SecurityBlocker\SecurityBlockerConstants;
use Spryker\Shared\SecurityBlockerBackoffice\SecurityBlockerBackofficeConstants;
use Spryker\Shared\SecurityBlockerStorefrontAgent\SecurityBlockerStorefrontAgentConstants;
use Spryker\Shared\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerConstants;
use Spryker\Shared\SecuritySystemUser\SecuritySystemUserConstants;
use Spryker\Shared\Session\SessionConfig;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\SessionRedis\SessionRedisConfig;
use Spryker\Shared\SessionRedis\SessionRedisConstants;
use Spryker\Shared\Storage\StorageConstants;
use Spryker\Shared\StorageRedis\StorageRedisConstants;
use Spryker\Shared\SymfonyMailer\SymfonyMailerConstants;
use Spryker\Shared\Synchronization\SynchronizationConstants;
use Spryker\Shared\Tax\TaxConstants;
use Spryker\Shared\TaxApp\TaxAppConstants;
use Spryker\Shared\Testify\TestifyConstants;
use Spryker\Shared\Translator\TranslatorConstants;
use Spryker\Shared\User\UserConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use Spryker\Yves\Log\Plugin\YvesLoggerConfigPlugin;
use Spryker\Zed\Log\Communication\Plugin\ZedLoggerConfigPlugin;
use Spryker\Zed\MessageBrokerAws\MessageBrokerAwsConfig;
use Spryker\Zed\OauthAuth0\OauthAuth0Config;
use Spryker\Zed\Payment\PaymentConfig;
use Spryker\Zed\Propel\PropelConfig;
use SprykerShop\Shared\CustomerPage\CustomerPageConstants;
use SprykerShop\Shared\ShopUi\ShopUiConstants;
use Symfony\Component\HttpFoundation\Cookie;

// ############################################################################
// ############################## PRODUCTION CONFIGURATION ####################
// ############################################################################

// ----------------------------------------------------------------------------
// ------------------------------ CODEBASE: TO REMOVE -------------------------
// ----------------------------------------------------------------------------

$sprykerBackendHost = getenv('SPRYKER_BE_HOST') ?: 'not-configured-host';
$sprykerFrontendHost = getenv('SPRYKER_FE_HOST') ?: 'not-configured-host';

$config[KernelConstants::SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker';

$config[KernelConstants::RESOLVABLE_CLASS_NAMES_CACHE_ENABLED] = true;
$config[KernelConstants::RESOLVED_INSTANCE_CACHE_ENABLED] = true;

$config[KernelConstants::PROJECT_NAMESPACE] = 'Pyz';
$config[KernelConstants::PROJECT_NAMESPACES] = [
    'Pyz',
];
$config[KernelConstants::CORE_NAMESPACES] = [
    'SprykerShop',
    'SprykerEco',
    'Spryker',
    'SprykerSdk',
];

// >>> ROUTER

$config[RouterConstants::YVES_SSL_EXCLUDED_ROUTE_NAMES] = [
    'healthCheck' => '/health-check',
];
$config[RouterConstants::ZED_SSL_EXCLUDED_ROUTE_NAMES] = [
    'healthCheck' => 'health-check/index',
];

// >>> DEV TOOLS

$config[ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS] = (bool)getenv('DEVELOPMENT_CONSOLE_COMMANDS');
$config[DocumentationGeneratorRestApiConstants::ENABLE_REST_API_DOCUMENTATION_GENERATION] = true;

// >>> ERROR HANDLING

$config[ErrorHandlerConstants::YVES_ERROR_PAGE] = APPLICATION_ROOT_DIR . '/public/Yves/errorpage/5xx.html';
$config[ErrorHandlerConstants::ZED_ERROR_PAGE] = APPLICATION_ROOT_DIR . '/public/Backoffice/errorpage/5xx.html';
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebHtmlErrorRenderer::class;

// >>> CMS

//$config[CmsGuiConstants::CMS_FOLDER_PATH] = '@Cms/templates/';
$config[CmsGuiConstants::CMS_PAGE_PREVIEW_URI] = '/en/cms/preview/%d';

// >>> TRANSLATOR

$config[TranslatorConstants::TRANSLATION_ZED_FALLBACK_LOCALES] = [
    'de_DE' => ['en_US'],
];

// >>> MONITORING

$config[MonitoringConstants::IGNORABLE_TRANSACTIONS] = [
    '_profiler',
    '_wdt',
];

// >>> TESTING
$isTestifyConstantsClassExists = class_exists(TestifyConstants::class);

if ($isTestifyConstantsClassExists) {
    $config[TestifyConstants::GLUE_OPEN_API_SCHEMA] = APPLICATION_SOURCE_DIR . '/Generated/Glue/Specification/spryker_rest_api.schema.yml';
    $config[TestifyConstants::BOOTSTRAP_CLASS_YVES] = YvesBootstrap::class;
    $config[TestifyConstants::BOOTSTRAP_CLASS_ZED] = ZedBootstrap::class;
}

// ----------------------------------------------------------------------------
// ------------------------------ SECURITY ------------------------------------
// ----------------------------------------------------------------------------

$trustedHosts
    = $config[HttpConstants::ZED_TRUSTED_HOSTS]
    = $config[HttpConstants::YVES_TRUSTED_HOSTS]
    = array_filter(explode(',', getenv('SPRYKER_TRUSTED_HOSTS') ?: ''));

$config[KernelConstants::DOMAIN_WHITELIST] = array_merge($trustedHosts, [
    $sprykerBackendHost,
    $sprykerFrontendHost,
    'threedssvc.pay1.de', // trusted Payone domain
    'www.sofort.com', // trusted Payone domain
]);
$config[KernelConstants::DOMAIN_WHITELIST][] = '*.bazaarvoice.com';

$config[KernelConstants::STRICT_DOMAIN_REDIRECT] = true;

$config[HttpConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $config[HttpConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $config[HttpConstants::GLUE_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = true;
$config[HttpConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG]
    = $config[HttpConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG]
    = $config[HttpConstants::GLUE_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG]
    = [
    'max_age' => 31536000,
    'include_sub_domains' => true,
    'preload' => true,
];

$config[CustomerConstants::CUSTOMER_SECURED_PATTERN] = '(^/login_check$|^(/en|/de)?/customer($|/)|^(/en|/de)?/wishlist($|/)|^(/en|/de)?/shopping-list($|/)|^(/en|/de)?/quote-request($|/)|^(/en|/de)?/comment($|/)|^(/en|/de)?/company(?!/register)($|/)|^(/en|/de)?/multi-cart($|/)|^(/en|/de)?/shared-cart($|/)|^(/en|/de)?/cart(?!/add)($|/)|^(/en|/de)?/checkout($|/))';
$config[CustomerConstants::CUSTOMER_ANONYMOUS_PATTERN] = '^/.*';
$config[CustomerPageConstants::CUSTOMER_REMEMBER_ME_SECRET] = 'hundnase';
$config[CustomerPageConstants::CUSTOMER_REMEMBER_ME_LIFETIME] = 31536000;

$config[LogConstants::LOG_SANITIZE_FIELDS] = [
    'password',
];

// ----------------------------------------------------------------------------
// ------------------------------ AUTHENTICATION ------------------------------
// ----------------------------------------------------------------------------

// >>> OAUTH

$config[OauthConstants::PRIVATE_KEY_PATH] = str_replace(
    '__LINE__',
    PHP_EOL,
    getenv('SPRYKER_OAUTH_KEY_PRIVATE') ?: '',
) ?: null;
$config[OauthConstants::PUBLIC_KEY_PATH]
    = $config[OauthCryptographyConstants::PUBLIC_KEY_PATH]
    = str_replace(
        '__LINE__',
        PHP_EOL,
        getenv('SPRYKER_OAUTH_KEY_PUBLIC') ?: '',
    ) ?: null;
$config[OauthConstants::ENCRYPTION_KEY] = getenv('SPRYKER_OAUTH_ENCRYPTION_KEY') ?: null;
$config[OauthConstants::OAUTH_CLIENT_CONFIGURATION] = json_decode(getenv('SPRYKER_OAUTH_CLIENT_CONFIGURATION'), true) ?: [];

// >> ZED REQUEST

$config[UserConstants::USER_SYSTEM_USERS] = [
    'yves_system',
];
$config[SecuritySystemUserConstants::AUTH_DEFAULT_CREDENTIALS] = [
    'yves_system' => [
        'token' => getenv('SPRYKER_ZED_REQUEST_TOKEN'),
    ],
];

// >> URL Signer

$config[HttpConstants::URI_SIGNER_SECRET_KEY] = getenv('SPRYKER_URI_SIGNER_SECRET_KEY') ?: null;

// ACL: Special rules for specific users
$config[AclConstants::ACL_DEFAULT_CREDENTIALS] = [
    'yves_system' => [
        'rules' => [
            [
                'bundle' => '*',
                'controller' => 'gateway',
                'action' => '*',
                'type' => 'allow',
            ],
        ],
    ],
];

// >> BACKOFFICE

// ACL: Allow or disallow of urls for Zed Admin GUI for ALL users
$config[AclConstants::ACL_DEFAULT_RULES] = [
    [
        'bundle' => 'security-gui',
        'controller' => '*',
        'action' => '*',
        'type' => 'allow',
    ],
    [
        'bundle' => 'acl',
        'controller' => 'index',
        'action' => 'denied',
        'type' => 'allow',
    ],
    [
        'bundle' => 'health-check',
        'controller' => 'index',
        'action' => 'index',
        'type' => 'allow',
    ],
    [
        'bundle' => 'api',
        'controller' => 'rest',
        'action' => '*',
        'type' => 'allow',
    ],
];
// ACL: Allow or disallow of urls for Zed Admin GUI
$config[AclConstants::ACL_USER_RULE_WHITELIST] = [
    [
        'bundle' => 'application',
        'controller' => '*',
        'action' => '*',
        'type' => 'allow',
    ],
];

// ----------------------------------------------------------------------------
// ------------------------------ SERVICES ------------------------------------
// ----------------------------------------------------------------------------

// >>> DATABASE

$config[PropelConstants::ZED_DB_ENGINE]
    = $config[PropelQueryBuilderConstants::ZED_DB_ENGINE]
    = strtolower(getenv('SPRYKER_DB_ENGINE') ?: '') ?: PropelConfig::DB_ENGINE_MYSQL;
$config[PropelConstants::ZED_DB_HOST] = getenv('SPRYKER_DB_HOST');
$config[PropelConstants::ZED_DB_PORT] = getenv('SPRYKER_DB_PORT');
$config[PropelConstants::ZED_DB_USERNAME] = getenv('SPRYKER_DB_USERNAME');
$config[PropelConstants::ZED_DB_PASSWORD] = getenv('SPRYKER_DB_PASSWORD');
$config[PropelConstants::ZED_DB_DATABASE] = getenv('SPRYKER_DB_DATABASE');
$config[PropelConstants::ZED_DB_REPLICAS] = json_decode(getenv('SPRYKER_DB_REPLICAS') ?: '[]', true);
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false;

// >>> DATABASE REPLICA CACHE
$config[PropelReplicationCacheConstants::CACHE_TTL] = 2;

// >>> SEARCH

$config[SearchElasticsearchConstants::HOST] = getenv('SPRYKER_SEARCH_HOST');
$config[SearchElasticsearchConstants::TRANSPORT] = getenv('SPRYKER_SEARCH_PROTOCOL') ?: 'http';
$config[SearchElasticsearchConstants::PORT] = getenv('SPRYKER_SEARCH_PORT');
$config[SearchElasticsearchConstants::AUTH_HEADER] = getenv('SPRYKER_SEARCH_BASIC_AUTH') ?: null;
$config[SearchElasticsearchConstants::INDEX_PREFIX] = getenv('SPRYKER_SEARCH_INDEX_PREFIX') ?: '';

$config[SearchElasticsearchConstants::FULL_TEXT_BOOSTED_BOOSTING_VALUE] = 3;

// >>> STORAGE

$config[StorageConstants::STORAGE_KV_SOURCE] = strtolower(getenv('SPRYKER_KEY_VALUE_STORE_ENGINE')) ?: 'redis';
$config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION] = true;
$config[StorageRedisConstants::STORAGE_REDIS_SCHEME] = getenv('SPRYKER_KEY_VALUE_STORE_PROTOCOL') ?: 'tcp';
$config[StorageRedisConstants::STORAGE_REDIS_HOST] = getenv('SPRYKER_KEY_VALUE_STORE_HOST');
$config[StorageRedisConstants::STORAGE_REDIS_PORT] = getenv('SPRYKER_KEY_VALUE_STORE_PORT');
$config[StorageRedisConstants::STORAGE_REDIS_PASSWORD] = getenv('SPRYKER_KEY_VALUE_STORE_PASSWORD');
$config[StorageRedisConstants::STORAGE_REDIS_DATABASE] = getenv('SPRYKER_KEY_VALUE_STORE_NAMESPACE') ?: 1;
$config[StorageRedisConstants::STORAGE_REDIS_DATA_SOURCE_NAMES] = json_decode(getenv('SPRYKER_KEY_VALUE_STORE_SOURCE_NAMES') ?: '[]', true) ?: [];
$config[StorageRedisConstants::STORAGE_REDIS_CONNECTION_OPTIONS] = json_decode(getenv('SPRYKER_KEY_VALUE_STORE_CONNECTION_OPTIONS') ?: '[]', true) ?: [];

// >>> SESSION

$config[SecuritySystemUserConstants::SYSTEM_USER_SESSION_REDIS_LIFE_TIME] = 20;
$config[SessionRedisConstants::LOCKING_TIMEOUT_MILLISECONDS] = 0;
$config[SessionRedisConstants::LOCKING_RETRY_DELAY_MICROSECONDS] = 0;
$config[SessionRedisConstants::LOCKING_LOCK_TTL_MILLISECONDS] = 0;

// >>> SESSION FRONTEND

$config[SessionConstants::YVES_SESSION_COOKIE_NAME]
    = $config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN]
    = $sprykerFrontendHost;
$config[SessionConstants::YVES_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS_LOCKING;
$config[SessionRedisConstants::YVES_SESSION_REDIS_SCHEME] = getenv('SPRYKER_SESSION_FE_PROTOCOL') ?: 'tcp';
$config[SessionRedisConstants::YVES_SESSION_REDIS_HOST] = getenv('SPRYKER_SESSION_FE_HOST');
$config[SessionRedisConstants::YVES_SESSION_REDIS_PORT] = getenv('SPRYKER_SESSION_FE_PORT');
$config[SessionRedisConstants::YVES_SESSION_REDIS_PASSWORD] = getenv('SPRYKER_SESSION_FE_PASSWORD');
$config[SessionRedisConstants::YVES_SESSION_REDIS_DATABASE] = getenv('SPRYKER_SESSION_FE_NAMESPACE') ?: 2;

$config[SessionConstants::YVES_SESSION_TIME_TO_LIVE]
    = $config[SessionRedisConstants::YVES_SESSION_TIME_TO_LIVE]
    = SessionConfig::SESSION_LIFETIME_1_HOUR;
$config[SessionConstants::YVES_SESSION_COOKIE_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_0_5_HOUR;
$config[SessionConstants::YVES_SESSION_PERSISTENT_CONNECTION]
    = $config[SessionConstants::ZED_SESSION_PERSISTENT_CONNECTION]
    = true;
$config[SessionConstants::YVES_SESSION_COOKIE_SAMESITE] = getenv('SPRYKER_YVES_SESSION_COOKIE_SAMESITE') ?: Cookie::SAMESITE_LAX;

// >>> SESSION BACKOFFICE

$config[SessionConstants::ZED_SESSION_COOKIE_NAME]
    = $config[SessionConstants::ZED_SESSION_COOKIE_DOMAIN]
    = $sprykerBackendHost;
$config[SessionConstants::ZED_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS;
$config[SessionRedisConstants::ZED_SESSION_REDIS_SCHEME] = getenv('SPRYKER_SESSION_BE_PROTOCOL') ?: 'tcp';
$config[SessionRedisConstants::ZED_SESSION_REDIS_HOST] = getenv('SPRYKER_SESSION_BE_HOST');
$config[SessionRedisConstants::ZED_SESSION_REDIS_PORT] = getenv('SPRYKER_SESSION_BE_PORT');
$config[SessionRedisConstants::ZED_SESSION_REDIS_PASSWORD] = getenv('SPRYKER_SESSION_BE_PASSWORD');
$config[SessionRedisConstants::ZED_SESSION_REDIS_DATABASE] = getenv('SPRYKER_SESSION_BE_NAMESPACE') ?: 2;

$config[SessionConstants::ZED_SESSION_TIME_TO_LIVE]
    = $config[SessionRedisConstants::ZED_SESSION_TIME_TO_LIVE]
    = SessionConfig::SESSION_LIFETIME_1_HOUR;
$config[SessionConstants::ZED_SESSION_COOKIE_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_BROWSER_SESSION;
$config[SessionConstants::ZED_SESSION_COOKIE_SAMESITE] = getenv('SPRYKER_ZED_SESSION_COOKIE_SAMESITE') ?: Cookie::SAMESITE_STRICT;

// >>> Product Relation
$config[ProductRelationConstants::PRODUCT_RELATION_READ_CHUNK] = 1000;
$config[ProductRelationConstants::PRODUCT_RELATION_UPDATE_CHUNK] = 1000;

$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_PERSISTENT_CONNECTION] = true;
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_SCHEME] = getenv('SPRYKER_KEY_VALUE_STORE_PROTOCOL') ?: 'tcp';
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_HOST] = getenv('SPRYKER_KEY_VALUE_STORE_HOST');
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_PORT] = getenv('SPRYKER_KEY_VALUE_STORE_PORT');
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_PASSWORD] = getenv('SPRYKER_KEY_VALUE_STORE_PASSWORD');
$config[SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_DATABASE] = 7;

$config[SecurityBlockerConstants::SECURITY_BLOCKER_BLOCKING_TTL] = 600;
$config[SecurityBlockerConstants::SECURITY_BLOCKER_BLOCK_FOR] = 300;
$config[SecurityBlockerConstants::SECURITY_BLOCKER_BLOCKING_NUMBER_OF_ATTEMPTS] = 10;

// >>> Security Blocker Storefront Agent
$config[SecurityBlockerStorefrontAgentConstants::AGENT_BLOCK_FOR_SECONDS] = 360;
$config[SecurityBlockerStorefrontAgentConstants::AGENT_BLOCKING_TTL] = 900;
$config[SecurityBlockerStorefrontAgentConstants::AGENT_BLOCKING_NUMBER_OF_ATTEMPTS] = 9;

// >>> Security Blocker Storefront Customer
$config[SecurityBlockerStorefrontCustomerConstants::CUSTOMER_BLOCK_FOR_SECONDS] = 360;
$config[SecurityBlockerStorefrontCustomerConstants::CUSTOMER_BLOCKING_TTL] = 900;
$config[SecurityBlockerStorefrontCustomerConstants::CUSTOMER_BLOCKING_NUMBER_OF_ATTEMPTS] = 9;

// >>> Security Blocker BackOffice user
$config[SecurityBlockerBackofficeConstants::BACKOFFICE_USER_BLOCKING_TTL] = 900;
$config[SecurityBlockerBackofficeConstants::BACKOFFICE_USER_BLOCK_FOR_SECONDS] = 360;
$config[SecurityBlockerBackofficeConstants::BACKOFFICE_USER_BLOCKING_NUMBER_OF_ATTEMPTS] = 9;

// >>> LOGGING

// Due to some deprecation notices we silence all deprecations for the time being
$config[ErrorHandlerConstants::ERROR_LEVEL] = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED;
$config[ErrorHandlerConstants::ERROR_LEVEL_LOG_ONLY] = E_DEPRECATED | E_USER_DEPRECATED;

$config[LogConstants::LOGGER_CONFIG] = SprykerLoggerConfig::class;
$config[LogConstants::LOGGER_CONFIG_ZED] = ZedLoggerConfigPlugin::class;
$config[LogConstants::LOGGER_CONFIG_YVES] = YvesLoggerConfigPlugin::class;
$config[LogConstants::LOGGER_CONFIG_GLUE] = GlueLoggerConfigPlugin::class;

$config[LogConstants::LOG_QUEUE_NAME] = 'log-queue';
$config[LogConstants::LOG_ERROR_QUEUE_NAME] = 'error-log-queue';

$config[LogConstants::LOG_LEVEL] = Logger::INFO;
$config[PropelConstants::LOG_FILE_PATH]
    = $config[EventConstants::LOG_FILE_PATH]
    = $config[LogConstants::LOG_FILE_PATH_YVES]
    = $config[LogConstants::LOG_FILE_PATH_ZED]
    = $config[LogConstants::LOG_FILE_PATH_GLUE]
    = $config[LogConstants::LOG_FILE_PATH]
    = $config[QueueConstants::QUEUE_WORKER_OUTPUT_FILE_NAME]
    = getenv('SPRYKER_LOG_STDOUT') ?: 'php://stderr';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_YVES]
    = $config[LogConstants::EXCEPTION_LOG_FILE_PATH_ZED]
    = $config[LogConstants::EXCEPTION_LOG_FILE_PATH_GLUE]
    = $config[LogConstants::EXCEPTION_LOG_FILE_PATH]
    = getenv('SPRYKER_LOG_STDERR') ?: 'php://stderr';

// >>> QUEUE

$config[EventBehaviorConstants::EVENT_BEHAVIOR_TRIGGERING_ACTIVE] = true;

$config[EventConstants::MAX_RETRY_ON_FAIL] = 5;
$config[QueueConstants::QUEUE_PROCESS_TRIGGER_INTERVAL_MICROSECONDS] = 1001;

$config[QueueConstants::QUEUE_ADAPTER_CONFIGURATION] = [
    EventConstants::EVENT_QUEUE => [
        QueueConfig::CONFIG_QUEUE_ADAPTER => RabbitMqAdapter::class,
        QueueConfig::CONFIG_MAX_WORKER_NUMBER => 5,
    ],
];

$config[QueueConstants::QUEUE_ADAPTER_CONFIGURATION_DEFAULT] = [
    QueueConfig::CONFIG_QUEUE_ADAPTER => RabbitMqAdapter::class,
    QueueConfig::CONFIG_MAX_WORKER_NUMBER => 1,
];

$config[RabbitMqEnv::RABBITMQ_API_HOST] = getenv('SPRYKER_BROKER_API_HOST');
$config[RabbitMqEnv::RABBITMQ_API_PORT] = getenv('SPRYKER_BROKER_API_PORT');
$config[RabbitMqEnv::RABBITMQ_API_USERNAME] = getenv('SPRYKER_BROKER_API_USERNAME');
$config[RabbitMqEnv::RABBITMQ_API_PASSWORD] = getenv('SPRYKER_BROKER_API_PASSWORD');
$config[RabbitMqEnv::RABBITMQ_API_VIRTUAL_HOST] = getenv('SPRYKER_BROKER_NAMESPACE');

$rabbitConnections = json_decode(getenv('SPRYKER_BROKER_CONNECTIONS') ?: '[]', true);
$defaultConnection = [
    RabbitMqEnv::RABBITMQ_HOST => getenv('SPRYKER_BROKER_HOST'),
    RabbitMqEnv::RABBITMQ_PORT => getenv('SPRYKER_BROKER_PORT'),
    RabbitMqEnv::RABBITMQ_PASSWORD => getenv('SPRYKER_BROKER_PASSWORD'),
    RabbitMqEnv::RABBITMQ_USERNAME => getenv('SPRYKER_BROKER_USERNAME'),
];

$config[RabbitMqEnv::RABBITMQ_CONNECTIONS] = [];
$connectionKeys = array_keys($rabbitConnections);
$defaultKey = reset($connectionKeys);
if (getenv('SPRYKER_CURRENT_REGION')) {
    $defaultKey = getenv('SPRYKER_CURRENT_REGION');
}
if (getenv('APPLICATION_STORE') && (bool)getenv('SPRYKER_DYNAMIC_STORE_MODE') === false) {
    $defaultKey = getenv('APPLICATION_STORE');
}
foreach ($rabbitConnections as $key => $connection) {
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key] = $defaultConnection;
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_CONNECTION_NAME] = $key . '-connection';
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_STORE_NAMES] = [$key];
    foreach ($connection as $constant => $value) {
        $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][constant(RabbitMqEnv::class . '::' . $constant)] = $value;
    }
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_DEFAULT_CONNECTION] = $key === $defaultKey;
}

// >>> SYNCHRONIZATION
$config[SynchronizationConstants::DEFAULT_SYNC_SEARCH_QUEUE_MESSAGE_CHUNK_SIZE] = 1000;

// >>> SCHEDULER
$config[SchedulerConstants::ENABLED_SCHEDULERS] = [
    SchedulerConfig::SCHEDULER_JENKINS,
];
$config[SchedulerJenkinsConstants::JENKINS_CONFIGURATION] = [
    SchedulerConfig::SCHEDULER_JENKINS => [
        SchedulerJenkinsConfig::SCHEDULER_JENKINS_BASE_URL => sprintf(
            '%s://%s:%s/',
            getenv('SPRYKER_SCHEDULER_PROTOCOL') ?: 'http',
            getenv('SPRYKER_SCHEDULER_HOST'),
            getenv('SPRYKER_SCHEDULER_PORT'),
        ),
        SchedulerJenkinsConfig::SCHEDULER_JENKINS_CSRF_ENABLED => (bool)getenv('SPRYKER_JENKINS_CSRF_PROTECTION_ENABLED'),
    ],
];

$config[SchedulerJenkinsConstants::JENKINS_TEMPLATE_PATH] = getenv('SPRYKER_JENKINS_TEMPLATE_PATH') ?: null;

// >>> MAIL
$config[MailConstants::SENDER_EMAIL] = getenv('SPRYKER_MAIL_SENDER_EMAIL') ?: null;
$config[MailConstants::SENDER_NAME] = getenv('SPRYKER_MAIL_SENDER_NAME') ?: null;

// >>> SYMFONY_MAILER
$config[SymfonyMailerConstants::SMTP_HOST] = getenv('SPRYKER_SMTP_HOST') ?: null;
$config[SymfonyMailerConstants::SMTP_PORT] = getenv('SPRYKER_SMTP_PORT') ?: null;
$config[SymfonyMailerConstants::SMTP_ENCRYPTION] = getenv('SPRYKER_SMTP_ENCRYPTION') ?: null;
$config[SymfonyMailerConstants::SMTP_AUTH_MODE] = getenv('SPRYKER_SMTP_AUTH_MODE') ?: null;
$config[SymfonyMailerConstants::SMTP_USERNAME] = getenv('SPRYKER_SMTP_USERNAME') ?: null;
$config[SymfonyMailerConstants::SMTP_PASSWORD] = getenv('SPRYKER_SMTP_PASSWORD') ?: null;

// >>> FILESYSTEM
$config[FileSystemConstants::FILESYSTEM_SERVICE] = [
    'files' => [
        'sprykerAdapterClass' => LocalFilesystemBuilderPlugin::class,
        'root' => APPLICATION_ROOT_DIR . '/data/DE/media/',
        'path' => 'files/',
    ],
];
$config[FileManagerConstants::STORAGE_NAME] = 'files';
$config[FileManagerGuiConstants::DEFAULT_FILE_MAX_SIZE] = '10M';

// ----------------------------------------------------------------------------
// ------------------------------ ZED -----------------------------------------
// ----------------------------------------------------------------------------

$config[ZedRequestConstants::ZED_API_SSL_ENABLED] = (bool)getenv('SPRYKER_ZED_SSL_ENABLED');
$backofficeDefaultPort = $config[ZedRequestConstants::ZED_API_SSL_ENABLED] ? 443 : 80;
$zedPort = ((int)getenv('SPRYKER_ZED_PORT')) ?: $backofficeDefaultPort;
$config[ZedRequestConstants::HOST_ZED_API] = sprintf(
    '%s%s',
    getenv('SPRYKER_ZED_HOST') ?: 'not-configured-host',
    $zedPort !== $backofficeDefaultPort ? ':' . $zedPort : '',
);
$config[ZedRequestConstants::BASE_URL_ZED_API] = sprintf(
    'http://%s',
    $config[ZedRequestConstants::HOST_ZED_API],
);
$config[ZedRequestConstants::BASE_URL_SSL_ZED_API] = sprintf(
    'https://%s',
    $config[ZedRequestConstants::HOST_ZED_API],
);

// ----------------------------------------------------------------------------
// ------------------------------ BACKOFFICE ----------------------------------
// ----------------------------------------------------------------------------

$backofficePort = (int)(getenv('SPRYKER_BE_PORT')) ?: 443;
$config[ApplicationConstants::BASE_URL_ZED] = sprintf(
    'https://%s%s',
    $sprykerBackendHost,
    $backofficePort !== 443 ? $backofficePort : '',
);

// ----------------------------------------------------------------------------
// ------------------------------ FRONTEND ------------------------------------
// ----------------------------------------------------------------------------

$yvesHost = $config[ApplicationConstants::HOST_YVES] = $sprykerFrontendHost;
$yvesPort = (int)(getenv('SPRYKER_FE_PORT')) ?: 443;

$config[ApplicationConstants::BASE_URL_YVES]
    = $config[CustomerConstants::BASE_URL_YVES]
    = $config[ProductManagementConstants::BASE_URL_YVES]
    = $config[NewsletterConstants::BASE_URL_YVES]
    = sprintf(
        'https://%s%s',
        $yvesHost,
        $yvesPort !== 443 ? ':' . $yvesPort : '',
    );

$config[ShopUiConstants::YVES_ASSETS_URL_PATTERN] = '/assets/' . (getenv('SPRYKER_BUILD_HASH') ?: 'current') . '/%theme%/';

// >>> Availability Notification
$config[AvailabilityNotificationConstants::BASE_URL_YVES_PORT] = $yvesPort;
$config[AvailabilityNotificationConstants::STORE_TO_YVES_HOST_MAPPING] = [
    'DE' => getenv('SPRYKER_YVES_HOST_DE'),
    'AT' => getenv('SPRYKER_YVES_HOST_AT'),
    'US' => getenv('SPRYKER_YVES_HOST_US'),
];
$config[AvailabilityNotificationConstants::REGION_TO_YVES_HOST_MAPPING] = [
    'EU' => getenv('SPRYKER_YVES_HOST_EU'),
    'US' => getenv('SPRYKER_YVES_HOST_US'),
];

// ----------------------------------------------------------------------------
// ------------------------------ API -----------------------------------------
// ----------------------------------------------------------------------------

$glueHost = getenv('SPRYKER_API_HOST') ?: 'localhost';
$gluePort = (int)(getenv('SPRYKER_API_PORT')) ?: 443;
$config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN]
    = sprintf(
        'https://%s%s',
        $glueHost,
        $gluePort !== 443 ? ':' . $gluePort : '',
    );

if ($isTestifyConstantsClassExists) {
    $config[TestifyConstants::GLUE_APPLICATION_DOMAIN] = $config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN];
}

$config[GlueApplicationConstants::GLUE_APPLICATION_CORS_ALLOW_ORIGIN] = getenv('SPRYKER_GLUE_APPLICATION_CORS_ALLOW_ORIGIN') ?: '';

// ----------------------------------------------------------------------------
// ------------------------------ OMS -----------------------------------------
// ----------------------------------------------------------------------------

$config[OmsConstants::PROCESS_LOCATION] = [
    OmsConfig::DEFAULT_PROCESS_LOCATION,
    APPLICATION_ROOT_DIR . '/vendor/spryker/sales-payment/config/Zed/Oms',
];
$config[OmsConstants::ACTIVE_PROCESSES] = [
    'ForeignPaymentStateMachine01',
];
$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    PaymentConfig::PAYMENT_FOREIGN_PROVIDER => 'ForeignPaymentStateMachine01',
];

// ---------- Guest cart
$config[QuoteConstants::GUEST_QUOTE_LIFETIME] = 'P01M';

// >>> Taxes
$config[TaxConstants::DEFAULT_TAX_RATE] = 19;

// >>> Category
$config[CategoryConstants::CATEGORY_READ_CHUNK] = 10000;
$config[CategoryConstants::CATEGORY_IS_CLOSURE_TABLE_EVENTS_ENABLED] = false;

// >>> Product Label
$config[ProductLabelConstants::PRODUCT_LABEL_TO_DE_ASSIGN_CHUNK_SIZE] = 1000;

// ----------------------------------------------------------------------------
// ------------------------------ CART REST API -------------------------------
// ----------------------------------------------------------------------------
$config[CartsRestApiConstants::IS_QUOTE_RELOAD_ENABLED] = true;

// ----------------------------------------------------------------------------
// ------------------------------ ACP -----------------------------------------
// ----------------------------------------------------------------------------
$aopApplicationConfiguration = json_decode(html_entity_decode((string)getenv('SPRYKER_AOP_APPLICATION')), true);
$config[KernelConstants::DOMAIN_WHITELIST] = array_merge(
    $config[KernelConstants::DOMAIN_WHITELIST],
    $aopApplicationConfiguration['APP_DOMAINS'] ?? [],
);
$config[AppCatalogGuiConstants::APP_CATALOG_SCRIPT_URL] = $aopApplicationConfiguration['APP_CATALOG_SCRIPT_URL'] ?? '';

$aopAuthenticationConfiguration = json_decode(html_entity_decode((string)getenv('SPRYKER_AOP_AUTHENTICATION')), true);
$config[OauthAuth0Constants::AUTH0_CUSTOM_DOMAIN] = $aopAuthenticationConfiguration['AUTH0_CUSTOM_DOMAIN'] ?? '';
$config[OauthAuth0Constants::AUTH0_CLIENT_ID] = $aopAuthenticationConfiguration['AUTH0_CLIENT_ID'] ?? '';
$config[OauthAuth0Constants::AUTH0_CLIENT_SECRET] = $aopAuthenticationConfiguration['AUTH0_CLIENT_SECRET'] ?? '';

$config[SearchHttpConstants::TENANT_IDENTIFIER]
    = $config[ProductConstants::TENANT_IDENTIFIER]
    = $config[MessageBrokerConstants::TENANT_IDENTIFIER]
    = $config[MessageBrokerAwsConstants::CONSUMER_ID]
    = $config[OauthClientConstants::TENANT_IDENTIFIER]
    = $config[PaymentConstants::TENANT_IDENTIFIER]
    = $config[AppCatalogGuiConstants::TENANT_IDENTIFIER]
    = $config[TaxAppConstants::TENANT_IDENTIFIER]
    = getenv('SPRYKER_TENANT_IDENTIFIER') ?: '';

$config[MessageBrokerConstants::MESSAGE_TO_CHANNEL_MAP] =
$config[MessageBrokerAwsConstants::MESSAGE_TO_CHANNEL_MAP] = [
    AddPaymentMethodTransfer::class => 'payment-method-commands',
    DeletePaymentMethodTransfer::class => 'payment-method-commands',
    CancelPaymentTransfer::class => 'payment-commands',
    CapturePaymentTransfer::class => 'payment-commands',
    RefundPaymentTransfer::class => 'payment-commands',
    PaymentAuthorizedTransfer::class => 'payment-events',
    PaymentAuthorizationFailedTransfer::class => 'payment-events',
    PaymentCapturedTransfer::class => 'payment-events',
    PaymentCaptureFailedTransfer::class => 'payment-events',
    PaymentRefundedTransfer::class => 'payment-events',
    PaymentRefundFailedTransfer::class => 'payment-events',
    PaymentCanceledTransfer::class => 'payment-events',
    PaymentCancellationFailedTransfer::class => 'payment-events',
    AssetAddedTransfer::class => 'asset-commands',
    AssetUpdatedTransfer::class => 'asset-commands',
    AssetDeletedTransfer::class => 'asset-commands',
    ProductExportedTransfer::class => 'product-events',
    ProductCreatedTransfer::class => 'product-events',
    ProductUpdatedTransfer::class => 'product-events',
    ProductDeletedTransfer::class => 'product-events',
    InitializeProductExportTransfer::class => 'product-commands',
    SearchEndpointAvailableTransfer::class => 'search-commands',
    SearchEndpointRemovedTransfer::class => 'search-commands',
    AddReviewsTransfer::class => 'product-review-commands',
    OrderStatusChangedTransfer::class => 'order-events',
    ConfigureTaxAppTransfer::class => 'tax-commands',
    DeleteTaxAppTransfer::class => 'tax-commands',
    SubmitPaymentTaxInvoiceTransfer::class => 'payment-tax-invoice-commands',
    PaymentCreatedTransfer::class => 'payment-events',
];

$config[MessageBrokerConstants::CHANNEL_TO_RECEIVER_TRANSPORT_MAP] = [
    'payment-events' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
    'payment-method-commands' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
    'asset-commands' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
    'product-review-commands' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
    'product-commands' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
    'search-commands' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
    'tax-commands' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
];

$config[MessageBrokerConstants::CHANNEL_TO_SENDER_TRANSPORT_MAP] = [
    'payment-commands' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
    'product-events' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
    'order-events' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
    'payment-tax-invoice-commands' => MessageBrokerAwsConfig::HTTP_CHANNEL_TRANSPORT,
];

// -------------------------------- ACP AWS --------------------------------------
$config[MessageBrokerAwsConstants::HTTP_CHANNEL_SENDER_BASE_URL] = getenv('SPRYKER_MESSAGE_BROKER_HTTP_CHANNEL_SENDER_BASE_URL') ?: '';
$config[MessageBrokerAwsConstants::HTTP_CHANNEL_RECEIVER_BASE_URL] = getenv('SPRYKER_MESSAGE_BROKER_HTTP_CHANNEL_RECEIVER_BASE_URL') ?: '';

$config[MessageBrokerConstants::IS_ENABLED] = (
    $config[MessageBrokerAwsConstants::HTTP_CHANNEL_SENDER_BASE_URL]
    && $config[MessageBrokerAwsConstants::HTTP_CHANNEL_RECEIVER_BASE_URL]
);

$config[ProductConstants::PUBLISHING_TO_MESSAGE_BROKER_ENABLED] = $config[MessageBrokerConstants::IS_ENABLED];

// ----------------------------------------------------------------------------
// ------------------------------ OAUTH ---------------------------------------
// ----------------------------------------------------------------------------
$config[OauthClientConstants::OAUTH_PROVIDER_NAME_FOR_MESSAGE_BROKER] = OauthAuth0Config::PROVIDER_NAME;
$config[OauthClientConstants::OAUTH_GRANT_TYPE_FOR_MESSAGE_BROKER] = OauthAuth0Config::GRANT_TYPE_CLIENT_CREDENTIALS;
$config[OauthClientConstants::OAUTH_OPTION_AUDIENCE_FOR_MESSAGE_BROKER] = 'aop-event-platform';

$config[AppCatalogGuiConstants::OAUTH_PROVIDER_NAME] = OauthAuth0Config::PROVIDER_NAME;
$config[AppCatalogGuiConstants::OAUTH_GRANT_TYPE] = OauthAuth0Config::GRANT_TYPE_CLIENT_CREDENTIALS;
$config[AppCatalogGuiConstants::OAUTH_OPTION_AUDIENCE] = 'aop-atrs';

$config[OauthClientConstants::OAUTH_PROVIDER_NAME_FOR_PAYMENT_AUTHORIZE] = OauthAuth0Config::PROVIDER_NAME;
$config[OauthClientConstants::OAUTH_GRANT_TYPE_FOR_PAYMENT_AUTHORIZE] = OauthAuth0Config::GRANT_TYPE_CLIENT_CREDENTIALS;
$config[OauthClientConstants::OAUTH_OPTION_AUDIENCE_FOR_PAYMENT_AUTHORIZE] = 'aop-app';

$config[TaxAppConstants::OAUTH_PROVIDER_NAME] = OauthAuth0Config::PROVIDER_NAME;
$config[TaxAppConstants::OAUTH_GRANT_TYPE] = OauthAuth0Config::GRANT_TYPE_CLIENT_CREDENTIALS;
$config[TaxAppConstants::OAUTH_OPTION_AUDIENCE] = 'aop-app';

// ----------------------------------------------------------------------------
// ------------------------------ Product Configuration ---------------------------------------
// ----------------------------------------------------------------------------
$config[ProductConfigurationConstants::SPRYKER_PRODUCT_CONFIGURATOR_ENCRYPTION_KEY] = getenv('SPRYKER_PRODUCT_CONFIGURATOR_ENCRYPTION_KEY') ?: 'change123';
$config[ProductConfigurationConstants::SPRYKER_PRODUCT_CONFIGURATOR_HEX_INITIALIZATION_VECTOR] = getenv('SPRYKER_PRODUCT_CONFIGURATOR_HEX_INITIALIZATION_VECTOR') ?: '0c1ffefeebdab4a3d839d0e52590c9a2';
$config[KernelConstants::DOMAIN_WHITELIST][] = getenv('SPRYKER_PRODUCT_CONFIGURATOR_HOST');

// ----------------------------------------------------------------------------
// ------------------------------ Glue Backend API -------------------------------
// ----------------------------------------------------------------------------
$sprykerGlueBackendHost = getenv('SPRYKER_GLUE_BACKEND_HOST');
$sprykerGlueBackendPort = (int)(getenv('SPRYKER_GLUE_BACKEND_PORT')) ?: 443;
$config[GlueBackendApiApplicationConstants::GLUE_BACKEND_API_HOST] = $sprykerGlueBackendHost;
$config[GlueBackendApiApplicationConstants::PROJECT_NAMESPACES] = [
    'Pyz',
];
$config[GlueBackendApiApplicationConstants::GLUE_BACKEND_CORS_ALLOW_ORIGIN] = getenv('SPRYKER_GLUE_APPLICATION_CORS_ALLOW_ORIGIN') ?: '*';

if ($isTestifyConstantsClassExists) {
    $config[TestifyConstants::GLUE_BACKEND_API_DOMAIN] = sprintf(
        'https://%s%s',
        $sprykerGlueBackendHost,
        $sprykerGlueBackendPort !== 443 ? ':' . $sprykerGlueBackendPort : '',
    );
    $config[TestifyConstants::GLUE_BACKEND_API_OPEN_API_SCHEMA] = APPLICATION_SOURCE_DIR . '/Generated/GlueBackend/Specification/spryker_backend_api.schema.yml';
}

// ----------------------------------------------------------------------------
// ------------------------------ Glue Storefront API -------------------------------
// ----------------------------------------------------------------------------
$sprykerGlueStorefrontHost = getenv('SPRYKER_GLUE_STOREFRONT_HOST');
$config[GlueStorefrontApiApplicationConstants::GLUE_STOREFRONT_API_HOST] = $sprykerGlueStorefrontHost;
$gluePort = (int)(getenv('SPRYKER_API_PORT')) ?: 443;
$protocol = $gluePort === 443 ? 'https' : 'http';
$config[GlueJsonApiConventionConstants::GLUE_DOMAIN] = sprintf(
    '%s://%s',
    $protocol,
    $sprykerGlueStorefrontHost ?: $sprykerGlueBackendHost ?: 'localhost',
);
$config[GlueStorefrontApiApplicationConstants::GLUE_STOREFRONT_CORS_ALLOW_ORIGIN] = getenv('SPRYKER_GLUE_APPLICATION_CORS_ALLOW_ORIGIN') ?: '*';

// ----------------------------------------------------------------------------
// ------------------------------ Push Notification ---------------------------
// ----------------------------------------------------------------------------
$config[PushNotificationWebPushPhpConstants::VAPID_PUBLIC_KEY] = getenv('SPRYKER_PUSH_NOTIFICATION_WEB_PUSH_PHP_VAPID_PUBLIC_KEY');
$config[PushNotificationWebPushPhpConstants::VAPID_PRIVATE_KEY] = getenv('SPRYKER_PUSH_NOTIFICATION_WEB_PUSH_PHP_VAPID_PRIVATE_KEY');
$config[PushNotificationWebPushPhpConstants::VAPID_SUBJECT] = getenv('SPRYKER_PUSH_NOTIFICATION_WEB_PUSH_PHP_VAPID_SUBJECT');
