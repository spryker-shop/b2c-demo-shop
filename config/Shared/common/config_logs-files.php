<?php

use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\Queue\QueueConstants;

// ----------------------------------------------------------------------------
// ------------------------------ SERVICES ------------------------------------
// ----------------------------------------------------------------------------

// >>> LOGGING

$baseLogFilePath = sprintf('%s/data/logs', APPLICATION_ROOT_DIR);

$config[LogConstants::LOG_FILE_PATH_YVES] = $baseLogFilePath . '/YVES/application.log';
$config[LogConstants::LOG_FILE_PATH_ZED] = $baseLogFilePath . '/ZED/application.log';
$config[LogConstants::LOG_FILE_PATH_GLUE] = $baseLogFilePath . '/GLUE/application.log';

$config[LogConstants::EXCEPTION_LOG_FILE_PATH_YVES] = $baseLogFilePath . '/YVES/exception.log';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_ZED] = $baseLogFilePath . '/ZED/exception.log';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_GLUE] = $baseLogFilePath . '/GLUE/exception.log';

$config[EventConstants::LOG_FILE_PATH] = $baseLogFilePath . '/application_events.log';
$config[QueueConstants::QUEUE_WORKER_OUTPUT_FILE_NAME] = $baseLogFilePath . '/ZED/queue.out';

$config[PropelConstants::LOG_FILE_PATH] = $baseLogFilePath . '/ZED/propel.log';

$config[LogConstants::LOG_FILE_PATH] = $baseLogFilePath . '/application.log';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH] = $baseLogFilePath . '/exception.log';
