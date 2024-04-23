<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\Payment\Presentation;

use Generated\Shared\Transfer\PaymentCanceledTransfer;
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
 * @group PaymentCanceledMessageCest
 * Add your own group annotations below this line
 */
class PaymentCanceledMessageCest
{
    /**
     * @var string
     */
    protected const INITIAL_ITEM_STATE = 'payment cancellation pending';

    /**
     * @var string
     */
    public const FINAL_ITEM_STATE = 'payment cancelled';

    /**
     * @var string
     */
    public const NOT_ALLOWED_FOR_CANCEL_ITEM_STATE = 'payment captured';

    /**
     * @param \PyzTest\Zed\MessageBroker\PaymentPresentationTester $I
     *
     * @return void
     */
    public function testPaymentCanceledMessageIsSuccessfullyHandled(PaymentPresentationTester $I): void
    {
        // Arrange
        $salesOrderEntity = $I->haveSalesOrder(static::INITIAL_ITEM_STATE);
        $paymentCanceledTransfer = $I->havePaymentMessageTransfer(
            PaymentCanceledTransfer::class,
            $salesOrderEntity,
        );

        // Act
        $I->handlePaymentMessageTransfer($paymentCanceledTransfer);

        // Assert
        $I->assertOrderHasCorrectState($salesOrderEntity, static::FINAL_ITEM_STATE);
    }

    /**
     * @param \PyzTest\Zed\MessageBroker\PaymentPresentationTester $I
     *
     * @return void
     */
    public function testPaymentCanceledMessageIsIgnoredWhenTransitionIsNotPossible(PaymentPresentationTester $I): void
    {
        // Arrange
        $salesOrderEntity = $I->haveSalesOrder(static::NOT_ALLOWED_FOR_CANCEL_ITEM_STATE);
        $paymentCanceledTransfer = $I->havePaymentMessageTransfer(
            PaymentCanceledTransfer::class,
            $salesOrderEntity,
        );

        // Act
        $I->handlePaymentMessageTransfer($paymentCanceledTransfer);

        // Assert
        $I->assertOrderHasCorrectState($salesOrderEntity, static::NOT_ALLOWED_FOR_CANCEL_ITEM_STATE);
    }
}
