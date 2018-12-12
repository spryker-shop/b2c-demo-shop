<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CheckoutRestApi;

use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig as SprykerCheckoutRestApiConfig;

class CheckoutRestApiConfig extends SprykerCheckoutRestApiConfig
{
    protected const PAYMENT_METHOD_REQUIRED_FIELDS = [
        'dummyPaymentInvoice' => ['dummyPaymentInvoice.dateOfBirth'],
        'dummyPaymentCreditCard' => [
            'dummyPaymentCreditCard.cardType',
            'dummyPaymentCreditCard.cardNumber',
            'dummyPaymentCreditCard.nameOnCard',
            'dummyPaymentCreditCard.cardExpiresMonth',
            'dummyPaymentCreditCard.cardExpiresYear',
            'dummyPaymentCreditCard.cardSecurityCode',
        ],
    ];

    /**
     * @uses \Spryker\Shared\DummyPayment\DummyPaymentConfig::PROVIDER_NAME
     */
    protected const DUMMY_PAYMENT_PROVIDER_NAME = 'DummyPayment';

    /**
     * @uses \Spryker\Shared\DummyPayment\DummyPaymentConfig::PAYMENT_METHOD_NAME_INVOICE
     */
    protected const DUMMY_PAYMENT_PAYMENT_METHOD_NAME_INVOICE = 'invoice';

    /**
     * @uses \Spryker\Shared\DummyPayment\DummyPaymentConfig::PAYMENT_METHOD_NAME_CREDIT_CARD
     */
    protected const DUMMY_PAYMENT_PAYMENT_METHOD_NAME_CREDIT_CARD = 'credit card';

    /**
     * @uses \Spryker\Shared\DummyPayment\DummyPaymentConfig::PAYMENT_METHOD_INVOICE
     */
    protected const PAYMENT_METHOD_INVOICE = 'dummyPaymentInvoice';

    /**
     * @uses \Spryker\Shared\DummyPayment\DummyPaymentConfig::PAYMENT_METHOD_CREDIT_CARD
     */
    protected const PAYMENT_METHOD_CREDIT_CARD = 'dummyPaymentCreditCard';

    /**
     * @return array
     */
    public function getPaymentProviderMethodToStateMachineMapping(): array
    {
        return [
            static::DUMMY_PAYMENT_PROVIDER_NAME => [
                static::DUMMY_PAYMENT_PAYMENT_METHOD_NAME_CREDIT_CARD => static::PAYMENT_METHOD_CREDIT_CARD,
                static::DUMMY_PAYMENT_PAYMENT_METHOD_NAME_INVOICE => static::PAYMENT_METHOD_INVOICE,
            ],
        ];
    }
}
