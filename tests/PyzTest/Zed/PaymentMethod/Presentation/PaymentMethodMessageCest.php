<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\PaymentMethod\Presentation;

use PyzTest\Zed\PaymentMethod\PageObject\PaymentMethodPage;
use PyzTest\Zed\PaymentMethod\PaymentMethodPresentationTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group PaymentMethod
 * @group Presentation
 * @group PaymentMethodMessageCest
 * Add your own group annotations below this line
 */
class PaymentMethodMessageCest
{
    /**
     * @var string
     */
    protected const STORE_REFERENCE = 'dev-DE';

    /**
     * @var string
     */
    protected const PAYMENT_METHOD_NAME = 'payment-method-name';

    /**
     * @var string
     */
    protected const PROVIDER_NAME = 'provider-name';

    /**
     * @param \PyzTest\Zed\PaymentMethod\PaymentMethodPresentationTester $I
     *
     * @return void
     */
    public function testPaymentMethodAddedMessageIsSuccessfullyHandled(PaymentMethodPresentationTester $I): void
    {
        if ($I->seeThatDynamicStoreEnabled()) {
            $I->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $messageBrokerFacade = $I->getLocator()->messageBroker()->facade();
        $storeTransfer = $I->getAllowedStore();
        $I->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);
        $paymentMethodKey = $I->generatePaymentMethodKey(
            static::PROVIDER_NAME,
            static::PAYMENT_METHOD_NAME,
            $storeTransfer->getName(),
        );

        // Act
        $messageBrokerFacade->sendMessage(
            $I->havePaymentMethodAddedTransfer(
                static::STORE_REFERENCE,
                static::PAYMENT_METHOD_NAME,
                static::PROVIDER_NAME,
            ),
        );
        $messageBrokerFacade->startWorker($I->buildMessageBrokerWorkerConfigTransfer(['payment'], 1));

        // Assert
        $I->amZed();
        $I->amLoggedInUser();

        $I->amOnPage(PaymentMethodPage::PAYMENT_METHOD_PAGE_URL);
        $I->wait(10);

        $I->canSee(static::PAYMENT_METHOD_NAME);
        $I->canSee(static::PROVIDER_NAME);
        $I->canSee($paymentMethodKey);

        $I->cleanupPaymentMethodByPaymentMethodKey($paymentMethodKey);
    }

    /**
     * @param \PyzTest\Zed\PaymentMethod\PaymentMethodPresentationTester $I
     *
     * @return void
     */
    public function testPaymentMethodRemovedMessageIsSuccessfullyHandled(PaymentMethodPresentationTester $I): void
    {
        if ($I->seeThatDynamicStoreEnabled()) {
            $I->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $messageBrokerFacade = $I->getLocator()->messageBroker()->facade();
        $storeTransfer = $I->getAllowedStore();
        $I->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);
        $paymentMethodKey = $I->generatePaymentMethodKey(
            static::PROVIDER_NAME,
            static::PAYMENT_METHOD_NAME,
            $storeTransfer->getName(),
        );

        $messageBrokerFacade->sendMessage(
            $I->havePaymentMethodAddedTransfer(
                static::STORE_REFERENCE,
                static::PAYMENT_METHOD_NAME,
                static::PROVIDER_NAME,
            ),
        );
        $messageBrokerWorkerConfigTransfer = $I->buildMessageBrokerWorkerConfigTransfer(['payment'], 1);
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);
        $I->resetInMemoryMessages();

        // Act
        $messageBrokerFacade->sendMessage(
            $I->havePaymentMethodDeletedTransfer(
                static::STORE_REFERENCE,
                static::PAYMENT_METHOD_NAME,
                static::PROVIDER_NAME,
            ),
        );
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);

        // Assert
        $I->amZed();
        $I->amLoggedInUser();

        $I->amOnPage(PaymentMethodPage::PAYMENT_METHOD_PAGE_URL);
        $I->wait(10);

        $I->cantSee(static::PAYMENT_METHOD_NAME);
        $I->cantSee(static::PROVIDER_NAME);
        $I->cantSee($paymentMethodKey);

        $I->cleanupPaymentMethodByPaymentMethodKey($paymentMethodKey);
    }
}
