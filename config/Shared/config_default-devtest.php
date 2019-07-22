<?php

/**
 * This is the global runtime configuration for Yves and Generated_Yves_Zed in a devtest environment.
 */

use Monolog\Logger;
use Pyz\Shared\Console\ConsoleConstants;
use Pyz\Shared\Scheduler\SchedulerConfig;
use Pyz\Yves\ShopApplication\YvesBootstrap;
use Pyz\Zed\Application\Communication\ZedBootstrap;
use Spryker\Shared\Application\Log\Config\SprykerLoggerConfig;
use Spryker\Shared\Config\ConfigConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebExceptionErrorRenderer;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Oauth\OauthConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\Scheduler\SchedulerConstants;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConstants;
use Spryker\Shared\Search\SearchConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\SessionRedis\SessionRedisConfig;
use Spryker\Shared\StorageRedis\StorageRedisConstants;
use Spryker\Shared\Testify\TestifyConstants;
use Spryker\Shared\Twig\TwigConstants;
use Spryker\Shared\WebProfiler\WebProfilerConstants;

// ---------- General
$config[KernelConstants::SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker';

// ---------- Testify
$config[TestifyConstants::BOOTSTRAP_CLASS_YVES] = YvesBootstrap::class;
$config[TestifyConstants::BOOTSTRAP_CLASS_ZED] = ZedBootstrap::class;

// ---------- Propel
$config[PropelConstants::ZED_DB_ENGINE] = $config[PropelConstants::ZED_DB_ENGINE_PGSQL];
$config[PropelConstants::ZED_DB_HOST] = '127.0.0.1';
$config[PropelConstants::ZED_DB_PORT] = 5432;

// ---------- Redis
$config[StorageRedisConstants::STORAGE_REDIS_DATABASE] = 3;

// ---------- Session
$config[SessionConstants::SESSION_IS_TEST] = (bool)getenv("SESSION_IS_TEST");
$config[SessionConstants::YVES_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS;
$config[SessionConstants::ZED_SESSION_COOKIE_SECURE] = false;
$config[SessionConstants::ZED_SESSION_SAVE_HANDLER] = SessionRedisConfig::SESSION_HANDLER_REDIS;

// ---------- Elasticsearch
$config[SearchConstants::SEARCH_INDEX_NAME_SUFFIX] = '_devtest';

$config[RabbitMqEnv::RABBITMQ_API_HOST] = 'localhost';
$config[RabbitMqEnv::RABBITMQ_API_PORT] = '15672';
$config[RabbitMqEnv::RABBITMQ_API_USERNAME] = 'admin';
$config[RabbitMqEnv::RABBITMQ_API_PASSWORD] = 'mate20mg';

// ---------- Twig
$config[TwigConstants::ZED_TWIG_OPTIONS] = [
    'cache' => false,
];
$config[TwigConstants::YVES_TWIG_OPTIONS] = [
    'cache' => false,
];

// ---------- Logging
$config[LogConstants::LOG_FILE_PATH] = APPLICATION_ROOT_DIR . '/data/logs';

// ---------- Scheduler
$config[SchedulerConstants::ENABLED_SCHEDULERS] = [
    SchedulerConfig::SCHEDULER_JENKINS,
];
$config[SchedulerJenkinsConstants::JENKINS_CONFIGURATION] = [
    SchedulerConfig::SCHEDULER_JENKINS => [
        'host' => 'http://localhost:10007/',
    ],
];

// ---------- ErrorHandler
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebExceptionErrorRenderer::class;

// ---------- Logging
$config[LogConstants::LOG_LEVEL] = Logger::CRITICAL;
$config[LogConstants::LOGGER_CONFIG] = SprykerLoggerConfig::class;

$config[WebProfilerConstants::ENABLE_WEB_PROFILER]
    = $config[ConfigConstants::ENABLE_WEB_PROFILER]
    = false;

$config[GlueApplicationConstants::GLUE_APPLICATION_REST_DEBUG] = true;

// ----------- OAUTH
$config[OauthConstants::PRIVATE_KEY_PATH] = 'file://' . APPLICATION_ROOT_DIR . '/config/Zed/dev_only_private.key';
$config[OauthConstants::PUBLIC_KEY_PATH] = 'file://' . APPLICATION_ROOT_DIR . '/config/Zed/dev_only_public.key';
$config[OauthConstants::ENCRYPTION_KEY] = 'lxZFUEsBCJ2Yb14IF2ygAHI5N4+ZAUXXaSeeJm6+twsUmIen';
$config[OauthConstants::OAUTH_CLIENT_IDENTIFIER] = 'frontend';
$config[OauthConstants::OAUTH_CLIENT_SECRET] = 'abc123';

// ----------- Queue
$config[QueueConstants::QUEUE_WORKER_LOOP] = true;

// ---------- Event
$config[EventConstants::EVENT_CHUNK] = 5000;

// ---------- Kernel
$config[KernelConstants::ENABLE_CONTAINER_OVERRIDING] = true;

// ---------- Console
$config[ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS] = true;
