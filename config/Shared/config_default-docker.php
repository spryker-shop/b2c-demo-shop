<?php

use Monolog\Logger;
use Pyz\Shared\Console\ConsoleConstants;
use Pyz\Shared\Scheduler\SchedulerConfig;
use Spryker\Client\RabbitMq\Model\RabbitMqAdapter;
use Spryker\Glue\Log\Plugin\GlueLoggerConfigPlugin;
use Spryker\Service\FlysystemLocalFileSystem\Plugin\Flysystem\LocalFilesystemBuilderPlugin;
use Spryker\Shared\Acl\AclConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Application\Log\Config\SprykerLoggerConfig;
use Spryker\Shared\Auth\AuthConstants;
use Spryker\Shared\Cms\CmsConstants;
use Spryker\Shared\CmsGui\CmsGuiConstants;
use Spryker\Shared\Collector\CollectorConstants;
use Spryker\Shared\Config\ConfigConstants;
use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Shared\DocumentationGeneratorRestApi\DocumentationGeneratorRestApiConstants;
use Spryker\Shared\DummyPayment\DummyPaymentConfig;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebHtmlErrorRenderer;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\EventBehavior\EventBehaviorConstants;
use Spryker\Shared\FileManager\FileManagerConstants;
use Spryker\Shared\FileManagerGui\FileManagerGuiConstants;
use Spryker\Shared\FileSystem\FileSystemConstants;
use Spryker\Shared\Flysystem\FlysystemConstants;
use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Shared\Http\HttpConstants;
use Spryker\Shared\Kernel\ClassResolver\Cache\Provider\File;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Mail\MailConstants;
use Spryker\Shared\Newsletter\NewsletterConstants;
use Spryker\Shared\Oauth\OauthConstants;
use Spryker\Shared\OauthCustomerConnector\OauthCustomerConnectorConstants;
use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\ProductManagement\ProductManagementConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\PropelOrm\PropelOrmConstants;
use Spryker\Shared\PropelQueryBuilder\PropelQueryBuilderConstants;
use Spryker\Shared\Queue\QueueConfig;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Shared\Quote\QuoteConstants;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\Router\RouterConstants;
use Spryker\Shared\Sales\SalesConstants;
use Spryker\Shared\Scheduler\SchedulerConstants;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConfig;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConstants;
use Spryker\Shared\Search\SearchConstants;
use Spryker\Shared\SearchElasticsearch\SearchElasticsearchConstants;
use Spryker\Shared\SequenceNumber\SequenceNumberConstants;
use Spryker\Shared\Session\SessionConfig;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\SessionFile\SessionFileConstants;
use Spryker\Shared\SessionRedis\SessionRedisConfig;
use Spryker\Shared\SessionRedis\SessionRedisConstants;
use Spryker\Shared\Storage\StorageConstants;
use Spryker\Shared\StorageRedis\StorageRedisConstants;
use Spryker\Shared\Tax\TaxConstants;
use Spryker\Shared\Testify\TestifyConstants;
use Spryker\Shared\Twig\TwigConstants;
use Spryker\Shared\User\UserConstants;
use Spryker\Shared\WebProfiler\WebProfilerConstants;
use Spryker\Shared\ZedNavigation\ZedNavigationConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use Spryker\Yves\Log\Plugin\YvesLoggerConfigPlugin;
use Spryker\Zed\Log\Communication\Plugin\ZedLoggerConfigPlugin;
use Spryker\Zed\Propel\PropelConfig;
use SprykerEco\Shared\Loggly\LogglyConstants;
use SprykerShop\Shared\CalculationPage\CalculationPageConstants;
use SprykerShop\Shared\ErrorPage\ErrorPageConstants;
use Twig\Cache\FilesystemCache;

$CURRENT_STORE = Store::getInstance()->getStoreName();

/* ZED */
$config[ApplicationConstants::HOST_ZED] = getenv('SPRYKER_ZED_HOST');
$config[SessionConstants::ZED_SESSION_COOKIE_DOMAIN] = getenv('SPRYKER_BE_HOST');
$config[ApplicationConstants::ZED_TRUSTED_HOSTS]
    = $config[HttpConstants::ZED_TRUSTED_HOSTS]
    = [];
