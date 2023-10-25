<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\PaymentMethod\Presentation;

use Generated\Shared\Transfer\MessageAttributesTransfer;
use Generated\Shared\Transfer\PaymentMethodDeletedTransfer;
use PyzTest\Zed\MessageBroker\PageObject\PaymentMethodPage;
use PyzTest\Zed\MessageBroker\PaymentMethodPresentationTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group MessageBroker
 * @group MessageHandlers
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
     * @param \PyzTest\Zed\MessageBroker\PaymentMethodPresentationTester $I
     *
     * @return void
     */
    public function testPaymentMethodAddedMessageIsSuccessfullyHandled(PaymentMethodPresentationTester $I): void
    {
        // Arrange
        $messageBrokerFacade = $I->getLocator()->messageBroker()->facade();

        $paymentMethodKey = $I->generatePaymentMethodKey(
            static::PROVIDER_NAME,
            static::PAYMENT_METHOD_NAME,
        );

        $messageAttributesData = [];

        if (!$I->isDynamicStoreEnabled()) {
            $storeTransfer = $I->getAllowedStore();
            $I->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);
            $messageAttributesData[MessageAttributesTransfer::STORE_REFERENCE] = static::STORE_REFERENCE;
        }

        // Act
        $messageBrokerFacade->sendMessage(
            $I->havePaymentMethodAddedTransfer(
                [
                    PaymentMethodDeletedTransfer::NAME => static::PAYMENT_METHOD_NAME,
                    PaymentMethodDeletedTransfer::PROVIDER_NAME => static::PROVIDER_NAME,
                ],
                $messageAttributesData,
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
     * @param \PyzTest\Zed\MessageBroker\PaymentMethodPresentationTester $I
     *
     * @return void
     */
    public function testPaymentMethodRemovedMessageIsSuccessfullyHandled(PaymentMethodPresentationTester $I): void
    {
        // Arrange
        $messageBrokerFacade = $I->getLocator()->messageBroker()->facade();

        $paymentMethodKey = $I->generatePaymentMethodKey(
            static::PROVIDER_NAME,
            static::PAYMENT_METHOD_NAME,
        );

        $messageAttributesData = [];

        if (!$I->isDynamicStoreEnabled()) {
            $storeTransfer = $I->getAllowedStore();
            $I->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);
            $messageAttributesData[MessageAttributesTransfer::STORE_REFERENCE] = static::STORE_REFERENCE;
        }

        $messageBrokerFacade->sendMessage(
            $I->havePaymentMethodAddedTransfer(
                [
                    PaymentMethodDeletedTransfer::NAME => static::PAYMENT_METHOD_NAME,
                    PaymentMethodDeletedTransfer::PROVIDER_NAME => static::PROVIDER_NAME,
                ],
                $messageAttributesData,
            ),
        );
        $messageBrokerWorkerConfigTransfer = $I->buildMessageBrokerWorkerConfigTransfer(['payment'], 1);
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);
        $I->resetInMemoryMessages();

        // Act
        $messageBrokerFacade->sendMessage(
            $I->havePaymentMethodDeletedTransfer(
                [
                    PaymentMethodDeletedTransfer::NAME => static::PAYMENT_METHOD_NAME,
                    PaymentMethodDeletedTransfer::PROVIDER_NAME => static::PROVIDER_NAME,
                ],
                $messageAttributesData,
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
