<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PaymentsRestApi;

use Spryker\Glue\PaymentsRestApi\PaymentsRestApiConfig as SprykerPaymentsRestApiConfig;
use Spryker\Shared\DummyPayment\DummyPaymentConfig;

class PaymentsRestApiConfig extends SprykerPaymentsRestApiConfig
{
    protected const PAYMENT_METHOD_PRIORITY = [
        DummyPaymentConfig::PAYMENT_METHOD_INVOICE => 1,
        DummyPaymentConfig::PAYMENT_METHOD_CREDIT_CARD => 2,
    ];

    protected const PAYMENT_METHOD_REQUIRED_FIELDS = [
        DummyPaymentConfig::PROVIDER_NAME => [
            DummyPaymentConfig::PAYMENT_METHOD_INVOICE => [
                'dummyPaymentInvoice.dateOfBirth',
            ],
            DummyPaymentConfig::PAYMENT_METHOD_CREDIT_CARD => [
                'dummyPaymentCreditCard.cardType',
                'dummyPaymentCreditCard.cardNumber',
                'dummyPaymentCreditCard.nameOnCard',
                'dummyPaymentCreditCard.cardExpiresMonth',
                'dummyPaymentCreditCard.cardExpiresYear',
                'dummyPaymentCreditCard.cardSecurityCode',
            ],
        ],
    ];
}
