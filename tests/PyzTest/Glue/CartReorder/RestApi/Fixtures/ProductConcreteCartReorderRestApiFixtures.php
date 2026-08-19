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
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Generated\Shared\Transfer\StockProductTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PyzTest\Glue\CartReorder\CartReorderApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Carts
 * @group RestApi
 * @group ProductConcreteCartReorderRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductConcreteCartReorderRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'ProductConcreteCartReorderRestApiFixtures';

    protected StoreTransfer $storeTransfer;

    protected CustomerTransfer $customerTransfer;

    protected ProductConcreteTransfer $productConcreteTransfer1;

    protected ProductConcreteTransfer $productConcreteTransfer2;

    protected ProductConcreteTransfer $notAvailableProductConcreteTransfer;

    protected SaveOrderTransfer $orderWithConcreteProducts;

    protected SaveOrderTransfer $orderWithNotAvailableConcreteProduct;

    protected SaveOrderTransfer $orderFromAnotherCustomer;

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    public function getProductConcreteTransfer1(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer1;
    }

    public function getProductConcreteTransfer2(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer2;
    }

    public function getNotAvailableProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->notAvailableProductConcreteTransfer;
    }

    public function getOrderWithConcreteProducts(): SaveOrderTransfer
    {
        return $this->orderWithConcreteProducts;
    }

    public function getOrderWithNotAvailableConcreteProduct(): SaveOrderTransfer
    {
        return $this->orderWithNotAvailableConcreteProduct;
    }

    public function getOrderFromAnotherCustomer(): SaveOrderTransfer
    {
        return $this->orderFromAnotherCustomer;
    }

    public function buildFixtures(CartReorderApiTester $I): FixturesContainerInterface
    {
        $I->configureStateMachine();
        $this->storeTransfer = $I->getCurrentStore();
        $this->customerTransfer = $I->createCustomer(static::TEST_USERNAME);

        $this->productConcreteTransfer1 = $I->createProductWithPriceAndStock($this->storeTransfer);
        $this->productConcreteTransfer2 = $I->createProductWithPriceAndStock($this->storeTransfer);
        $this->notAvailableProductConcreteTransfer = $this->createNotAvailableProductConcrete($I);

        $this->orderWithConcreteProducts = $this->createOrderWithConcreteProducts($I);
        $this->orderWithNotAvailableConcreteProduct = $this->createOrderWithNotAvailableConcreteProduct($I);
        $this->orderFromAnotherCustomer = $this->createOrderFromAnotherCustomer($I);

        return $this;
    }

    protected function createNotAvailableProductConcrete(CartReorderApiTester $I): ProductConcreteTransfer
    {
        $productConcreteTransfer = $I->haveFullProduct();
        $I->havePriceProduct([
            PriceProductTransfer::SKU_PRODUCT_ABSTRACT => $productConcreteTransfer->getAbstractSkuOrFail(),
            PriceProductTransfer::SKU_PRODUCT => $productConcreteTransfer->getSkuOrFail(),
            PriceProductTransfer::ID_PRODUCT => $productConcreteTransfer->getIdProductConcreteOrFail(),
            PriceProductTransfer::PRICE_TYPE_NAME => CartReorderApiTester::PRICE_TYPE,
            PriceProductTransfer::MONEY_VALUE => [
                MoneyValueTransfer::NET_AMOUNT => 777,
                MoneyValueTransfer::GROSS_AMOUNT => 888,
            ],
        ]);
        $I->haveProductInStockForStore($this->storeTransfer, [
            StockProductTransfer::SKU => $productConcreteTransfer->getSku(),
            StockProductTransfer::IS_NEVER_OUT_OF_STOCK => 0,
            StockProductTransfer::QUANTITY => 0,
        ]);

        return $productConcreteTransfer;
    }

    protected function createOrderWithConcreteProducts(CartReorderApiTester $I): SaveOrderTransfer
    {
        $itemsData = [
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productConcreteTransfer1->getSkuOrFail(),
                ItemTransfer::QUANTITY => 2,
            ]))->build()->toArray(),
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productConcreteTransfer2->getSkuOrFail(),
                ItemTransfer::QUANTITY => 1,
            ]))->build()->toArray(),
        ];

        return $I->createOrder($this->customerTransfer, [QuoteTransfer::ITEMS => $itemsData]);
    }

    protected function createOrderWithNotAvailableConcreteProduct(CartReorderApiTester $I): SaveOrderTransfer
    {
        $itemsData = [
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productConcreteTransfer1->getSkuOrFail(),
                ItemTransfer::QUANTITY => 2,
            ]))->build()->toArray(),
            (new ItemBuilder([
                ItemTransfer::SKU => $this->notAvailableProductConcreteTransfer->getSkuOrFail(),
                ItemTransfer::QUANTITY => 1,
            ]))->build()->toArray(),
        ];

        return $I->createOrder($this->customerTransfer, [QuoteTransfer::ITEMS => $itemsData]);
    }

    protected function createOrderFromAnotherCustomer(CartReorderApiTester $I): SaveOrderTransfer
    {
        $itemsData = [
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productConcreteTransfer1->getSkuOrFail(),
                ItemTransfer::QUANTITY => 2,
            ]))->build()->toArray(),
            (new ItemBuilder([
                ItemTransfer::SKU => $this->notAvailableProductConcreteTransfer->getSkuOrFail(),
                ItemTransfer::QUANTITY => 1,
            ]))->build()->toArray(),
        ];

        return $I->createOrder($I->haveCustomer(), [QuoteTransfer::ITEMS => $itemsData]);
    }
}