$config[ApplicationConstants::PORT_ZED] = getenv('SPRYKER_ZED_PORT') ? ':' . getenv('SPRYKER_ZED_PORT') : '';
$config[ApplicationConstants::PORT_SSL_ZED] = '';
$config[ApplicationConstants::BASE_URL_ZED] = sprintf(
    'http://%s%s',
    getenv('SPRYKER_BE_HOST'),
    getenv('SPRYKER_BE_PORT') ? ':' . getenv('SPRYKER_BE_PORT') : ''
);
$config[ApplicationConstants::BASE_URL_SSL_ZED] = sprintf(
    'https://%s%s',
    getenv('SPRYKER_BE_HOST'),
    getenv('SPRYKER_BE_PORT') ? ':' . getenv('SPRYKER_BE_PORT') : ''
);
$config[ZedRequestConstants::HOST_ZED_API] = sprintf(
    '%s:%d',
    getenv('SPRYKER_ZED_HOST'),
    getenv('SPRYKER_ZED_PORT')
);
$config[ZedRequestConstants::BASE_URL_ZED_API] = sprintf(
    'http://%s',
    $config[ZedRequestConstants::HOST_ZED_API]
);
$config[ZedRequestConstants::BASE_URL_SSL_ZED_API] = sprintf(
    'https://%s',
    $config[ZedRequestConstants::HOST_ZED_API]
);

$config[TwigConstants::ZED_TWIG_OPTIONS] = [
    'cache' => new FilesystemCache(
        sprintf(
            '%s/data/%s/cache/ZED/twig',
            APPLICATION_ROOT_DIR,
            $CURRENT_STORE
        ),
        FilesystemCache::FORCE_BYTECODE_INVALIDATION
    ),
];
$config[TwigConstants::ZED_PATH_CACHE_FILE] = sprintf(
    '%s/data/%s/cache/ZED/twig/.pathCache',
    APPLICATION_ROOT_DIR,
    $CURRENT_STORE
);

// The cache should always be activated. Refresh/build with CLI command: vendor/bin/console application:build-navigation-cache
$config[ZedNavigationConstants::ZED_NAVIGATION_CACHE_ENABLED] = true;

$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_NAME] = 'XDEBUG_SESSION';
$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = true;
$config[ZedRequestConstants::SET_REPEAT_DATA] = true;
$config[ZedRequestConstants::YVES_REQUEST_REPEAT_DATA_PATH] = APPLICATION_ROOT_DIR . '/data/' . Store::getInstance()->getStoreName() . '/' . APPLICATION_ENV . '/yves-requests';

$config[ZedRequestConstants::ZED_API_SSL_ENABLED] = false;
$config[ApplicationConstants::ZED_SSL_ENABLED] = false;
$config[SessionConstants::ZED_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');
$config[ApplicationConstants::ZED_SSL_EXCLUDED] = ['heartbeat/index'];

$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::ZED_ERROR_PAGE] = APPLICATION_ROOT_DIR . '/public/Zed/errorpage/error.html';
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebHtmlErrorRenderer::class;
$config[ErrorHandlerConstants::ERROR_LEVEL] = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED;

$config[KernelConstants::DEPENDENCY_INJECTOR_ZED] = [
    'Payment' => [
        'DummyPayment',
    ],
    'Oms' => [
        'DummyPayment',
    ],
];
/* End ZED */

