<?php

use Monolog\Logger;
use Pyz\Shared\Console\ConsoleConstants;
use Pyz\Shared\Scheduler\SchedulerConfig;
use Pyz\Yves\ShopApplication\YvesBootstrap;
use Pyz\Zed\Application\Communication\ZedBootstrap;
use Spryker\Client\RabbitMq\Model\RabbitMqAdapter;
use Spryker\Glue\Log\Plugin\GlueLoggerConfigPlugin;
use Spryker\Service\FlysystemLocalFileSystem\Plugin\Flysystem\LocalFilesystemBuilderPlugin;
use Spryker\Shared\Acl\AclConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Application\Log\Config\SprykerLoggerConfig;
use Spryker\Shared\Auth\AuthConstants;
use Spryker\Shared\CmsGui\CmsGuiConstants;
use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebHtmlErrorRenderer;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\EventBehavior\EventBehaviorConstants;
use Spryker\Shared\FileManager\FileManagerConstants;
use Spryker\Shared\FileManagerGui\FileManagerGuiConstants;
use Spryker\Shared\FileSystem\FileSystemConstants;
use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Shared\Http\HttpConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Mail\MailConstants;
use Spryker\Shared\Monitoring\MonitoringConstants;
use Spryker\Shared\Newsletter\NewsletterConstants;
use Spryker\Shared\Oauth\OauthConstants;
use Spryker\Shared\OauthCryptography\OauthCryptographyConstants;
use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\ProductManagement\ProductManagementConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\PropelQueryBuilder\PropelQueryBuilderConstants;
use Spryker\Shared\Queue\QueueConfig;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\Router\RouterConstants;
use Spryker\Shared\Sales\SalesConstants;
use Spryker\Shared\Scheduler\SchedulerConstants;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConfig;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConstants;
use Spryker\Shared\SearchElasticsearch\SearchElasticsearchConstants;
use Spryker\Shared\Session\SessionConfig;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\SessionRedis\SessionRedisConfig;
use Spryker\Shared\SessionRedis\SessionRedisConstants;
use Spryker\Shared\Storage\StorageConstants;
use Spryker\Shared\StorageRedis\StorageRedisConstants;
use Spryker\Shared\Tax\TaxConstants;
use Spryker\Shared\Testify\TestifyConstants;
use Spryker\Shared\Translator\TranslatorConstants;
use Spryker\Shared\User\UserConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use Spryker\Yves\Log\Plugin\YvesLoggerConfigPlugin;
use Spryker\Zed\Log\Communication\Plugin\ZedLoggerConfigPlugin;
use Spryker\Zed\Propel\PropelConfig;
use SprykerShop\Shared\ShopUi\ShopUiConstants;

// ############################################################################
// ############################## PRODUCTION CONFIGURATION ####################
// ############################################################################

// ----------------------------------------------------------------------------
// ------------------------------ CODEBASE: TO REMOVE -------------------------
// ----------------------------------------------------------------------------

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

// >>> ERROR HANDLING

$config[ErrorHandlerConstants::YVES_ERROR_PAGE] = APPLICATION_ROOT_DIR . '/public/Yves/errorpage/5xx.html';
$config[ErrorHandlerConstants::ZED_ERROR_PAGE] = APPLICATION_ROOT_DIR . '/public/Zed/errorpage/5xx.html';
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

if (class_exists(TestifyConstants::class)) {
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
    'threedssvc.pay1.de', // trusted Payone domain
    'www.sofort.com', // trusted Payone domain
]);
$config[KernelConstants::STRICT_DOMAIN_REDIRECT] = true;

