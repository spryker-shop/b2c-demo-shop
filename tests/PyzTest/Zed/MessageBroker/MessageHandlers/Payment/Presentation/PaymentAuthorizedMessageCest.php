<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\Payment\Presentation;

use Generated\Shared\Transfer\PaymentAuthorizedTransfer;
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
 * @group PaymentAuthorizedMessageCest
 * Add your own group annotations below this line
 */
class PaymentAuthorizedMessageCest
{
    /**
     * @var string
     */
    protected const INITIAL_ITEM_STATE = 'payment pending';

    /**
     * @var string
     */
    public const FINAL_ITEM_STATE = 'payment authorized';

    /**
     * @param \PyzTest\Zed\MessageBroker\PaymentPresentationTester $I
     *
     * @return void
     */
    public function testPaymentAuthorizedMessageIsSuccessfullyHandled(PaymentPresentationTester $I): void
    {
        // Arrange
        $salesOrderEntity = $I->haveSalesOrder(static::INITIAL_ITEM_STATE);
        $paymentAuthorizedTransfer = $I->havePaymentMessageTransfer(
            PaymentAuthorizedTransfer::class,
            $salesOrderEntity,
        );

        // Act
        $I->handlePaymentMessageTransfer($paymentAuthorizedTransfer);

        // Assert
        $I->assertOrderHasCorrectState($salesOrderEntity, static::FINAL_ITEM_STATE);
    }
}