// ---------- Routing
$config[RouterConstants::YVES_IS_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');
$config[RouterConstants::ZED_IS_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');

/* Backend */
$config[KernelConstants::SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker';
$config[ApplicationConstants::PROJECT_TIMEZONE] = 'UTC';
$config[ApplicationConstants::ENABLE_WEB_PROFILER] = false;
$config[KernelConstants::STORE_PREFIX] = 'DEV';
$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG] = true;
$config[WebProfilerConstants::ENABLE_WEB_PROFILER]
    = $config[ConfigConstants::ENABLE_WEB_PROFILER]
    = true;

$ENVIRONMENT_PREFIX = '';
$config[SequenceNumberConstants::ENVIRONMENT_PREFIX] = $ENVIRONMENT_PREFIX;
$config[SalesConstants::ENVIRONMENT_PREFIX] = $ENVIRONMENT_PREFIX;

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

$config[UserConstants::USER_SYSTEM_USERS] = [
    'yves_system',
];
// For a better performance you can turn off Zed authentication
$config[AuthConstants::AUTH_DEFAULT_CREDENTIALS] = [
    'yves_system' => [
        'rules' => [
            [
                'bundle' => '*',
                'controller' => 'gateway',
                'action' => '*',
            ],
        ],
        // Please replace this token for your project
        'token' => 'JDJ5JDEwJFE0cXBwYnVVTTV6YVZXSnVmM2l1UWVhRE94WkQ4UjBUeHBEWTNHZlFRTEd4U2F6QVBqejQ2',
    ],
];

// ACL: Allow or disallow of urls for Zed Admin GUI for ALL users
$config[AclConstants::ACL_DEFAULT_RULES] = [
    [
        'bundle' => 'auth',
        'controller' => 'login',
        'action' => 'index',
        'type' => 'allow',
    ],
    [
        'bundle' => 'auth',
        'controller' => 'login',
        'action' => 'check',
        'type' => 'allow',
    ],
    [
        'bundle' => 'auth',
        'controller' => 'password',
        'action' => 'reset',
        'type' => 'allow',
    ],
    [
        'bundle' => 'auth',
        'controller' => 'password',
        'action' => 'reset-request',
        'type' => 'allow',
    ],
    [
        'bundle' => 'acl',
        'controller' => 'index',
        'action' => 'denied',
        'type' => 'allow',
    ],
    [
        'bundle' => 'heartbeat',
        'controller' => 'index',
        'action' => 'index',
        'type' => 'allow',
    ],
    [
        'bundle' => 'auth',
        'controller' => 'logout',
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
    [
        'bundle' => 'auth',
        'controller' => '*',
        'action' => '*',
        'type' => 'allow',
    ],
    [
        'bundle' => 'heartbeat',
        'controller' => 'heartbeat',
        'action' => 'index',
        'type' => 'allow',
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
$config[AclConstants::ACL_USER_RULE_WHITELIST][] = [
    'bundle' => 'wdt',
    'controller' => '*',
    'action' => '*',
    'type' => 'allow',
];

$config[KernelConstants::AUTO_LOADER_CACHE_FILE_NO_LOCK] = false;
$config[KernelConstants::AUTO_LOADER_UNRESOLVABLE_CACHE_PROVIDER] = File::class;

$config[OmsConstants::ACTIVE_PROCESSES] = [
    'DummyPayment01',
];
$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    DummyPaymentConfig::PAYMENT_METHOD_INVOICE => 'DummyPayment01',
    DummyPaymentConfig::PAYMENT_METHOD_CREDIT_CARD => 'DummyPayment01',
];

$config[EventConstants::LOGGER_ACTIVE] = true;

$config[EventBehaviorConstants::EVENT_BEHAVIOR_TRIGGERING_ACTIVE] = true;

$config[TaxConstants::DEFAULT_TAX_RATE] = 19;

$config[FileSystemConstants::FILESYSTEM_SERVICE] = [];
$config[FlysystemConstants::FILESYSTEM_SERVICE] = $config[FileSystemConstants::FILESYSTEM_SERVICE];
$config[CmsGuiConstants::CMS_PAGE_PREVIEW_URI] = '/en/cms/preview/%d';

$config[LogglyConstants::TOKEN] = 'loggly-token:sample:123456';

$config[FileManagerConstants::STORAGE_NAME] = 'files';
$config[FileManagerGuiConstants::DEFAULT_FILE_MAX_SIZE] = '10M';

$config[FileSystemConstants::FILESYSTEM_SERVICE] = [
    'files' => [
        'sprykerAdapterClass' => LocalFilesystemBuilderPlugin::class,
        'root' => APPLICATION_ROOT_DIR . '/data/DE/media/',
        'path' => 'files/',
    ],
];

//Check how to generate https://oauth2.thephpleague.com/installation/
$config[OauthConstants::PRIVATE_KEY_PATH] = 'file://' . APPLICATION_ROOT_DIR . '/config/Zed/dev_only_private.key';
$config[OauthConstants::PUBLIC_KEY_PATH] = 'file://' . APPLICATION_ROOT_DIR . '/config/Zed/dev_only_public.key';
$config[OauthConstants::ENCRYPTION_KEY] = 'lxZFUEsBCJ2Yb14IF2ygAHI5N4+ZAUXXaSeeJm6+twsUmIen';

$config[OauthCustomerConnectorConstants::OAUTH_CLIENT_IDENTIFIER] = 'frontend';
$config[OauthCustomerConnectorConstants::OAUTH_CLIENT_SECRET] = 'abc123';

$config[QuoteConstants::GUEST_QUOTE_LIFETIME] = 'P01M';

$config[MailConstants::MAILCATCHER_GUI] = sprintf('http://%s:1080', $config[ApplicationConstants::HOST_ZED]);
/* End Backend */

/* Yves */
$config[ApplicationConstants::HOST_YVES] = getenv('SPRYKER_FE_HOST');
$config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN] = $config[ApplicationConstants::HOST_YVES];
$config[ApplicationConstants::YVES_TRUSTED_HOSTS]
    = $config[HttpConstants::YVES_TRUSTED_HOSTS]
    = [];
$config[ApplicationConstants::PORT_YVES] = getenv('SPRYKER_FE_PORT');
$config[ApplicationConstants::PORT_SSL_YVES] = '';
$config[ApplicationConstants::BASE_URL_YVES] = sprintf(
    'http://%s%s',
    $config[ApplicationConstants::HOST_YVES],
    getenv('SPRYKER_FE_PORT') ? ':' . getenv('SPRYKER_FE_PORT') : ''
);
$config[ApplicationConstants::BASE_URL_SSL_YVES] = sprintf(
    'https://%s%s',
    $config[ApplicationConstants::HOST_YVES],
    $config[ApplicationConstants::PORT_SSL_YVES]
);
$config[ProductManagementConstants::BASE_URL_YVES] = $config[ApplicationConstants::BASE_URL_YVES];
$config[NewsletterConstants::BASE_URL_YVES] = $config[ApplicationConstants::BASE_URL_YVES];
$config[CustomerConstants::BASE_URL_YVES] = $config[ApplicationConstants::BASE_URL_YVES];

$config[TwigConstants::YVES_TWIG_OPTIONS] = [
    'cache' => new FilesystemCache(
        sprintf(
            '%s/data/%s/cache/YVES/twig',
            APPLICATION_ROOT_DIR,
            $CURRENT_STORE
        ),
        FilesystemCache::FORCE_BYTECODE_INVALIDATION
    ),
];
$config[TwigConstants::YVES_PATH_CACHE_FILE] = sprintf(
    '%s/data/%s/cache/YVES/twig/.pathCache',
    APPLICATION_ROOT_DIR,
    $CURRENT_STORE
);

$config[ApplicationConstants::YVES_COOKIE_DEVICE_ID_NAME] = 'did';
$config[ApplicationConstants::YVES_COOKIE_DEVICE_ID_VALID_FOR] = '+5 year';
$config[ApplicationConstants::YVES_COOKIE_VISITOR_ID_NAME] = 'vid';
$config[ApplicationConstants::YVES_COOKIE_VISITOR_ID_VALID_FOR] = '+30 minute';

$HSTS_ENABLED = false;
$config[ApplicationConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $config[HttpConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $HSTS_ENABLED;
$config[ApplicationConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $config[HttpConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $HSTS_ENABLED;
$HSTS_CONFIG = [
    'max_age' => 31536000,
    'include_sub_domains' => true,
    'preload' => true,
];
$config[ApplicationConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG]
    = $config[HttpConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG]
    = $HSTS_CONFIG;
$config[ApplicationConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG]
    = $config[HttpConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG]
    = $HSTS_CONFIG;

$config[SessionConstants::YVES_SSL_ENABLED] = false;
$config[ApplicationConstants::YVES_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');
$config[SessionConstants::YVES_SSL_ENABLED] = (bool)getenv('SPRYKER_SSL_ENABLE');
$config[ApplicationConstants::YVES_SSL_EXCLUDED] = [
    'heartbeat' => '/heartbeat',
];

$YVES_THEME = 'default';
$config[TwigConstants::YVES_THEME] = $YVES_THEME;
$config[CmsConstants::YVES_THEME] = $YVES_THEME;

$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::YVES_ERROR_PAGE] = APPLICATION_ROOT_DIR . '/public/Yves/errorpage/error.html';
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebHtmlErrorRenderer::class;
// Due to some deprecation notices we silence all deprecations for the time being
// To only log e.g. deprecations instead of throwing exceptions here use
//$config[ErrorHandlerConstants::ERROR_LEVEL] = E_ALL
//$config[ErrorHandlerConstants::ERROR_LEVEL_LOG_ONLY] = E_DEPRECATED | E_USER_DEPRECATED;

$config[KernelConstants::DEPENDENCY_INJECTOR_YVES] = [
    'CheckoutPage' => [
        'DummyPayment',
    ],
];

$config[ApplicationConstants::BASE_URL_STATIC_ASSETS] = $config[ApplicationConstants::BASE_URL_YVES];
$config[ApplicationConstants::BASE_URL_STATIC_MEDIA] = $config[ApplicationConstants::BASE_URL_YVES];
$config[ApplicationConstants::BASE_URL_SSL_STATIC_ASSETS] = $config[ApplicationConstants::BASE_URL_SSL_YVES];
$config[ApplicationConstants::BASE_URL_SSL_STATIC_MEDIA] = $config[ApplicationConstants::BASE_URL_SSL_YVES];
/* End Yves */

/* Glue */
$protocol = getenv('SPRYKER_SSL_ENABLE') ? 'https' : 'http';
$glueHost = getenv('SPRYKER_API_HOST') ?: 'localhost';
$gluePort = (int)(getenv('SPRYKER_API_PORT') ?: 80);
$config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN] = sprintf(
    '%s://%s%s',
    $protocol,
    $glueHost, // TODO: refactor GlueControllerFilterPluginTest to avoid the knowledge of GLUE_APPLICATION_DOMAIN in Zed
    $gluePort !== 80 ? ':' . $gluePort : ''
);
$config[GlueApplicationConstants::GLUE_APPLICATION_REST_DEBUG] = false;
$config[GlueApplicationConstants::GLUE_APPLICATION_CORS_ALLOW_ORIGIN] = getenv('SPRYKER_GLUE_APPLICATION_CORS_ALLOW_ORIGIN') ?: '';

$config[TestifyConstants::GLUE_APPLICATION_DOMAIN] = $config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN];
$config[TestifyConstants::GLUE_OPEN_API_SCHEMA] = APPLICATION_SOURCE_DIR . '/Generated/Glue/Specification/spryker_rest_api.schema.yml';
/* End Glue */

/* Database */
$config[PropelConstants::ZED_DB_ENGINE_MYSQL] = PropelConfig::DB_ENGINE_MYSQL;
$config[PropelConstants::ZED_DB_ENGINE_PGSQL] = PropelConfig::DB_ENGINE_PGSQL;
$config[PropelConstants::ZED_DB_SUPPORTED_ENGINES] = [
    PropelConfig::DB_ENGINE_MYSQL => 'MySql',
    PropelConfig::DB_ENGINE_PGSQL => 'PostgreSql',
];
$config[PropelConstants::SCHEMA_FILE_PATH_PATTERN] = APPLICATION_VENDOR_DIR . '/*/*/src/*/Zed/*/Persistence/Propel/Schema/';
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false;
$config[PropelConstants::PROPEL_DEBUG] = false;

$config[PropelOrmConstants::PROPEL_SHOW_EXTENDED_EXCEPTION] = true;
$config[PropelConstants::ZED_DB_USERNAME] = getenv('SPRYKER_DB_USERNAME');
$config[PropelConstants::ZED_DB_PASSWORD] = getenv('SPRYKER_DB_PASSWORD');
$config[PropelConstants::ZED_DB_HOST] = getenv('SPRYKER_DB_HOST');
$config[PropelConstants::ZED_DB_PORT] = getenv('SPRYKER_DB_PORT');
$config[PropelConstants::ZED_DB_ENGINE] = strtolower(getenv('SPRYKER_DB_ENGINE') ?: '') ?: PropelConfig::DB_ENGINE_PGSQL;
$config[PropelQueryBuilderConstants::ZED_DB_ENGINE] = $config[PropelConstants::ZED_DB_ENGINE];
$config[PropelConstants::ZED_DB_DATABASE] = getenv('SPRYKER_DB_DATABASE');
/* End Database */

/* Job runner */
// ---------- Scheduler
$config[SchedulerConstants::ENABLED_SCHEDULERS] = [
    SchedulerConfig::SCHEDULER_JENKINS,
];
$config[SchedulerJenkinsConstants::JENKINS_CONFIGURATION] = [
    SchedulerConfig::SCHEDULER_JENKINS => [
        SchedulerJenkinsConfig::SCHEDULER_JENKINS_BASE_URL => 'http://' . getenv('SPRYKER_SCHEDULER_HOST') . ':' . getenv('SPRYKER_SCHEDULER_PORT') . '/',
    ],
];

$config[SchedulerJenkinsConstants::JENKINS_TEMPLATE_PATH] = getenv('SPRYKER_JENKINS_TEMPLATE_PATH');
/* End Job runner */

/* Broker */
$config[QueueConstants::QUEUE_SERVER_ID] = (gethostname()) ?: php_uname('n');
$config[QueueConstants::QUEUE_WORKER_INTERVAL_MILLISECONDS] = 1000;
$config[QueueConstants::QUEUE_PROCESS_TRIGGER_INTERVAL_MICROSECONDS] = 1001;
$config[QueueConstants::QUEUE_WORKER_MAX_THRESHOLD_SECONDS] = 59;
$config[QueueConstants::QUEUE_WORKER_LOG_ACTIVE] = false;

/*
 * Queues can have different adapters and maximum worker number
 * QUEUE_ADAPTER_CONFIGURATION can have the array like this as an example:
 *
 *   'mailQueue' => [
 *       QueueConfig::CONFIG_QUEUE_ADAPTER => \Spryker\Client\RabbitMq\Model\RabbitMqAdapter::class,
 *       QueueConfig::CONFIG_MAX_WORKER_NUMBER => 5
 *   ],
 *
 *
 */
$config[QueueConstants::QUEUE_ADAPTER_CONFIGURATION_DEFAULT] = [
    QueueConfig::CONFIG_QUEUE_ADAPTER => RabbitMqAdapter::class,
    QueueConfig::CONFIG_MAX_WORKER_NUMBER => 1,
];

$config[QueueConstants::QUEUE_ADAPTER_CONFIGURATION] = [
    EventConstants::EVENT_QUEUE => [
        QueueConfig::CONFIG_QUEUE_ADAPTER => RabbitMqAdapter::class,
        QueueConfig::CONFIG_MAX_WORKER_NUMBER => 1,
    ],
];

$config[LogglyConstants::QUEUE_NAME] = 'loggly-log-queue';
$config[LogglyConstants::ERROR_QUEUE_NAME] = 'loggly-log-queue.error';

$config[RabbitMqEnv::RABBITMQ_API_HOST] = getenv('SPRYKER_BROKER_API_HOST');
$config[RabbitMqEnv::RABBITMQ_API_PORT] = getenv('SPRYKER_BROKER_API_PORT');
$config[RabbitMqEnv::RABBITMQ_API_USERNAME] = getenv('SPRYKER_BROKER_API_USERNAME');
$config[RabbitMqEnv::RABBITMQ_API_PASSWORD] = getenv('SPRYKER_BROKER_API_PASSWORD');
$config[RabbitMqEnv::RABBITMQ_API_VIRTUAL_HOST] = getenv('SPRYKER_BROKER_NAMESPACE');

$rabbitConnections = json_decode(getenv('SPRYKER_BROKER_CONNECTIONS') ?: '[]', true);

$config[RabbitMqEnv::RABBITMQ_CONNECTIONS] = [];

foreach ($rabbitConnections as $key => $connection) {
    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key] = [];
    foreach ($connection as $constant => $value) {
        $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][constant(RabbitMqEnv::class . '::' . $constant)] = $value;
    }

    $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_DEFAULT_CONNECTION] =
        $config[RabbitMqEnv::RABBITMQ_API_VIRTUAL_HOST] === $config[RabbitMqEnv::RABBITMQ_CONNECTIONS][$key][RabbitMqEnv::RABBITMQ_VIRTUAL_HOST];
}
/* End Broker */

/* Search service */
$config[SearchConstants::ELASTICA_PARAMETER__HOST]
    = $config[SearchElasticsearchConstants::HOST]
    = getenv('SPRYKER_SEARCH_HOST');
$ELASTICA_TRANSPORT_PROTOCOL = 'http';
$config[SearchConstants::ELASTICA_PARAMETER__TRANSPORT]
    = $config[SearchElasticsearchConstants::TRANSPORT]
    = $ELASTICA_TRANSPORT_PROTOCOL;
$config[SearchConstants::ELASTICA_PARAMETER__PORT]
    = $config[SearchElasticsearchConstants::PORT]
    = getenv('SPRYKER_SEARCH_PORT');
$ELASTICA_AUTH_HEADER = null;
$config[SearchConstants::ELASTICA_PARAMETER__AUTH_HEADER]
    = $config[SearchElasticsearchConstants::AUTH_HEADER]
    = $ELASTICA_AUTH_HEADER;
$config[CollectorConstants::ELASTICA_PARAMETER__INDEX_NAME] = getenv('SPRYKER_SEARCH_NAMESPACE');
$ELASTICA_DOCUMENT_TYPE = 'page';
$config[CollectorConstants::ELASTICA_PARAMETER__DOCUMENT_TYPE] = $ELASTICA_DOCUMENT_TYPE;
$ELASTICA_PARAMETER__EXTRA = [];
$config[SearchConstants::ELASTICA_PARAMETER__EXTRA]
    = $config[SearchElasticsearchConstants::EXTRA]
    = $ELASTICA_PARAMETER__EXTRA;
$config[SearchConstants::FULL_TEXT_BOOSTED_BOOSTING_VALUE]
    = $config[SearchElasticsearchConstants::FULL_TEXT_BOOSTED_BOOSTING_VALUE]
    = 3;
/* End Search service */

// ---------- KV storage
$config[StorageConstants::STORAGE_KV_SOURCE] = strtolower(getenv('SPRYKER_KEY_VALUE_STORE_ENGINE'));

/**
 * Data source names are used exclusively when set, e.g. no other Redis storage configuration will be used for the client.
 *
 * Example:
 *   $config[StorageRedisConstants::STORAGE_REDIS_DATA_SOURCE_NAMES] = ['tcp://127.0.0.1:10009', 'tcp://10.0.0.1:6379']
 */
//$config[StorageRedisConstants::STORAGE_REDIS_DATA_SOURCE_NAMES] = [];

$config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION] = true;
$config[StorageRedisConstants::STORAGE_REDIS_PROTOCOL] = 'tcp';
$config[StorageRedisConstants::STORAGE_REDIS_HOST] = getenv('SPRYKER_KEY_VALUE_STORE_HOST');
$config[StorageRedisConstants::STORAGE_REDIS_PORT] = getenv('SPRYKER_KEY_VALUE_STORE_PORT');
$config[StorageRedisConstants::STORAGE_REDIS_PASSWORD] = false;
$config[StorageRedisConstants::STORAGE_REDIS_DATABASE] = getenv('SPRYKER_KEY_VALUE_STORE_NAMESPACE');

// ---------- Session
$config[SessionConstants::YVES_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS_LOCKING;
$config[SessionConstants::YVES_SESSION_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_1_HOUR;
$config[SessionRedisConstants::YVES_SESSION_TIME_TO_LIVE] = $config[SessionConstants::YVES_SESSION_TIME_TO_LIVE];
$config[SessionFileConstants::YVES_SESSION_TIME_TO_LIVE] = $config[SessionConstants::YVES_SESSION_TIME_TO_LIVE];
$config[SessionConstants::YVES_SESSION_COOKIE_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_0_5_HOUR;
$config[SessionFileConstants::YVES_SESSION_FILE_PATH] = session_save_path();
$config[SessionConstants::YVES_SESSION_PERSISTENT_CONNECTION] = $config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION];
$config[SessionConstants::ZED_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS;
$config[SessionConstants::ZED_SESSION_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_1_HOUR;
$config[SessionRedisConstants::ZED_SESSION_TIME_TO_LIVE] = $config[SessionConstants::ZED_SESSION_TIME_TO_LIVE];
$config[SessionFileConstants::ZED_SESSION_TIME_TO_LIVE] = $config[SessionConstants::ZED_SESSION_TIME_TO_LIVE];
$config[SessionConstants::ZED_SESSION_COOKIE_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_BROWSER_SESSION;
$config[SessionFileConstants::ZED_SESSION_FILE_PATH] = session_save_path();
$config[SessionConstants::ZED_SESSION_PERSISTENT_CONNECTION] = $config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION];
$config[SessionRedisConstants::LOCKING_TIMEOUT_MILLISECONDS] = 0;
$config[SessionRedisConstants::LOCKING_RETRY_DELAY_MICROSECONDS] = 0;
$config[SessionRedisConstants::LOCKING_LOCK_TTL_MILLISECONDS] = 0;

/**
 * Data source names are used exclusively when set, e.g. no other Redis session configuration will be used for the client.
 *
 * Example:
 *   $config[SessionRedisConstants::YVES_SESSION_REDIS_DATA_SOURCE_NAMES] = ['tcp://127.0.0.1:10009', 'tcp://10.0.0.1:6379']
 */
//$config[SessionRedisConstants::YVES_SESSION_REDIS_DATA_SOURCE_NAMES] = [];

$config[SessionRedisConstants::YVES_SESSION_REDIS_PROTOCOL] = 'tcp';
$config[SessionRedisConstants::YVES_SESSION_REDIS_HOST] = getenv('SPRYKER_SESSION_FE_HOST');
$config[SessionRedisConstants::YVES_SESSION_REDIS_PORT] = getenv('SPRYKER_SESSION_FE_PORT');
$config[SessionRedisConstants::YVES_SESSION_REDIS_PASSWORD] = false;
$config[SessionRedisConstants::YVES_SESSION_REDIS_DATABASE] = getenv('SPRYKER_SESSION_FE_NAMESPACE');

/**
 * Data source names are used exclusively when set, e.g. no other Redis session configuration will be used for the client.
 *
 * Example:
 *   $config[SessionRedisConstants::ZED_SESSION_REDIS_DATA_SOURCE_NAMES] = ['tcp://127.0.0.1:10009', 'tcp://10.0.0.1:6379']
 */
//$config[SessionRedisConstants::ZED_SESSION_REDIS_DATA_SOURCE_NAMES] = [];

$config[SessionRedisConstants::ZED_SESSION_REDIS_PROTOCOL] = 'tcp';
$config[SessionRedisConstants::ZED_SESSION_REDIS_HOST] = getenv('SPRYKER_SESSION_BE_HOST');
$config[SessionRedisConstants::ZED_SESSION_REDIS_PORT] = getenv('SPRYKER_SESSION_BE_PORT');
$config[SessionRedisConstants::ZED_SESSION_REDIS_PASSWORD] = false;
$config[SessionRedisConstants::ZED_SESSION_REDIS_DATABASE] = getenv('SPRYKER_SESSION_BE_NAMESPACE');

/* Mail */
$config[MailConstants::SMTP_HOST] = getenv('SPRYKER_SMTP_HOST');
$config[MailConstants::SMTP_PORT] = getenv('SPRYKER_SMTP_PORT');
/* End Mail */

/* Logging */
$config[LogConstants::LOGGER_CONFIG] = SprykerLoggerConfig::class;
$config[LogConstants::LOG_FILE_PATH] = (getenv('SPRYKER_LOG_DIRECTORY') ?: APPLICATION_ROOT_DIR . '/data') . '/logs';

$config[LogConstants::LOGGER_CONFIG_ZED] = ZedLoggerConfigPlugin::class;
$config[LogConstants::LOGGER_CONFIG_YVES] = YvesLoggerConfigPlugin::class;
$config[LogConstants::LOGGER_CONFIG_GLUE] = GlueLoggerConfigPlugin::class;

$config[LogConstants::LOG_LEVEL] = Logger::INFO;

$config[LogConstants::LOG_SANITIZE_FIELDS] = [
    'password',
];

$config[LogConstants::LOG_QUEUE_NAME] = 'log-queue';
$config[LogConstants::LOG_ERROR_QUEUE_NAME] = 'error-log-queue';

$logDir = (getenv('SPRYKER_LOG_DIRECTORY') ?: APPLICATION_ROOT_DIR . '/data') . '/' . APPLICATION_STORE;

$config[QueueConstants::QUEUE_WORKER_OUTPUT_FILE_NAME] = $logDir . '/ZED/queue.log';
$config[PropelConstants::LOG_FILE_PATH] = $logDir . '/ZED/propel.log';

$config[LogConstants::LOG_FILE_PATH_YVES] = $logDir . '/YVES/application.log';
$config[LogConstants::LOG_FILE_PATH_ZED] = $logDir . '/ZED/application.log';
$config[LogConstants::LOG_FILE_PATH_GLUE] = $logDir . '/GLUE/application.log';

$config[LogConstants::EXCEPTION_LOG_FILE_PATH_YVES] = $logDir . '/YVES/exception.log';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_ZED] = $logDir . '/ZED/exception.log';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_GLUE] = $logDir . '/GLUE/exception.log';
/* End Logging */

// ----------- Kernel test
$config[KernelConstants::ENABLE_CONTAINER_OVERRIDING] = (bool)getenv('SPRYKER_TESTING_ENABLED');

// ----------- Calculation page
$config[CalculationPageConstants::ENABLE_CART_DEBUG] = (bool)getenv('SPRYKER_DEBUG_ENABLED');

// ----------- Error page
$config[ErrorPageConstants::ENABLE_ERROR_404_STACK_TRACE] = (bool)getenv('SPRYKER_DEBUG_ENABLED');

$config[ApplicationConstants::ENABLE_PRETTY_ERROR_HANDLER] = (bool)getenv('SPRYKER_DEBUG_ENABLED');

// ----------- Console
$config[ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS] = (bool)getenv('DEVELOPMENT_CONSOLE_COMMANDS');

// ----------- Documentation generator
$config[DocumentationGeneratorRestApiConstants::ENABLE_REST_API_DOCUMENTATION_GENERATION] = true;

// ----------- HTTP Security
$config[KernelConstants::DOMAIN_WHITELIST] = [
    $config[ApplicationConstants::HOST_YVES],
    $config[ApplicationConstants::HOST_ZED],
];
