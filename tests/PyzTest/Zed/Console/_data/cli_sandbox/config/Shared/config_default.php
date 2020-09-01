<?php

use Monolog\Logger;
use Spryker\Shared\Acl\AclConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Auth\AuthConstants;
use Spryker\Shared\Cms\CmsConstants;
use Spryker\Shared\Collector\CollectorConstants;
use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Shared\DummyPayment\DummyPaymentConfig;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebHtmlErrorRenderer;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Newsletter\NewsletterConstants;
use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Shared\Sales\SalesConstants;
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
use Spryker\Shared\Twig\TwigConstants;
use Spryker\Shared\User\UserConstants;
use Spryker\Shared\ZedNavigation\ZedNavigationConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use Spryker\Zed\Oms\OmsConfig;

$config[KernelConstants::PROJECT_NAMESPACES] = [
    'Pyz',
];

$config[KernelConstants::CORE_NAMESPACES] = [
    'SprykerShop',
    'SprykerEco',
    'Spryker',
];

$config[KernelConstants::PROJECT_NAMESPACE] = 'Pyz';

$config[TwigConstants::YVES_PATH_CACHE_FILE] = sprintf('%s/data/%s/cache/YVES/twig/.pathCache', APPLICATION_ROOT_DIR, APPLICATION_STORE);
$config[TwigConstants::ZED_PATH_CACHE_FILE] = sprintf('%s/data/%s/cache/ZED/twig/.pathCache', APPLICATION_ROOT_DIR, APPLICATION_STORE);

$config[TwigConstants::YVES_PATH_CACHE_FILE] = APPLICATION_ROOT_DIR . '/data/' . Store::getInstance()->getStoreName() . '/cache/Yves/twig/.pathCache';
$config[TwigConstants::ZED_PATH_CACHE_FILE] = APPLICATION_ROOT_DIR . '/data/' . Store::getInstance()->getStoreName() . '/cache/Zed/twig/.pathCache';

/**
 * Elasticsearch settings
 */
$config[ApplicationConstants::ELASTICA_PARAMETER__HOST]
    = $config[SearchElasticsearchConstants::HOST]
    = 'localhost';
$config[ApplicationConstants::ELASTICA_PARAMETER__TRANSPORT]
    = $config[SearchElasticsearchConstants::TRANSPORT]
    = 'http';
$config[ApplicationConstants::ELASTICA_PARAMETER__PORT]
    = $config[SearchElasticsearchConstants::PORT]
    = '10005';
$config[ApplicationConstants::ELASTICA_PARAMETER__AUTH_HEADER]
    = $config[SearchElasticsearchConstants::AUTH_HEADER]
    = '';
$config[ApplicationConstants::ELASTICA_PARAMETER__INDEX_NAME]
    = $config[CollectorConstants::ELASTICA_PARAMETER__INDEX_NAME]
    = null; // Store related config
$config[ApplicationConstants::ELASTICA_PARAMETER__DOCUMENT_TYPE]
    = $config[CollectorConstants::ELASTICA_PARAMETER__DOCUMENT_TYPE]
    = 'page';

/**
 * Page search settings
 */
$config[SearchConstants::FULL_TEXT_BOOSTED_BOOSTING_VALUE]
    = $config[SearchElasticsearchConstants::FULL_TEXT_BOOSTED_BOOSTING_VALUE] = 3;

/**
 * Hostname(s) for Yves - Shop frontend
 * In production you probably use a CDN for static content
 */
$config[ApplicationConstants::HOST_YVES]
    = $config[NewsletterConstants::HOST_YVES]
    = $config[ApplicationConstants::HOST_STATIC_ASSETS]
    = $config[ApplicationConstants::HOST_STATIC_MEDIA]
    = $config[ApplicationConstants::HOST_SSL_YVES]
    = $config[ApplicationConstants::HOST_SSL_STATIC_ASSETS]
    = $config[ApplicationConstants::HOST_SSL_STATIC_MEDIA]
    = 'www.de.project.local';
$config[CustomerConstants::BASE_URL_YVES] = 'www.de.project.local';

/**
 * Hostname(s) for Zed - Shop frontend
 * In production you probably use HTTPS for Zed
 */
$config[ApplicationConstants::HOST_ZED_GUI]
    = $config[ApplicationConstants::HOST_ZED_API]
    = $config[ApplicationConstants::HOST_SSL_ZED_GUI]
    = $config[ApplicationConstants::HOST_SSL_ZED_API]
    = 'zed.de.project.local';

$config[ApplicationConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED] =
    $config[ApplicationConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED] = false;

$config[ApplicationConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG] =
    $config[ApplicationConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_CONFIG] = [
    'max_age' => 31536000,
    'include_sub_domains' => true,
    'preload' => true,
    ];

$config[LogConstants::LOG_LEVEL] = Logger::INFO;

$config[ZedRequestConstants::TRANSFER_USERNAME] = 'yves';
$config[ZedRequestConstants::TRANSFER_PASSWORD] = 'o7&bg=Fz;nSslHBC';

