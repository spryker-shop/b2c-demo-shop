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
use Generated\Shared\Transfer\ProductBundleTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductForBundleTransfer;
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
 * @group ProductBundleCartReorderRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductBundleCartReorderRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'ProductBundleCartReorderRestApiFixtures';

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
    protected ProductConcreteTransfer $bundledProductConcreteTransfer1;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $bundledProductConcreteTransfer2;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productBundleTransfer;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer
     */
    protected SaveOrderTransfer $orderWithProductBundle;

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
    public function getBundledProductConcreteTransfer1(): ProductConcreteTransfer
    {
        return $this->bundledProductConcreteTransfer1;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getBundledProductConcreteTransfer2(): ProductConcreteTransfer
    {
        return $this->bundledProductConcreteTransfer2;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getProductBundleTransfer(): ProductConcreteTransfer
    {
        return $this->productBundleTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    public function getOrderWithProductBundle(): SaveOrderTransfer
    {
        return $this->orderWithProductBundle;
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
        $this->bundledProductConcreteTransfer1 = $I->createProductWithPriceAndStock($this->storeTransfer);
        $this->bundledProductConcreteTransfer2 = $I->createProductWithPriceAndStock($this->storeTransfer);
        $this->productBundleTransfer = $this->createProductBundle($I);
        $this->orderWithProductBundle = $this->createOrderWithProductBundle($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected function createProductBundle(CartReorderApiTester $I): ProductConcreteTransfer
    {
        $productConcreteTransfer = $I->haveFullProduct();
        $productConcreteTransfer = $I->haveProductBundle($productConcreteTransfer, [
            ProductBundleTransfer::BUNDLED_PRODUCTS => [
                [
                    ProductForBundleTransfer::ID_PRODUCT_CONCRETE => $this->bundledProductConcreteTransfer1->getIdProductConcreteOrFail(),
                    ProductForBundleTransfer::ID_PRODUCT_BUNDLE => $productConcreteTransfer->getIdProductConcreteOrFail(),
                    ProductForBundleTransfer::QUANTITY => 1,
                ],
                [
                    ProductForBundleTransfer::ID_PRODUCT_CONCRETE => $this->bundledProductConcreteTransfer2->getIdProductConcreteOrFail(),
                    ProductForBundleTransfer::ID_PRODUCT_BUNDLE => $productConcreteTransfer->getIdProductConcreteOrFail(),
                    ProductForBundleTransfer::QUANTITY => 2,
                ],
            ],
        ]);

        $I->haveProductInStockForStore($this->storeTransfer, [
            StockProductTransfer::SKU => $productConcreteTransfer->getSku(),
            StockProductTransfer::IS_NEVER_OUT_OF_STOCK => 1,
        ]);

        $I->havePriceProduct([
            PriceProductTransfer::SKU_PRODUCT_ABSTRACT => $productConcreteTransfer->getAbstractSkuOrFail(),
            PriceProductTransfer::SKU_PRODUCT => $productConcreteTransfer->getSkuOrFail(),
            PriceProductTransfer::ID_PRODUCT => $productConcreteTransfer->getIdProductConcreteOrFail(),
            PriceProductTransfer::PRICE_TYPE_NAME => CartReorderApiTester::PRICE_TYPE,
            PriceProductTransfer::MONEY_VALUE => [
                MoneyValueTransfer::NET_AMOUNT => 7777,
                MoneyValueTransfer::GROSS_AMOUNT => 8888,
            ],
        ]);

        return $productConcreteTransfer;
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    protected function createOrderWithProductBundle(CartReorderApiTester $I): SaveOrderTransfer
    {
        $itemsData = [
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productConcreteTransfer->getSkuOrFail(),
                ItemTransfer::QUANTITY => 1,
            ]))->build()->toArray(),
            (new ItemBuilder([
                ItemTransfer::SKU => $this->productBundleTransfer->getSkuOrFail(),
                ItemTransfer::QUANTITY => 2,
            ]))->build()->toArray(),
        ];

        return $I->createOrder($this->customerTransfer, [QuoteTransfer::ITEMS => $itemsData]);
    }
}
