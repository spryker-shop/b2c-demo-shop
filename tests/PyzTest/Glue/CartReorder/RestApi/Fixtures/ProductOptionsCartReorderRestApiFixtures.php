<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\CartReorder\RestApi\Fixtures;

use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductOptionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PyzTest\Glue\CartReorder\CartReorderApiTester;
use Spryker\Zed\ProductOption\Communication\Plugin\Checkout\ProductOptionOrderSaverPlugin;
use SprykerTest\Shared\ProductOption\Helper\ProductOptionGroupDataHelper;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Carts
 * @group RestApi
 * @group ProductOptionsCartReorderRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductOptionsCartReorderRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'ProductConcreteCartReorderRestApiFixtures';

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer
     */
    protected StoreTransfer $storeTransfer;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerTransfer;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productConcreteTransfer;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productConcreteTransferWithProductOptions;

    /**
     * @var \Generated\Shared\Transfer\ProductOptionTransfer
     */
    protected ProductOptionTransfer $productOptionTransfer;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer
     */
    protected SaveOrderTransfer $orderWithProductOptions;

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getProductConcreteTransferWithProductOptions(): ProductConcreteTransfer
    {
        return $this->productConcreteTransferWithProductOptions;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductOptionTransfer
     */
    public function getProductOptionTransfer(): ProductOptionTransfer
    {
        return $this->productOptionTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    public function getOrderWithProductOptions(): SaveOrderTransfer
    {
        return $this->orderWithProductOptions;
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(CartReorderApiTester $I): FixturesContainerInterface
    {
        $I->configureStateMachine();
        $this->storeTransfer = $I->getCurrentStore();
        $this->customerTransfer = $I->createCustomer(static::TEST_USERNAME);

        $this->productConcreteTransfer = $I->createProductWithPriceAndStock($this->storeTransfer);
        $this->productConcreteTransferWithProductOptions = $I->createProductWithPriceAndStock($this->storeTransfer);
        $this->productOptionTransfer = $this->createProductOption($I);

        $this->orderWithProductOptions = $this->createOrderWithProductOptions($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return \Generated\Shared\Transfer\ProductOptionTransfer
     */
    protected function createProductOption(CartReorderApiTester $I): ProductOptionTransfer
    {
        $productOptionGroupTransfer = $I->haveProductOptionGroupWithValues(
            [],
            [
                [
                    [],
                    [
                        [
                            ProductOptionGroupDataHelper::STORE_NAME => $this->storeTransfer->getName(),
                            MoneyValueTransfer::GROSS_AMOUNT => 123,
                            MoneyValueTransfer::NET_AMOUNT => 123,
                        ],
                    ],
                ],
            ],
        );
        /** @var \Generated\Shared\Transfer\ProductOptionValueTransfer $productOptionValueTransfer */
        $productOptionValueTransfer = $productOptionGroupTransfer->getProductOptionValues()->getIterator()->current();

        return (new ProductOptionTransfer())
            ->fromArray($productOptionValueTransfer->toArray(), true)
            ->setGroupName($productOptionGroupTransfer->getNameOrFail())
            ->setQuantity(1)
            ->setUnitGrossPrice(333)
            ->setTaxRate(19.00);
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    protected function createOrderWithProductOptions(CartReorderApiTester $I): SaveOrderTransfer
    {
        $itemsData = [
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productConcreteTransfer->getSkuOrFail(),
                ItemTransfer::QUANTITY => 1,
            ]))->build()->toArray(),
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productConcreteTransferWithProductOptions->getSkuOrFail(),
                ItemTransfer::QUANTITY => 2,
                ItemTransfer::PRODUCT_OPTIONS => [$this->productOptionTransfer->toArray()],
            ]))->build()->toArray(),
        ];

        return $I->createOrder(
            $this->customerTransfer,
            [QuoteTransfer::ITEMS => $itemsData],
            [new ProductOptionOrderSaverPlugin()],
        );
    }
}