$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = false;
$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_NAME] = 'XDEBUG_SESSION';

$config[KernelConstants::SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker/spryker/Bundles';

$config[StorageConstants::STORAGE_KV_SOURCE] = 'redis';
$config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION] = true;
$config[StorageRedisConstants::STORAGE_REDIS_PROTOCOL] = 'tcp';
$config[StorageRedisConstants::STORAGE_REDIS_HOST] = '127.0.0.1';
$config[StorageRedisConstants::STORAGE_REDIS_PORT] = 10009;
$config[StorageRedisConstants::STORAGE_REDIS_PASSWORD] = false;
$config[StorageRedisConstants::STORAGE_REDIS_DATABASE] = 0;

$config[SessionConstants::YVES_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS_LOCKING;
$config[SessionConstants::YVES_SESSION_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_1_HOUR;
$config[SessionRedisConstants::YVES_SESSION_TIME_TO_LIVE] = $config[SessionConstants::YVES_SESSION_TIME_TO_LIVE];
$config[SessionFileConstants::YVES_SESSION_TIME_TO_LIVE] = $config[SessionConstants::YVES_SESSION_TIME_TO_LIVE];
$config[SessionFileConstants::YVES_SESSION_FILE_PATH] = session_save_path();
$config[SessionConstants::YVES_SESSION_COOKIE_NAME] = $config[ApplicationConstants::HOST_YVES];
$config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN] = $config[ApplicationConstants::HOST_YVES];
$config[SessionConstants::YVES_SESSION_PERSISTENT_CONNECTION] = $config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION];
$config[SessionRedisConstants::YVES_SESSION_REDIS_PROTOCOL] = $config[StorageRedisConstants::STORAGE_REDIS_PROTOCOL];
$config[SessionRedisConstants::YVES_SESSION_REDIS_HOST] = $config[StorageRedisConstants::STORAGE_REDIS_HOST];
$config[SessionRedisConstants::YVES_SESSION_REDIS_PORT] = $config[StorageRedisConstants::STORAGE_REDIS_PORT];
$config[SessionRedisConstants::YVES_SESSION_REDIS_PASSWORD] = $config[StorageRedisConstants::STORAGE_REDIS_PASSWORD];
$config[SessionRedisConstants::YVES_SESSION_REDIS_DATABASE] = 1;

$config[SessionConstants::ZED_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS;
$config[SessionConstants::ZED_SESSION_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_1_HOUR;
$config[SessionRedisConstants::ZED_SESSION_TIME_TO_LIVE] = $config[SessionConstants::ZED_SESSION_TIME_TO_LIVE];
$config[SessionFileConstants::ZED_SESSION_TIME_TO_LIVE] = $config[SessionConstants::ZED_SESSION_TIME_TO_LIVE];
$config[SessionFileConstants::ZED_SESSION_FILE_PATH] = session_save_path();
$config[SessionConstants::ZED_SESSION_COOKIE_NAME] = $config[ApplicationConstants::HOST_ZED_GUI];
$config[SessionConstants::ZED_SESSION_PERSISTENT_CONNECTION] = $config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION];
$config[SessionRedisConstants::ZED_SESSION_REDIS_PROTOCOL] = $config[StorageRedisConstants::STORAGE_REDIS_PROTOCOL];
$config[SessionRedisConstants::ZED_SESSION_REDIS_HOST] = $config[StorageRedisConstants::STORAGE_REDIS_HOST];
$config[SessionRedisConstants::ZED_SESSION_REDIS_PORT] = $config[StorageRedisConstants::STORAGE_REDIS_PORT];
$config[SessionRedisConstants::ZED_SESSION_REDIS_PASSWORD] = $config[StorageRedisConstants::STORAGE_REDIS_PASSWORD];
$config[SessionRedisConstants::ZED_SESSION_REDIS_DATABASE] = 2;

$config[SessionRedisConstants::LOCKING_TIMEOUT_MILLISECONDS] = 0;
$config[SessionRedisConstants::LOCKING_RETRY_DELAY_MICROSECONDS] = 0;
$config[SessionRedisConstants::LOCKING_LOCK_TTL_MILLISECONDS] = 0;

$config[ZedRequestConstants::ZED_API_SSL_ENABLED] = false;

$config[TwigConstants::YVES_THEME]
    = $config[CmsConstants::YVES_THEME] = 'default';

$config[ErrorHandlerConstants::YVES_ERROR_PAGE] = APPLICATION_ROOT_DIR . '/public/Yves/errorpage/error.html';
$config[ErrorHandlerConstants::ZED_ERROR_PAGE] = APPLICATION_ROOT_DIR . '/public/Yves/errorpage/error.html';
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebHtmlErrorRenderer::class;

$config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN] = $config[ApplicationConstants::HOST_YVES];
$config[ApplicationConstants::YVES_COOKIE_DEVICE_ID_NAME] = 'did';
$config[ApplicationConstants::YVES_COOKIE_DEVICE_ID_VALID_FOR] = '+5 year';
$config[ApplicationConstants::YVES_COOKIE_VISITOR_ID_NAME] = 'vid';
$config[ApplicationConstants::YVES_COOKIE_VISITOR_ID_VALID_FOR] = '+30 minute';

