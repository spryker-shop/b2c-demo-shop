<?php

use Pyz\Shared\Scheduler\SchedulerConfig;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\Queue\QueueConfig;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConfig;
use Spryker\Shared\SchedulerJenkins\SchedulerJenkinsConstants;
use Spryker\Shared\SearchElasticsearch\SearchElasticsearchConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\SessionRedis\SessionRedisConstants;
use Spryker\Shared\StorageRedis\StorageRedisConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use Spryker\Zed\Propel\PropelConfig;

// ----------------------------------------------------------------------------
// ------------------------------ SERVICES ------------------------------------
// ----------------------------------------------------------------------------

// >>> DATABASE

$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = true;
$config[PropelConstants::ZED_DB_ENGINE] = PropelConfig::DB_ENGINE_PGSQL;
$config[PropelConstants::ZED_DB_HOST] = '127.0.0.1';
$config[PropelConstants::ZED_DB_PORT] = 5432;

// >>> SEARCH

$config[SearchElasticsearchConstants::HOST] = 'localhost';
$config[SearchElasticsearchConstants::TRANSPORT] = 'http';
$config[SearchElasticsearchConstants::PORT] = '10005';

// >>> STORAGE

$config[StorageRedisConstants::STORAGE_REDIS_PERSISTENT_CONNECTION] = true;
$config[StorageRedisConstants::STORAGE_REDIS_PROTOCOL] = 'tcp';
$config[StorageRedisConstants::STORAGE_REDIS_HOST] = '127.0.0.1';
$config[StorageRedisConstants::STORAGE_REDIS_PORT] = 10009;
$config[StorageRedisConstants::STORAGE_REDIS_PASSWORD] = false;
$config[StorageRedisConstants::STORAGE_REDIS_DATABASE] = 0;

// >>> SESSION

$config[SessionConstants::YVES_SESSION_COOKIE_SECURE]
    = $config[SessionConstants::ZED_SESSION_COOKIE_SECURE]
    = false;

$config[SessionRedisConstants::YVES_SESSION_REDIS_PROTOCOL] = $config[StorageRedisConstants::STORAGE_REDIS_PROTOCOL];
$config[SessionRedisConstants::YVES_SESSION_REDIS_HOST] = $config[StorageRedisConstants::STORAGE_REDIS_HOST];
$config[SessionRedisConstants::YVES_SESSION_REDIS_PORT] = $config[StorageRedisConstants::STORAGE_REDIS_PORT];
$config[SessionRedisConstants::YVES_SESSION_REDIS_PASSWORD] = $config[StorageRedisConstants::STORAGE_REDIS_PASSWORD];
$config[SessionRedisConstants::YVES_SESSION_REDIS_DATABASE] = 1;

$config[SessionRedisConstants::ZED_SESSION_REDIS_PROTOCOL] = $config[StorageRedisConstants::STORAGE_REDIS_PROTOCOL];
$config[SessionRedisConstants::ZED_SESSION_REDIS_HOST] = $config[StorageRedisConstants::STORAGE_REDIS_HOST];
$config[SessionRedisConstants::ZED_SESSION_REDIS_PORT] = $config[StorageRedisConstants::STORAGE_REDIS_PORT];
$config[SessionRedisConstants::ZED_SESSION_REDIS_PASSWORD] = $config[StorageRedisConstants::STORAGE_REDIS_PASSWORD];
$config[SessionRedisConstants::ZED_SESSION_REDIS_DATABASE] = 2;

// >>> QUEUE

$config[RabbitMqEnv::RABBITMQ_API_HOST] = 'localhost';
$config[RabbitMqEnv::RABBITMQ_API_PORT] = '15672';
$config[RabbitMqEnv::RABBITMQ_API_USERNAME] = 'admin';
$config[RabbitMqEnv::RABBITMQ_API_PASSWORD] = 'mate20mg';

$config[QueueConstants::QUEUE_ADAPTER_CONFIGURATION][EventConstants::EVENT_QUEUE][QueueConfig::CONFIG_MAX_WORKER_NUMBER] = 1;

// >>> SCHEDULER

$config[SchedulerJenkinsConstants::JENKINS_CONFIGURATION] = [
    SchedulerConfig::SCHEDULER_JENKINS => [
        SchedulerJenkinsConfig::SCHEDULER_JENKINS_BASE_URL => 'http://localhost:10007/',
    ],
];

// >>> ZED REQUEST

$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = true;
$config[ZedRequestConstants::SET_REPEAT_DATA] = true;
