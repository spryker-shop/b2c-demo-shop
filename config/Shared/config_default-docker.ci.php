<?php

// ############################################################################
// ############################## CI CONFIGURATION ############################
// ############################################################################

use Monolog\Logger;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\GlueBackendApiApplication\GlueBackendApiApplicationConstants;
use Spryker\Shared\GlueJsonApiConvention\GlueJsonApiConventionConstants;
use Spryker\Shared\GlueStorefrontApiApplication\GlueStorefrontApiApplicationConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Product\ProductConstants;
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

//-----------------------------------------------------------------------------
//----------------------------------- ACP -------------------------------------
//-----------------------------------------------------------------------------
$config[ProductConstants::PUBLISHING_TO_MESSAGE_BROKER_ENABLED] = false;

$sprykerGlueStorefrontHost = getenv('SPRYKER_GLUE_STOREFRONT_HOST');
$sprykerGlueBackendHost = getenv('SPRYKER_GLUE_BACKEND_HOST');
$config[GlueBackendApiApplicationConstants::GLUE_BACKEND_API_HOST] = $sprykerGlueBackendHost;
$config[GlueStorefrontApiApplicationConstants::GLUE_STOREFRONT_API_HOST] = $sprykerGlueStorefrontHost;
$config[GlueJsonApiConventionConstants::GLUE_DOMAIN] = sprintf(
    'http://%s',
    $sprykerGlueStorefrontHost ?: $sprykerGlueBackendHost ?: 'localhost',
);
