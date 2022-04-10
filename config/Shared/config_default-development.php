<?php

use Monolog\Logger;
use Pyz\Shared\Console\ConsoleConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Shared\DocumentationGeneratorRestApi\DocumentationGeneratorRestApiConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebExceptionErrorRenderer;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\GlueApplication\GlueApplicationConstants;
use Spryker\Shared\Http\HttpConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Newsletter\NewsletterConstants;
use Spryker\Shared\ProductManagement\ProductManagementConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\PropelOrm\PropelOrmConstants;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\Router\RouterConstants;
use Spryker\Shared\Session\SessionConfig;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\SessionFile\SessionFileConstants;
use Spryker\Shared\SessionRedis\SessionRedisConstants;
use Spryker\Shared\Testify\TestifyConstants;
use Spryker\Shared\WebProfiler\WebProfilerConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use SprykerShop\Shared\CalculationPage\CalculationPageConstants;
use SprykerShop\Shared\ErrorPage\ErrorPageConstants;
use SprykerShop\Shared\ShopApplication\ShopApplicationConstants;
use SprykerShop\Shared\WebProfilerWidget\WebProfilerWidgetConstants;

// ############################################################################
// ############################## DEVELOPMENT IN DEVVM ########################
// ############################################################################

$domain = getenv('VM_PROJECT') ?: 'suite';
$storeLowerCase = strtolower(APPLICATION_STORE);
$stores = array_combine(Store::getInstance()->getAllowedStores(), Store::getInstance()->getAllowedStores());
$yvesHost = sprintf('www.%s.%s.local', $storeLowerCase, $domain);
$zedHost = sprintf('zed.%s.%s.local', $storeLowerCase, $domain);
$glueHost = sprintf('glue.de.%s.local', $domain);
$backofficeHost = sprintf('backoffice.%s.%s.local', $storeLowerCase, $domain);
$backendApiHost = sprintf('backend-api.%s.%s.local', $storeLowerCase, $domain);
$backendGatewayHost = sprintf('backend-gateway.%s.%s.local', $storeLowerCase, $domain);

// ----------------------------------------------------------------------------
// ------------------------------ CODEBASE ------------------------------------
// ----------------------------------------------------------------------------

$config[KernelConstants::STORE_PREFIX] = 'DEV';

// >>> Debug
$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = $config[CalculationPageConstants::ENABLE_CART_DEBUG]
    = $config[ShopApplicationConstants::ENABLE_APPLICATION_DEBUG]
    = $config[GlueApplicationConstants::GLUE_APPLICATION_REST_DEBUG]
    = true;

// >>> Dev tools
if (interface_exists(WebProfilerConstants::class)) {
    $config[WebProfilerConstants::IS_WEB_PROFILER_ENABLED] = false;
}
if (interface_exists(WebProfilerWidgetConstants::class)) {
    $config[WebProfilerWidgetConstants::IS_WEB_PROFILER_ENABLED] = false;
}
$config[ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS] = true;
$config[DocumentationGeneratorRestApiConstants::ENABLE_REST_API_DOCUMENTATION_GENERATION] = true;

// >>> ErrorHandler
$config[ErrorPageConstants::ENABLE_ERROR_404_STACK_TRACE] = true;
$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebExceptionErrorRenderer::class;
$config[ErrorHandlerConstants::IS_PRETTY_ERROR_HANDLER_ENABLED] = true;

// ----------------------------------------------------------------------------
// ------------------------------ SECURITY ------------------------------------
// ----------------------------------------------------------------------------

