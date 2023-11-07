<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Checkout\RestApi\Fixtures;

use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\PaymentProviderTransfer;
use PyzTest\Glue\Checkout\CheckoutApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Checkout
 * @group RestApi
 * @group PaymentMethodsFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class PaymentMethodsFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(CheckoutApiTester $I): FixturesContainerInterface
    {
        $paymentProviderTransfer = $I->havePaymentProvider([
            PaymentProviderTransfer::PAYMENT_PROVIDER_KEY => 'DummyPayment',
            PaymentProviderTransfer::NAME => 'dummyPayment',
        ]);
        $I->havePaymentMethodWithStore([
            PaymentMethodTransfer::IS_ACTIVE => true,
            PaymentMethodTransfer::PAYMENT_METHOD_KEY => 'dummyPaymentInvoice',
            PaymentMethodTransfer::NAME => 'Invoice',
            PaymentMethodTransfer::ID_PAYMENT_PROVIDER => $paymentProviderTransfer->getIdPaymentProvider(),
        ]);
        $I->havePaymentMethodWithStore([
            PaymentMethodTransfer::IS_ACTIVE => true,
            PaymentMethodTransfer::PAYMENT_METHOD_KEY => 'dummyPaymentCreditCard',
            PaymentMethodTransfer::NAME => 'Credit Card',
            PaymentMethodTransfer::ID_PAYMENT_PROVIDER => $paymentProviderTransfer->getIdPaymentProvider(),
        ]);
        $I->havePaymentMethodWithStore([
            PaymentMethodTransfer::IS_ACTIVE => true,
            PaymentMethodTransfer::PAYMENT_METHOD_KEY => 'foreignPaymentCreditCard',
            PaymentMethodTransfer::NAME => 'Foreign Credit Card',
            PaymentMethodTransfer::ID_PAYMENT_PROVIDER => $paymentProviderTransfer->getIdPaymentProvider(),
            PaymentMethodTransfer::IS_FOREIGN => true,
        ]);

        return $this;
    }
}
