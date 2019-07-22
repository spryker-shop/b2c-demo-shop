<?php

/**
 * This is the global runtime configuration for Yves and Generated_Yves_Zed in a development environment.
 */

use Pyz\Shared\Scheduler\SchedulerConfig;
use Spryker\Shared\Acl\AclConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\PropelOrm\PropelOrmConstants;
use Spryker\Shared\Scheduler\SchedulerConstants;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConfig;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConstants;
use Spryker\Shared\Search\SearchConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\StorageRedis\StorageRedisConstants;
use Spryker\Shared\ZedNavigation\ZedNavigationConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use SprykerShop\Shared\ShopApplication\ShopApplicationConstants;

// ---------- General
$config[KernelConstants::SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker';
$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = $config[ShopApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = false;
$config[ZedRequestConstants::SET_REPEAT_DATA] = false;
$config[KernelConstants::STORE_PREFIX] = 'DEV';

// ---------- Propel
$config[PropelConstants::PROPEL_DEBUG] = false;
$config[PropelOrmConstants::PROPEL_SHOW_EXTENDED_EXCEPTION] = false;
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false;
$ENV_DB_CONNECTION_DATA = parse_url(getenv(getenv('DATABASE_URL_NAME') ?: 'DATABASE_URL'));
$config[PropelConstants::ZED_DB_ENGINE] = $config[PropelConstants::ZED_DB_ENGINE_PGSQL];
$config[PropelConstants::ZED_DB_USERNAME] = $ENV_DB_CONNECTION_DATA['user'];
$config[PropelConstants::ZED_DB_PASSWORD] = $ENV_DB_CONNECTION_DATA['pass'];
$config[PropelConstants::ZED_DB_DATABASE] = ltrim($ENV_DB_CONNECTION_DATA['path'], '/');
$config[PropelConstants::ZED_DB_HOST] = $ENV_DB_CONNECTION_DATA['host'];
$config[PropelConstants::ZED_DB_PORT] = isset($ENV_DB_CONNECTION_DATA['port']) ? $ENV_DB_CONNECTION_DATA['port'] : 5432;

// ---------- Redis
$ENV_REDIS_CONNECTION_DATA = parse_url(getenv(getenv('REDIS_URL_NAME') ?: 'REDIS_URL'));
$config[StorageRedisConstants::STORAGE_REDIS_PROTOCOL] = $ENV_REDIS_CONNECTION_DATA['scheme'];
$config[StorageRedisConstants::STORAGE_REDIS_HOST] = $ENV_REDIS_CONNECTION_DATA['host'];
$config[StorageRedisConstants::STORAGE_REDIS_PORT] = $ENV_REDIS_CONNECTION_DATA['port'];
$config[StorageRedisConstants::STORAGE_REDIS_PASSWORD] = $ENV_REDIS_CONNECTION_DATA['pass'];

// ---------- RabbitMQ
$config[ApplicationConstants::ZED_RABBITMQ_HOST] = 'localhost';
$config[ApplicationConstants::ZED_RABBITMQ_PORT] = '5672';

// ---------- Session
$config[SessionConstants::YVES_SESSION_COOKIE_SECURE] = false;
$config[SessionConstants::ZED_SESSION_COOKIE_SECURE] = false;

// ---------- Elasticsearch
$ENV_ELASTICA_CONNECTION_DATA = parse_url(getenv(getenv('ELASTIC_SEARCH_URL_NAME') ?: 'ELASTIC_SEARCH_URL'));
$ELASTICA_BASIC_AUTH = base64_encode($ENV_ELASTICA_CONNECTION_DATA['user'] . ':' . $ENV_ELASTICA_CONNECTION_DATA['pass']);
$ELASTICA_AUTH_HEADER = str_pad(
    $ELASTICA_BASIC_AUTH,
    strlen($ELASTICA_BASIC_AUTH) + strlen($ELASTICA_BASIC_AUTH) % 4,
    '=',
    STR_PAD_RIGHT
);
$ELASTICA_PORT = ($ENV_ELASTICA_CONNECTION_DATA['scheme'] == 'https' ? 443 : 80);
$config[SearchConstants::ELASTICA_PARAMETER__AUTH_HEADER] = $ELASTICA_AUTH_HEADER;
$config[SearchConstants::ELASTICA_PARAMETER__HOST] = $ENV_ELASTICA_CONNECTION_DATA['host'];
$config[SearchConstants::ELASTICA_PARAMETER__TRANSPORT] = $ENV_ELASTICA_CONNECTION_DATA['scheme'];
$config[SearchConstants::ELASTICA_PARAMETER__PORT] = $ELASTICA_PORT;

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
$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = false;

// ---------- Navigation
$config[ZedNavigationConstants::ZED_NAVIGATION_CACHE_ENABLED] = true;

// ---------- ACL
$config[AclConstants::ACL_USER_RULE_WHITELIST][] = [
    'bundle' => 'wdt',
    'controller' => '*',
    'action' => '*',
    'type' => 'allow',
];

// ---------- Error handling
$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;

$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false;
