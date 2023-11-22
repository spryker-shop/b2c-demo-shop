<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\Payment\Presentation;

use Generated\Shared\Transfer\PaymentReservationCanceledTransfer;
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
 * @group PaymentReservationMessageCest
 * Add your own group annotations below this line
 */
class PaymentReservationMessageCest
{
    /**
     * @var string
     */
    protected const INITIAL_ITEM_STATE = 'reservation cancellation pending';

    /**
     * @var string
     */
    public const FINAL_ITEM_STATE = 'reservation cancelled';

    /**
     * @param \PyzTest\Zed\MessageBroker\PaymentPresentationTester $I
     *
     * @return void
     */
    public function testPaymentReservationCanceledMessageIsSuccessfullyHandled(PaymentPresentationTester $I): void
    {
        // Arrange
        $salesOrderEntity = $I->haveSalesOrder(static::INITIAL_ITEM_STATE);
        $paymentReservationCanceledTransfer = $I->havePaymentMessageTransfer(
            PaymentReservationCanceledTransfer::class,
            $salesOrderEntity,
        );

        // Act
        $I->handlePaymentMessageTransfer($paymentReservationCanceledTransfer);

        // Assert
        $I->assertOrderHasCorrectState($salesOrderEntity, static::FINAL_ITEM_STATE);
    }
}