$config[HttpConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $config[HttpConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = true;
$config[HttpConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG]
    = $config[HttpConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG]
    = [
    'max_age' => 31536000,
    'include_sub_domains' => true,
    'preload' => true,
];

$config[CustomerConstants::CUSTOMER_SECURED_PATTERN] = '(^/login_check$|^(/en|/de)?/customer($|/)|^(/en|/de)?/wishlist($|/)|^(/en|/de)?/shopping-list($|/)|^(/en|/de)?/quote-request($|/)|^(/en|/de)?/comment($|/)|^(/en|/de)?/company(?!/register)($|/)|^(/en|/de)?/multi-cart($|/)|^(/en|/de)?/shared-cart($|/)|^(/en|/de)?/cart(?!/add)($|/)|^(/en|/de)?/checkout($|/))';
$config[CustomerConstants::CUSTOMER_ANONYMOUS_PATTERN] = '^/.*';

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
    getenv('SPRYKER_OAUTH_KEY_PRIVATE') ?: ''
) ?: null;
$config[OauthConstants::PUBLIC_KEY_PATH]
    = $config[OauthCryptographyConstants::PUBLIC_KEY_PATH]
    = str_replace(
        '__LINE__',
        PHP_EOL,
        getenv('SPRYKER_OAUTH_KEY_PUBLIC') ?: ''
    ) ?: null;
$config[OauthConstants::ENCRYPTION_KEY] = getenv('SPRYKER_OAUTH_ENCRYPTION_KEY') ?: null;
$config[OauthConstants::OAUTH_CLIENT_IDENTIFIER] = getenv('SPRYKER_OAUTH_CLIENT_IDENTIFIER') ?: null;
$config[OauthConstants::OAUTH_CLIENT_SECRET] = getenv('SPRYKER_OAUTH_CLIENT_SECRET') ?: null;

// >> ZED REQUEST

$config[UserConstants::USER_SYSTEM_USERS] = [
    'yves_system',
];
$config[AuthConstants::AUTH_DEFAULT_CREDENTIALS] = [
    'yves_system' => [
        'rules' => [
            [
                'bundle' => '*',
                'controller' => 'gateway',
                'action' => '*',
            ],
        ],
        'token' => getenv('SPRYKER_ZED_REQUEST_TOKEN') ?: '',
    ],
];

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
        'bundle' => 'authentication-merchant-portal-gui',
        'controller' => 'login',
        'action' => 'index',
        'type' => 'allow',
    ],
    [
        'bundle' => 'auth',
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
    = strtolower(getenv('SPRYKER_DB_ENGINE') ?: '') ?: PropelConfig::DB_ENGINE_PGSQL;
$config[PropelConstants::ZED_DB_HOST] = getenv('SPRYKER_DB_HOST');
$config[PropelConstants::ZED_DB_PORT] = getenv('SPRYKER_DB_PORT');
$config[PropelConstants::ZED_DB_USERNAME] = getenv('SPRYKER_DB_USERNAME');
$config[PropelConstants::ZED_DB_PASSWORD] = getenv('SPRYKER_DB_PASSWORD');
$config[PropelConstants::ZED_DB_DATABASE] = getenv('SPRYKER_DB_DATABASE');
$config[PropelConstants::ZED_DB_REPLICAS] = json_decode(getenv('SPRYKER_DB_REPLICAS') ?: '[]', true);
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false;

// >>> SEARCH

$config[SearchElasticsearchConstants::HOST] = getenv('SPRYKER_SEARCH_HOST');
$config[SearchElasticsearchConstants::TRANSPORT] = getenv('SPRYKER_SEARCH_PROTOCOL') ?: 'http';
$config[SearchElasticsearchConstants::PORT] = getenv('SPRYKER_SEARCH_PORT');
$config[SearchElasticsearchConstants::AUTH_HEADER] = getenv('SPRYKER_SEARCH_BASIC_AUTH') ?: null;

$config[SearchElasticsearchConstants::FULL_TEXT_BOOSTED_BOOSTING_VALUE] = 3;

// >>> STORAGE

$config[StorageConstants::STORAGE_KV_SOURCE] = strtolower(getenv('SPRYKER_KEY_VALUE_STORE_ENGINE')) ?: 'redis';
$config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION] = true;
$config[StorageRedisConstants::STORAGE_REDIS_PROTOCOL] = getenv('SPRYKER_KEY_VALUE_STORE_PROTOCOL') ?: 'tcp';
$config[StorageRedisConstants::STORAGE_REDIS_HOST] = getenv('SPRYKER_KEY_VALUE_STORE_HOST');
$config[StorageRedisConstants::STORAGE_REDIS_PORT] = getenv('SPRYKER_KEY_VALUE_STORE_PORT');
$config[StorageRedisConstants::STORAGE_REDIS_PASSWORD] = getenv('SPRYKER_KEY_VALUE_STORE_PASSWORD');
$config[StorageRedisConstants::STORAGE_REDIS_DATABASE] = getenv('SPRYKER_KEY_VALUE_STORE_NAMESPACE') ?: 1;