$config[SessionConstants::ZED_SSL_ENABLED]
    = $config[SessionConstants::YVES_SSL_ENABLED]
    = $config[RouterConstants::YVES_IS_SSL_ENABLED]
    = $config[RouterConstants::ZED_IS_SSL_ENABLED]
    = $config[HttpConstants::ZED_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $config[HttpConstants::YVES_HTTP_STRICT_TRANSPORT_SECURITY_ENABLED]
    = $config[ApplicationConstants::ZED_SSL_ENABLED]
    = $config[ApplicationConstants::YVES_SSL_ENABLED]
    = false;

$trustedHosts
    = $config[HttpConstants::ZED_TRUSTED_HOSTS]
    = $config[HttpConstants::YVES_TRUSTED_HOSTS]
    = [
    $zedHost,
    $yvesHost,
    $backofficeHost,
    $backendApiHost,
    $backendGatewayHost,
];

$config[KernelConstants::DOMAIN_WHITELIST] = array_merge($trustedHosts, $config[KernelConstants::DOMAIN_WHITELIST]);

// ----------------------------------------------------------------------------
// ------------------------------ AUTHENTICATION ------------------------------
// ----------------------------------------------------------------------------

require 'common/config_oauth-devvm.php';

// ----------------------------------------------------------------------------
// ------------------------------ SERVICES ------------------------------------
// ----------------------------------------------------------------------------

require 'common/config_services-devvm.php';
require 'common/config_logs-files.php';

// >>> DATABASE
$config[PropelConstants::ZED_DB_USERNAME] = 'development';
$config[PropelConstants::ZED_DB_PASSWORD] = 'mate20mg';
$config[PropelConstants::ZED_DB_DATABASE] = ''; // Specified in codebucket specific configs: config_default-development_*.php

// >>> SESSION
$config[SessionConstants::ZED_SESSION_TIME_TO_LIVE]
    = $config[SessionRedisConstants::ZED_SESSION_TIME_TO_LIVE]
    = $config[SessionFileConstants::ZED_SESSION_TIME_TO_LIVE] = SessionConfig::SESSION_LIFETIME_1_YEAR;

// >>> QUEUE

$config[RabbitMqEnv::RABBITMQ_API_VIRTUAL_HOST]
    = $config[RabbitMqEnv::RABBITMQ_VIRTUAL_HOST]
    = sprintf('/%s_development_zed', APPLICATION_STORE);
$config[RabbitMqEnv::RABBITMQ_USERNAME] = sprintf('%s_development', APPLICATION_STORE);

$config[RabbitMqEnv::RABBITMQ_CONNECTIONS] = array_map(static function ($storeName) {
    return [
        RabbitMqEnv::RABBITMQ_CONNECTION_NAME => $storeName . '-connection',
        RabbitMqEnv::RABBITMQ_HOST => 'localhost',
        RabbitMqEnv::RABBITMQ_PORT => '5672',
        RabbitMqEnv::RABBITMQ_PASSWORD => 'mate20mg',
        RabbitMqEnv::RABBITMQ_USERNAME => $storeName . '_development',
        RabbitMqEnv::RABBITMQ_VIRTUAL_HOST => '/' . $storeName . '_development_zed',
        RabbitMqEnv::RABBITMQ_STORE_NAMES => [$storeName],
        RabbitMqEnv::RABBITMQ_DEFAULT_CONNECTION => $storeName === APPLICATION_STORE,
    ];
}, $stores);

// ---------- LOGGER

$config[EventConstants::LOGGER_ACTIVE] = true;
$config[PropelOrmConstants::PROPEL_SHOW_EXTENDED_EXCEPTION] = true;

$config[LogConstants::LOG_LEVEL] = Logger::INFO;

// ----------------------------------------------------------------------------
// ------------------------------ ZED (Gateway) -------------------------------
// ----------------------------------------------------------------------------

$config[ZedRequestConstants::ZED_API_SSL_ENABLED] = false;
$config[ZedRequestConstants::HOST_ZED_API]
    = $backendGatewayHost;

$config[SessionConstants::ZED_SESSION_COOKIE_NAME]
    = $config[SessionConstants::ZED_SESSION_COOKIE_DOMAIN]
    = $backofficeHost;
$config[ZedRequestConstants::BASE_URL_ZED_API] = sprintf(
    'http://%s',
    $backendGatewayHost
);
$config[ZedRequestConstants::BASE_URL_SSL_ZED_API] = sprintf(
    'https://%s',
    $backendGatewayHost
);

// ----------------------------------------------------------------------------
// ------------------------------ BACKOFFICE ----------------------------------
// ----------------------------------------------------------------------------

$config[ApplicationConstants::BASE_URL_ZED] = sprintf(
    'http://%s',
    $backofficeHost
);

// ----------------------------------------------------------------------------
// ------------------------------ FRONTEND ------------------------------------
// ----------------------------------------------------------------------------

$config[ApplicationConstants::HOST_YVES]
    = $config[SessionConstants::YVES_SESSION_COOKIE_NAME]
    = $config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN]
    = $yvesHost;
