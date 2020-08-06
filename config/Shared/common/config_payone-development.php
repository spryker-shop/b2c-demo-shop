<?php

use Spryker\Shared\Application\ApplicationConstants;
use SprykerEco\Shared\Payone\PayoneConstants;

// ----------------------------------------------------------------------------
// ------------------------------ PAYMENTS ------------------------------------
// ----------------------------------------------------------------------------

// >>> PAYONE

$config[PayoneConstants::PAYONE][PayoneConstants::PAYONE_MODE] = PayoneConstants::PAYONE_MODE_TEST;
$config[PayoneConstants::PAYONE][PayoneConstants::HOST_YVES] = $config[ApplicationConstants::BASE_URL_YVES];
$config[PayoneConstants::PAYONE][PayoneConstants::PAYONE_REDIRECT_SUCCESS_URL] = sprintf(
    '%s/payone/payment-success',
    $config[ApplicationConstants::BASE_URL_YVES]
);
$config[PayoneConstants::PAYONE][PayoneConstants::PAYONE_REDIRECT_ERROR_URL] = sprintf(
    '%s/payone/payment-failure',
    $config[ApplicationConstants::BASE_URL_YVES]
);
$config[PayoneConstants::PAYONE][PayoneConstants::PAYONE_REDIRECT_BACK_URL] = sprintf(
    '%s/payone/regular-redirect-payment-cancellation',
    $config[ApplicationConstants::BASE_URL_YVES]
);
