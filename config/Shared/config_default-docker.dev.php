<?php

use Monolog\Logger;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Shared\DocumentationGeneratorRestApi\DocumentationGeneratorRestApiConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebExceptionErrorRenderer;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebHtmlErrorRenderer;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Newsletter\NewsletterConstants;
use Spryker\Shared\ProductManagement\ProductManagementConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\PropelOrm\PropelOrmConstants;
use Spryker\Shared\Queue\QueueConfig;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Shared\Router\RouterConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\Testify\TestifyConstants;
use Spryker\Shared\WebProfiler\WebProfilerConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use SprykerShop\Shared\CalculationPage\CalculationPageConstants;
use SprykerShop\Shared\ErrorPage\ErrorPageConstants;
use SprykerShop\Shared\ShopApplication\ShopApplicationConstants;
use SprykerShop\Shared\WebProfilerWidget\WebProfilerWidgetConstants;

// ############################################################################
// ############################## DEVELOPMENT CONFIGURATION ###################
// ############################################################################

// ----------------------------------------------------------------------------
// ------------------------------ CODEBASE ------------------------------------
// ----------------------------------------------------------------------------

// >>> Debug

$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = $config[ShopApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = (bool)getenv('SPRYKER_DEBUG_ENABLED');

$config[PropelConstants::PROPEL_DEBUG] = (bool)getenv('SPRYKER_DEBUG_PROPEL_ENABLED');
$config[CalculationPageConstants::ENABLE_CART_DEBUG] = (bool)getenv('SPRYKER_DEBUG_ENABLED');
$config[ErrorPageConstants::ENABLE_ERROR_404_STACK_TRACE] = (bool)getenv('SPRYKER_DEBUG_ENABLED');
$config[GlueApplicationConstants::GLUE_APPLICATION_REST_DEBUG] = (bool)getenv('SPRYKER_DEBUG_ENABLED');

// >>> Dev tools

if (interface_exists(WebProfilerConstants::class, true)) {
    $config[WebProfilerConstants::IS_WEB_PROFILER_ENABLED]
        = $config[WebProfilerWidgetConstants::IS_WEB_PROFILER_ENABLED]
        = false;
}
$config[KernelConstants::ENABLE_CONTAINER_OVERRIDING] = (bool)getenv('SPRYKER_TESTING_ENABLED');
$config[DocumentationGeneratorRestApiConstants::ENABLE_REST_API_DOCUMENTATION_GENERATION] = true;

// >>> Error handler

$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::ERROR_RENDERER] = getenv('SPRYKER_DEBUG_ENABLED') ? WebExceptionErrorRenderer::class : WebHtmlErrorRenderer::class;
$config[ErrorHandlerConstants::IS_PRETTY_ERROR_HANDLER_ENABLED] = (bool)getenv('SPRYKER_DEBUG_ENABLED');
$config[ErrorHandlerConstants::ERROR_LEVEL] = getenv('SPRYKER_DEBUG_DEPRECATIONS_ENABLED') ? E_ALL : $config[ErrorHandlerConstants::ERROR_LEVEL];

// ----------------------------------------------------------------------------
// ------------------------------ SERVICES ------------------------------------
// ----------------------------------------------------------------------------

// >>> QUEUE

$config[QueueConstants::QUEUE_ADAPTER_CONFIGURATION][EventConstants::EVENT_QUEUE][QueueConfig::CONFIG_MAX_WORKER_NUMBER] = 1;

// >>> LOGGER

$config[EventConstants::LOGGER_ACTIVE] = true;
$config[PropelOrmConstants::PROPEL_SHOW_EXTENDED_EXCEPTION] = true;
$config[LogConstants::LOG_LEVEL] = getenv('SPRYKER_DEBUG_ENABLED') ? Logger::INFO : Logger::DEBUG;

// >>> ZED REQUEST

$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = (bool)getenv('SPRYKER_DEBUG_ENABLED');
$config[ZedRequestConstants::SET_REPEAT_DATA] = (bool)getenv('SPRYKER_DEBUG_ENABLED');

if (!getenv('SPRYKER_SSL_ENABLE')) {
// ----------------------------------------------------------------------------
// ------------------------------ SECURITY ------------------------------------
// ----------------------------------------------------------------------------

    $config[SessionConstants::ZED_SSL_ENABLED]
        = $config[SessionConstants::YVES_SSL_ENABLED]
        = $config[RouterConstants::YVES_IS_SSL_ENABLED]
        = $config[RouterConstants::ZED_IS_SSL_ENABLED]
        = $config[ApplicationConstants::ZED_SSL_ENABLED]
        = $config[ApplicationConstants::YVES_SSL_ENABLED]
        = false;

// ----------------------------------------------------------------------------
// ------------------------------ BACKOFFICE ----------------------------------
// ----------------------------------------------------------------------------

    $backofficePort = (int)(getenv('SPRYKER_BE_PORT')) ?: 80;
    $config[ApplicationConstants::BASE_URL_ZED] = sprintf(
        'http://%s%s',
        getenv('SPRYKER_BE_HOST'),
        $backofficePort !== 80 ? ':' . $backofficePort : ''
    );

// ----------------------------------------------------------------------------
// ------------------------------ FRONTEND ------------------------------------
// ----------------------------------------------------------------------------

    $yvesHost = getenv('SPRYKER_FE_HOST');
    $yvesPort = (int)(getenv('SPRYKER_FE_PORT')) ?: 80;
    $config[ApplicationConstants::BASE_URL_YVES]
        = $config[CustomerConstants::BASE_URL_YVES]
        = $config[ProductManagementConstants::BASE_URL_YVES]
        = $config[NewsletterConstants::BASE_URL_YVES]
        = sprintf(
            'http://%s%s',
            $yvesHost,
            $yvesPort !== 80 ? ':' . $yvesPort : ''
        );

// ----------------------------------------------------------------------------
// ------------------------------ API -----------------------------------------
// ----------------------------------------------------------------------------

    $glueHost = getenv('SPRYKER_API_HOST') ?: 'localhost';
    $gluePort = (int)(getenv('SPRYKER_API_PORT')) ?: 80;
    $config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN] = sprintf(
        'http://%s%s',
        $glueHost,
        $gluePort !== 80 ? ':' . $gluePort : ''
    );

    if (class_exists(TestifyConstants::class, true)) {
        $config[TestifyConstants::GLUE_APPLICATION_DOMAIN] = $config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN];
    }
}

// ----------------------------------------------------------------------------
// ------------------------------ OMS -----------------------------------------
// ----------------------------------------------------------------------------

require 'common/config_oms-development.php';
