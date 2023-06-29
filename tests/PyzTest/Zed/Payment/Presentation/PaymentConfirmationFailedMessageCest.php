<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Payment\Presentation;

use Generated\Shared\Transfer\PaymentConfirmationFailedTransfer;
use PyzTest\Zed\Payment\PaymentTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Payment
 * @group Presentation
 * @group PaymentConfirmationFailedMessageCest
 * Add your own group annotations below this line
 */
class PaymentConfirmationFailedMessageCest
{
    /**
     * @var string
     */
    protected const INITIAL_ITEM_STATE = 'payment confirmation pending';

    /**
     * @var string
     */
    public const FINAL_ITEM_STATE = 'payment failed';

    /**
     * @param \PyzTest\Zed\Payment\PaymentTester $I
     *
     * @return void
     */
    public function testPaymentConfirmationFailedMessageIsSuccessfullyHandled(PaymentTester $I): void
    {
        // Arrange
        $salesOrderEntity = $I->haveSalesOrder(static::INITIAL_ITEM_STATE);
        $paymentConfirmationFailedTransfer = $I->havePaymentMessageTransfer(
            PaymentConfirmationFailedTransfer::class,
            $salesOrderEntity,
        );

        // Act
        $I->handlePaymentMessageTransfer($paymentConfirmationFailedTransfer);

        // Assert
        $I->assertOrderHasCorrectState($salesOrderEntity, static::FINAL_ITEM_STATE);
    }
}
