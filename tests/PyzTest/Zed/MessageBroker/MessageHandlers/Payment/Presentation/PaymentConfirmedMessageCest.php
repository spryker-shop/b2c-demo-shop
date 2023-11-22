<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\Payment\Presentation;

use Generated\Shared\Transfer\PaymentConfirmedTransfer;
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
 * @group PaymentConfirmedMessageCest
 * Add your own group annotations below this line
 */
class PaymentConfirmedMessageCest
{
    /**
     * @var string
     */
    protected const INITIAL_ITEM_STATE = 'payment confirmation pending';

    /**
     * @var string
     */
    public const FINAL_ITEM_STATE = 'payment confirmed';

    /**
     * @param \PyzTest\Zed\MessageBroker\PaymentPresentationTester $I
     *
     * @return void
     */
    public function testPaymentConfirmedMessageIsSuccessfullyHandled(PaymentPresentationTester $I): void
    {
        // Arrange
        $salesOrderEntity = $I->haveSalesOrder(static::INITIAL_ITEM_STATE);
        $paymentConfirmedTransfer = $I->havePaymentMessageTransfer(
            PaymentConfirmedTransfer::class,
            $salesOrderEntity,
        );

        // Act
        $I->handlePaymentMessageTransfer($paymentConfirmedTransfer);

        // Assert
        $I->assertOrderHasCorrectState($salesOrderEntity, static::FINAL_ITEM_STATE);
    }
}
