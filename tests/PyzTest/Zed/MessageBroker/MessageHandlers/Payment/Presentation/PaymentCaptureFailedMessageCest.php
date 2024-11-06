<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\Payment\Presentation;

use Generated\Shared\Transfer\PaymentCaptureFailedTransfer;
use PyzTest\Zed\MessageBroker\PaymentPresentationTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group MessageBroker
 * @group MessageHandlers
 * @group Payment
 * @group Presentation
 * @group PaymentCaptureFailedMessageCest
 * Add your own group annotations below this line
 */
class PaymentCaptureFailedMessageCest
{
    /**
     * @var string
     */
    protected const INITIAL_ITEM_STATE = 'payment pending';

    /**
     * @var string
     */
    protected const INITIAL_ITEM_STATE_AFTER_AUTHORIZATION = 'payment capture pending';

    /**
     * @var string
     */
    public const FINAL_ITEM_STATE = 'payment failed';

    /**
     * @param \PyzTest\Zed\MessageBroker\PaymentPresentationTester $i
     *
     * @return void
     */
    public function _before(PaymentPresentationTester $i): void
    {
        $i->amZed();
        $i->amLoggedInUser();
    }

    /**
     * @param \PyzTest\Zed\MessageBroker\PaymentPresentationTester $I
     *
     * @return void
     */
    public function testPaymentCaptureFailedMessageIsSuccessfullyHandled(PaymentPresentationTester $I): void
    {
        // Arrange
        $salesOrderEntity = $I->haveSalesOrder(static::INITIAL_ITEM_STATE);
        $capturePaymentFailedTransfer = $I->havePaymentMessageTransfer(
            PaymentCaptureFailedTransfer::class,
            $salesOrderEntity,
        );

        // Act
        $I->handlePaymentMessageTransfer($capturePaymentFailedTransfer);

        // Assert
        $I->assertOrderHasCorrectState($salesOrderEntity, static::FINAL_ITEM_STATE);
    }

    /**
     * @param \PyzTest\Zed\MessageBroker\PaymentPresentationTester $I
     *
     * @return void
     */
    public function testPaymentCaptureFailedMessageIsSuccessfullyHandledWhenItemWasAuthorized(PaymentPresentationTester $I): void
    {
        // Arrange
        $salesOrderEntity = $I->haveSalesOrder(static::INITIAL_ITEM_STATE_AFTER_AUTHORIZATION);
        $capturePaymentFailedTransfer = $I->havePaymentMessageTransfer(
            PaymentCaptureFailedTransfer::class,
            $salesOrderEntity,
        );

        // Act
        $I->handlePaymentMessageTransfer($capturePaymentFailedTransfer);

        // Assert
        $I->assertOrderHasCorrectState($salesOrderEntity, static::FINAL_ITEM_STATE);
    }
}
