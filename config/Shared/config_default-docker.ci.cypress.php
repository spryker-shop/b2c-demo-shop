<?php

// ############################################################################
// ########################## CI CYPRESS CONFIGURATION ########################
// ############################################################################

use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\ErrorHandler\ErrorRenderer\WebExceptionErrorRenderer;
use Spryker\Shared\SecurityBlocker\SecurityBlockerConstants;
use Spryker\Shared\SecurityBlockerBackoffice\SecurityBlockerBackofficeConstants;
use Spryker\Shared\SecurityBlockerStorefrontAgent\SecurityBlockerStorefrontAgentConstants;
use Spryker\Shared\SecurityBlockerStorefrontCustomer\SecurityBlockerStorefrontCustomerConstants;

require 'config_default-docker.ci.php';

//-----------------------------------------------------------------------------
//------------------------------- ErrorHandler --------------------------------
//-----------------------------------------------------------------------------
$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;
$config[ErrorHandlerConstants::ERROR_RENDERER] = WebExceptionErrorRenderer::class;
$config[ErrorHandlerConstants::IS_PRETTY_ERROR_HANDLER_ENABLED] = true;

//-----------------------------------------------------------------------------
//----------------------------- Security Blocker ------------------------------
//-----------------------------------------------------------------------------
$config[SecurityBlockerConstants::SECURITY_BLOCKER_BLOCKING_NUMBER_OF_ATTEMPTS] = 1000;
$config[SecurityBlockerStorefrontAgentConstants::AGENT_BLOCKING_NUMBER_OF_ATTEMPTS] = 1000;
$config[SecurityBlockerStorefrontCustomerConstants::CUSTOMER_BLOCKING_NUMBER_OF_ATTEMPTS] = 1000;
$config[SecurityBlockerBackofficeConstants::BACKOFFICE_USER_BLOCKING_NUMBER_OF_ATTEMPTS] = 1000;