// >>> SESSION

$config[AuthConstants::SYSTEM_USER_SESSION_REDIS_LIFE_TIME] = 20;
$config[SessionRedisConstants::LOCKING_TIMEOUT_MILLISECONDS] = 0;
$config[SessionRedisConstants::LOCKING_RETRY_DELAY_MICROSECONDS] = 0;
$config[SessionRedisConstants::LOCKING_LOCK_TTL_MILLISECONDS] = 0;

// >>> SESSION FRONTEND

$config[SessionConstants::YVES_SESSION_COOKIE_NAME]
    = $config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN]
    = getenv('SPRYKER_FE_HOST');
$config[SessionConstants::YVES_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS_LOCKING;
$config[SessionRedisConstants::YVES_SESSION_REDIS_PROTOCOL] = getenv('SPRYKER_SESSION_FE_PROTOCOL') ?: 'tcp';
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

// >>> SESSION BACKOFFICE

$config[SessionConstants::ZED_SESSION_COOKIE_NAME]
    = $config[SessionConstants::ZED_SESSION_COOKIE_DOMAIN]
    = getenv('SPRYKER_BE_HOST');
$config[SessionConstants::ZED_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS;
$config[SessionRedisConstants::ZED_SESSION_REDIS_PROTOCOL] = getenv('SPRYKER_SESSION_BE_PROTOCOL') ?: 'tcp';
$config[SessionRedisConstants::ZED_SESSION_REDIS_HOST] = getenv('SPRYKER_SESSION_BE_HOST');
$config[SessionRedisConstants::ZED_SESSION_REDIS_PORT] = getenv('SPRYKER_SESSION_BE_PORT');
$config[SessionRedisConstants::ZED_SESSION_REDIS_PASSWORD] = getenv('SPRYKER_SESSION_BE_PASSWORD');
$config[SessionRedisConstants::ZED_SESSION_REDIS_DATABASE] = getenv('SPRYKER_SESSION_BE_NAMESPACE') ?: 2;

$config[SessionConstants::ZED_SESSION_TIME_TO_LIVE]
    = $config[SessionRedisConstants::ZED_SESSION_TIME_TO_LIVE]
    = SessionConfig::SESSION_LIFETIME_1_HOUR;
$config[SessionConstants::ZED_SESSION_COOKIE_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_BROWSER_SESSION;

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
foreach ($rabbitConnections as $key => $connection) {
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key] = $defaultConnection;
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_CONNECTION_NAME] = $key . '-connection';
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_STORE_NAMES] = [$key];
    foreach ($connection as $constant => $value) {
        $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][constant(RabbitMqEnv::class . '::' . $constant)] = $value;
    }
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_DEFAULT_CONNECTION] = $key === APPLICATION_STORE;
}

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
            getenv('SPRYKER_SCHEDULER_PORT')
        ),
    ],
];

$config[SchedulerJenkinsConstants::JENKINS_TEMPLATE_PATH] = getenv('SPRYKER_JENKINS_TEMPLATE_PATH') ?: null;

// >>> MAIL
$config[MailConstants::SMTP_HOST] = getenv('SPRYKER_SMTP_HOST') ?: null;
$config[MailConstants::SMTP_PORT] = getenv('SPRYKER_SMTP_PORT') ?: null;
$config[MailConstants::SMTP_ENCRYPTION] = getenv('SPRYKER_SMTP_ENCRYPTION') ?: null;
$config[MailConstants::SMTP_AUTH_MODE] = getenv('SPRYKER_SMTP_AUTH_MODE') ?: null;
$config[MailConstants::SMTP_USERNAME] = getenv('SPRYKER_SMTP_USERNAME') ?: null;
$config[MailConstants::SMTP_PASSWORD] = getenv('SPRYKER_SMTP_PASSWORD') ?: null;