$config[CustomerConstants::CUSTOMER_SECURED_PATTERN] = '(^/login_check$|^/customer|^/wishlist)';
$config[CustomerConstants::CUSTOMER_ANONYMOUS_PATTERN] = '^/.*';

$currentStore = Store::getInstance()->getStoreName();

$config[ApplicationConstants::CLOUD_ENABLED] = false;
$config[ApplicationConstants::CLOUD_OBJECT_STORAGE_ENABLED] = false;
$config[ApplicationConstants::CLOUD_CDN_ENABLED] = false;
$config[ApplicationConstants::CLOUD_CDN_STATIC_MEDIA_PREFIX] = 'media';
$config[ApplicationConstants::CLOUD_CDN_STATIC_MEDIA_HTTP] = '';
$config[ApplicationConstants::CLOUD_CDN_STATIC_MEDIA_HTTPS] = '';
$config[ApplicationConstants::CLOUD_CDN_PRODUCT_IMAGES_PATH_NAME] = '/images/products/';

$config[UserConstants::USER_SYSTEM_USERS] = [
    'yves_system',
];

/**
 * For a better performance you can turn off Zed authentication
 */
$config[AuthConstants::AUTH_ZED_ENABLED]
    = $config[ZedRequestConstants::AUTH_ZED_ENABLED] = true;

$config[AuthConstants::AUTH_DEFAULT_CREDENTIALS] = [
    'yves_system' => [
        'rules' => [
            [
                'bundle' => '*',
                'controller' => 'gateway',
                'action' => '*',
            ],
        ],
        'token' => 'JDJ5JDEwJFE0cXBwYnVVTTV6YVZXSnVmM2l1UWVhRE94WkQ4UjBUeHBEWTNHZlFRTEd4U2F6QVBqejQ2', // Please replace this token for your project
    ],
];

/**
 * ACL: Allow or disallow of urls for Zed Admin GUI for ALL users
 */
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
];

/**
 * ACL: Allow or disallow of urls for Zed Admin GUI
 */
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

/**
 * ACL: Special rules for specific users
 */
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

/**
 * Zed Navigation Cache
 * The cache should always be activated. Refresh/build with CLI command:
 * vendor/bin/console application:build-navigation-cache
 */
$config[ZedNavigationConstants::ZED_NAVIGATION_CACHE_ENABLED] = true;

$config[SequenceNumberConstants::ENVIRONMENT_PREFIX]
    = $config[SalesConstants::ENVIRONMENT_PREFIX]
    = '';

// Due to some deprecation notices we silence all deprecations for the time being
$config[ErrorHandlerConstants::ERROR_LEVEL] = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED;

// To only log e.g. deprecations instead of throwing exceptions here use
//$config[ErrorHandlerConstants::ERROR_LEVEL] = E_ALL
//$config[ErrorHandlerConstants::ERROR_LEVEL_LOG_ONLY] = E_DEPRECATED | E_USER_DEPRECATED;

$config[ApplicationConstants::ENABLE_WEB_PROFILER] = false;

$config[PropelConstants::SCHEMA_FILE_PATH_PATTERN] = APPLICATION_VENDOR_DIR . '/*/*/src/*/Zed/*/Persistence/Propel/Schema/';

$config[KernelConstants::DEPENDENCY_INJECTOR_YVES] = [
    'CheckoutPage' => [
        'DummyPayment',
    ],
];

$config[KernelConstants::DEPENDENCY_INJECTOR_ZED] = [
    'Payment' => [
        'DummyPayment',
    ],
    'Oms' => [
        'DummyPayment',
    ],
];

$config[OmsConstants::PROCESS_LOCATION] = [
    OmsConfig::DEFAULT_PROCESS_LOCATION,
    $config[KernelConstants::SPRYKER_ROOT] . '/DummyPayment/config/Zed/Oms',
];

$config[OmsConstants::ACTIVE_PROCESSES] = [
    'DummyPayment01',
];

$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    DummyPaymentConfig::PAYMENT_METHOD_INVOICE => 'DummyPayment01',
    DummyPaymentConfig::PAYMENT_METHOD_CREDIT_CARD => 'DummyPayment01',
];

/*
 * Queues can have different adapters and maximum worker number
 * QUEUE_ADAPTER_CONFIGURATION can have the array like this as an example:
 *
 *   'mailQueue' => [
 *       QueueConfig::CONFIG_QUEUE_ADAPTER => \Spryker\Client\RabbitMq\Model\RabbitMqAdapter::class,
 *       QueueConfig::CONFIG_MAX_WORKER_NUMBER => 5
 *   ],
 *
 */
$config[QueueConstants::QUEUE_ADAPTER_CONFIGURATION] = [];
