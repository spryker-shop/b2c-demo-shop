<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\OrderAmendments\RestApi\Fixtures;

use ArrayObject;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Carts
 * @group RestApi
 * @group OrderAmendmentRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class OrderAmendmentRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'OrderAmendmentRestApiFixtures';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    /**
     * @var string
     */
    protected const STATE_MACHINE_NAME = 'DummyPayment01';

    /**
     * @var string
     */
    protected const ORDER_ITEM_STATE_GRACE_PERIOD_STARTED = 'grace period started';

    /**
     * @var string
     */
    protected const ORDER_ITEM_STATE_PAID = 'paid';

    /**
     * @var string
     */
    protected const PRICE_MODE_GROSS = 'GROSS_MODE';

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerTransfer;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer
     */
    protected SaveOrderTransfer $readyForAmendmentOrderTransfer;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer
     */
    protected SaveOrderTransfer $notReadyForAmendmentOrderTransfer;

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    public function getReadyForAmendmentOrderTransfer(): SaveOrderTransfer
    {
        return $this->readyForAmendmentOrderTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    public function getNotReadyForAmendmentOrderTransfer(): SaveOrderTransfer
    {
        return $this->notReadyForAmendmentOrderTransfer;
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(OrderAmendmentsApiTester $I): FixturesContainerInterface
    {
        $this->configureStateMachine($I);
        $this->customerTransfer = $this->createCustomerTransfer($I);

        $this->readyForAmendmentOrderTransfer = $this->createOrderWithProductConcretes($I);
        $this->setOrderItemsState(
            $I,
            $this->readyForAmendmentOrderTransfer->getOrderItems(),
            static::ORDER_ITEM_STATE_GRACE_PERIOD_STARTED,
        );

        $this->notReadyForAmendmentOrderTransfer = $this->createOrderWithProductConcretes($I);
        $this->setOrderItemsState(
            $I,
            $this->notReadyForAmendmentOrderTransfer->getOrderItems(),
            static::ORDER_ITEM_STATE_PAID,
        );

        return $this;
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function createCustomerTransfer(OrderAmendmentsApiTester $I): CustomerTransfer
    {
        $customerTransfer = $I->haveCustomer([
            CustomerTransfer::USERNAME => static::TEST_USERNAME,
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        return $I->confirmCustomer($customerTransfer);
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    protected function createOrderWithProductConcretes(OrderAmendmentsApiTester $I): SaveOrderTransfer
    {
        $product1Transfer = $I->haveProductWithPriceAndStock();
        $product2Transfer = $I->haveProductWithPriceAndStock();
        $quoteTransfer = (new QuoteBuilder())
            ->withCustomer([CustomerTransfer::CUSTOMER_REFERENCE => $this->customerTransfer->getCustomerReference()])
            ->withItem([
                ItemTransfer::SKU => $product1Transfer->getSkuOrFail(),
                ItemTransfer::QUANTITY => 1,
            ])
            ->withItem([
                ItemTransfer::SKU => $product2Transfer->getSkuOrFail(),
                ItemTransfer::QUANTITY => 2,
            ])
            ->withTotals()
            ->withShippingAddress()
            ->withBillingAddress()
            ->withCurrency()
            ->withPayment()
            ->build();

        $quoteTransfer->setPriceMode(static::PRICE_MODE_GROSS);

        return $I->haveOrderFromQuote($quoteTransfer, static::STATE_MACHINE_NAME);
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     * @param \ArrayObject<array-key, \Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     * @param string $stateName
     *
     * @return void
     */
    protected function setOrderItemsState(OrderAmendmentsApiTester $I, ArrayObject $itemTransfers, string $stateName): void
    {
        foreach ($itemTransfers as $itemTransfer) {
            $I->setItemState($itemTransfer->getIdSalesOrderItemOrFail(), $stateName);
        }
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return void
     */
    protected function configureStateMachine(OrderAmendmentsApiTester $I): void
    {
        $I->configureTestStateMachine([static::STATE_MACHINE_NAME]);
    }
}
