<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Payment;

use Spryker\Zed\Payment\PaymentConfig as SprykerPaymentConfig;

class PaymentConfig extends SprykerPaymentConfig
{
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
     * @return array
     */
    public function getSalesPaymentMethodTypes(): array
    {
        return [
            static::DUMMY_PAYMENT_PROVIDER_NAME => [
                static::DUMMY_PAYMENT_PAYMENT_METHOD_NAME_CREDIT_CARD,
                static::DUMMY_PAYMENT_PAYMENT_METHOD_NAME_INVOICE,
            ],
        ];
    }
}
