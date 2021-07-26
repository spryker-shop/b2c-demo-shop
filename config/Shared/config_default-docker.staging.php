<?php

// ############################################################################
// ############################## CI CONFIGURATION ############################
// ############################################################################


use Monolog\Logger;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\Http\HttpConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\Queue\QueueConstants;

require 'config_default-docker.dev.php';

// ----------------------------------------------------------------------------
// ------------------------------ SERVICES ------------------------------------
// ----------------------------------------------------------------------------

// >>> LOGGING
$config[LogConstants::LOG_LEVEL] = Logger::ERROR;
$config[PropelConstants::LOG_FILE_PATH]
    = $config[EventConstants::LOG_FILE_PATH]
    = $config[LogConstants::LOG_FILE_PATH_YVES]
    = $config[LogConstants::LOG_FILE_PATH_ZED]
    = $config[LogConstants::LOG_FILE_PATH_GLUE]
    = $config[LogConstants::LOG_FILE_PATH]
    = $config[QueueConstants::QUEUE_WORKER_OUTPUT_FILE_NAME]
    = getenv('SPRYKER_LOG_STDOUT') ?: '/dev/null';

$config[HttpConstants::ZED_TRUSTED_PROXIES] = ['127.0.0.1', 'REMOTE_ADDR', '*'];