$config[ApplicationConstants::BASE_URL_YVES]
    = $config[CustomerConstants::BASE_URL_YVES]
    = $config[ProductManagementConstants::BASE_URL_YVES]
    = $config[NewsletterConstants::BASE_URL_YVES]
    = sprintf(
        'http://%s',
        $yvesHost
    );

// ----------------------------------------------------------------------------
// ------------------------------ API -----------------------------------------
// ----------------------------------------------------------------------------

$config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN]
    = sprintf(
        'http://%s',
        $glueHost
    );

if (class_exists(TestifyConstants::class)) {
    $config[TestifyConstants::GLUE_APPLICATION_DOMAIN] = $config[GlueApplicationConstants::GLUE_APPLICATION_DOMAIN];
}

$config[GlueApplicationConstants::GLUE_APPLICATION_CORS_ALLOW_ORIGIN] = '*';

// ----------------------------------------------------------------------------
// ------------------------------ OMS -----------------------------------------
// ----------------------------------------------------------------------------

require 'common/config_oms-development.php';

// ----------- FirstSpirit Preview Configurations
//$config[FirstSpiritPreviewConstants::FIRSTSPIRIT_PREVIEW_AUTHENTICATION_INIT_TOKEN] = '<ADD TOKEN>';
//$config[FirstSpiritPreviewConstants::FIRSTSPIRIT_PREVIEW_WEB_HOST] = '<ADD FS PREVIEW HOST>';
//$config[FirstSpiritPreviewConstants::FIRSTSPIRIT_PREVIEW_CAAS_CONTENT_PAGE_COLLECTION] = '<CAAS COLLECTION>';
//$config[FirstSpiritPreviewConstants::FIRSTSPIRIT_PREVIEW_CAAS_CATEGORY_PAGE_COLLECTION] = '<CAAS COLLECTION>';
//$config[FirstSpiritPreviewConstants::FIRSTSPIRIT_PREVIEW_CAAS_PRODUCT_PAGE_COLLECTION] = '<CAAS COLLECTION>';
//$config[FirstSpiritPreviewConstants::FIRSTSPIRIT_PREVIEW_DISPLAY_BLOCK_RENDER_ERRORS] = true;

// ----------- FirstSpirit Data Import Configurations
//$config[FirstSpiritDataImportConstants::FIRSTSPIRIT_DATA_IMPORT_BLOCK_DATA_CAAS_PATH] = '/_aggrs/blocks';
//$config[FirstSpiritDataImportConstants::FIRSTSPIRIT_CAAS_REQUEST_PAGESIZE] = <VALUE>;
//
//// ----------- FirstSpirit CaaS Configurations
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_HOSTNAME_PREVIEW] = '<ADD CAAS HOST>';
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_PORT_PREVIEW] = '<ADD CAAS PORT>';
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_SCHEME_PREVIEW] = '<ADD CAAS SCHEME>';
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_APIKEY_PREVIEW] = '<ADD APIKEY>';
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_DATABASE_PREVIEW] = '<ADD CAAS DATABASE>';
//
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_HOSTNAME_ONLINE] = '<ADD CAAS HOST>';
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_PORT_ONLINE] = '<ADD CAAS PORT>';
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_SCHEME_ONLINE] = '<ADD CAAS SCHEME>';
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_APIKEY_ONLINE] = '<ADD APIKEY>';
//$config[FirstSpiritCaaSConstants::FIRSTSPIRIT_CAAS_DATABASE_ONLINE] = '<ADD CAAS DATABASE>';
