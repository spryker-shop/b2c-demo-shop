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
use Generated\Shared\Transfer\ProductConcreteTransfer;
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
 * @group PriceProductOrderAmendmentRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class PriceProductOrderAmendmentRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var int
     */
    public const DEFAULT_UNIT_PRICE_AMOUNT = 10000;

    /**
     * @var int
     */
    public const BIGGER_UNIT_PRICE_AMOUNT = 15000;

    /**
     * @var int
     */
    public const LOWER_UNIT_PRICE_AMOUNT = 5000;

    /**
     * @var string
     */
    protected const TEST_USERNAME = 'PriceProductOrderAmendmentRestApiFixtures';

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
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productWithBiggerPrice;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productWithLowerPrice;

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
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getProductWithBiggerPrice(): ProductConcreteTransfer
    {
        return $this->productWithBiggerPrice;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getProductWithLowerPrice(): ProductConcreteTransfer
    {
        return $this->productWithLowerPrice;
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

        $this->productWithBiggerPrice = $I->haveProductWithPriceAndStock(static::DEFAULT_UNIT_PRICE_AMOUNT);
        $this->productWithLowerPrice = $I->haveProductWithPriceAndStock(static::DEFAULT_UNIT_PRICE_AMOUNT);

        $this->readyForAmendmentOrderTransfer = $this->createOrderWithProductConcretes($I);
        $this->setOrderItemsState(
            $I,
            $this->readyForAmendmentOrderTransfer->getOrderItems(),
            static::ORDER_ITEM_STATE_GRACE_PERIOD_STARTED,
        );

        $I->updatePriceProductStore(
            $this->productWithBiggerPrice->getPrices()[0]->getIdPriceProduct(),
            static::BIGGER_UNIT_PRICE_AMOUNT,
            static::BIGGER_UNIT_PRICE_AMOUNT,
        );

        $I->updatePriceProductStore(
            $this->productWithLowerPrice->getPrices()[0]->getIdPriceProduct(),
            static::LOWER_UNIT_PRICE_AMOUNT,
            static::LOWER_UNIT_PRICE_AMOUNT,
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
        $quoteTransfer = (new QuoteBuilder())
            ->withCustomer([CustomerTransfer::CUSTOMER_REFERENCE => $this->customerTransfer->getCustomerReference()])
            ->withItem([
                ItemTransfer::SKU => $this->productWithBiggerPrice->getSkuOrFail(),
                ItemTransfer::QUANTITY => 1,
                ItemTransfer::UNIT_PRICE => static::DEFAULT_UNIT_PRICE_AMOUNT,
                ItemTransfer::UNIT_GROSS_PRICE => static::DEFAULT_UNIT_PRICE_AMOUNT,
            ])
            ->withItem([
                ItemTransfer::SKU => $this->productWithLowerPrice->getSkuOrFail(),
                ItemTransfer::QUANTITY => 1,
                ItemTransfer::UNIT_PRICE => static::DEFAULT_UNIT_PRICE_AMOUNT,
                ItemTransfer::UNIT_GROSS_PRICE => static::DEFAULT_UNIT_PRICE_AMOUNT,
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