$config[MailConstants::SENDER_EMAIL] = getenv('SPRYKER_MAIL_SENDER_EMAIL') ?: null;
$config[MailConstants::SENDER_NAME] = getenv('SPRYKER_MAIL_SENDER_NAME') ?: null;

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
$zedDefaultPort = $config[ZedRequestConstants::ZED_API_SSL_ENABLED] ? 443 : 80;
$zedPort = ((int)getenv('SPRYKER_ZED_PORT')) ?: $zedDefaultPort;
$config[ZedRequestConstants::HOST_ZED_API] = sprintf(
    '%s%s',
    getenv('SPRYKER_ZED_HOST') ?: 'not-configured-host',
    $zedPort !== $zedDefaultPort ? ':' . $zedPort : ''
);
$config[ZedRequestConstants::BASE_URL_ZED_API] = sprintf(
    'http://%s',
    $config[ZedRequestConstants::HOST_ZED_API]
);
$config[ZedRequestConstants::BASE_URL_SSL_ZED_API] = sprintf(
    'https://%s',
    $config[ZedRequestConstants::HOST_ZED_API]
);

// ----------------------------------------------------------------------------
// ------------------------------ BACKOFFICE ----------------------------------
// ----------------------------------------------------------------------------

$backofficePort = (int)(getenv('SPRYKER_BE_PORT')) ?: 443;
$config[ApplicationConstants::BASE_URL_ZED] = sprintf(
    'https://%s%s',
    getenv('SPRYKER_BE_HOST') ?: 'not-configured-host',
    $backofficePort !== 443 ? $backofficePort : ''
);

// ----------------------------------------------------------------------------
// ------------------------------ FRONTEND ------------------------------------
// ----------------------------------------------------------------------------

$yvesHost = $config[ApplicationConstants::HOST_YVES] = getenv('SPRYKER_FE_HOST') ?: 'not-configured-host';
$yvesPort = (int)(getenv('SPRYKER_FE_PORT')) ?: 443;

$config[ApplicationConstants::BASE_URL_YVES]
    = $config[CustomerConstants::BASE_URL_YVES]
    = $config[ProductManagementConstants::BASE_URL_YVES]
    = $config[NewsletterConstants::BASE_URL_YVES]
    = sprintf(
        'https://%s%s',
        $yvesHost,
        $yvesPort !== 443 ? ':' . $yvesPort : ''
    );

$config[ShopUiConstants::YVES_ASSETS_URL_PATTERN] = '/assets/' . (getenv('SPRYKER_BUILD_HASH') ?: 'current') . '/%theme%/';

// ----------------------------------------------------------------------------
// ------------------------------ API -----------------------------------------
// ----------------------------------------------------------------------------

$glueHost = getenv('SPRYKER_API_HOST') ?: 'localhost';
$gluePort = (int)(getenv('SPRYKER_API_PORT')) ?: 443;
$config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN]
    = sprintf(
        'https://%s%s',
        $glueHost,
        $gluePort !== 443 ? ':' . $gluePort : ''
    );

if (class_exists(TestifyConstants::class)) {
    $config[TestifyConstants::GLUE_APPLICATION_DOMAIN] = $config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN];
}

$config[GlueApplicationConstants::GLUE_APPLICATION_CORS_ALLOW_ORIGIN] = getenv('SPRYKER_GLUE_APPLICATION_CORS_ALLOW_ORIGIN') ?: '';

// ----------------------------------------------------------------------------
// ------------------------------ OMS -----------------------------------------
// ----------------------------------------------------------------------------

$config[OmsConstants::ACTIVE_PROCESSES] = [];
$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [];

// ----------------------------------------------------------------------------
// ------------------------------ PAYMENTS ------------------------------------
// ----------------------------------------------------------------------------

// >>> Taxes
$config[TaxConstants::DEFAULT_TAX_RATE] = 19;
