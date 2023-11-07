<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\UpSellingProducts\RestApi;

use Generated\Shared\DataBuilder\StoreRelationBuilder;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group UpSellingProducts
 * @group RestApi
 * @group CartsUpSellingProductsRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CartUpSellingProductsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'UserCartsUpSellingProductsRestApiFixtures';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productConcreteTransfer;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $upSellingProductConcreteTransfer;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer
     */
    protected QuoteTransfer $quoteTransfer;

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getQuoteTransfer(): QuoteTransfer
    {
        return $this->quoteTransfer;
    }

    /**
     * @param \PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(UpSellingProductsApiTester $I): FixturesContainerInterface
    {
        $I->truncateSalesOrderThresholds();

        $this->createQuoteWithProduct($I);
        $this->createUpSellingProductConcrete($I);
        $this->createRelationBetweenProducts($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester $I
     *
     * @return void
     */
    protected function createQuoteWithProduct(UpSellingProductsApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();

        $customerTransfer = $I->haveCustomer([
            CustomerTransfer::USERNAME => static::TEST_USERNAME,
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        $customerTransfer = $I->confirmCustomer($customerTransfer);

        $this->quoteTransfer = $this->createPersistentQuote($I, $customerTransfer, [$this->productConcreteTransfer]);
    }

    /**
     * @param \PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester $I
     *
     * @return void
     */
    protected function createUpSellingProductConcrete(UpSellingProductsApiTester $I): void
    {
        $this->upSellingProductConcreteTransfer = $I->haveFullProduct();
    }

    /**
     * @param \PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester $I
     *
     * @return void
     */
    protected function createRelationBetweenProducts(UpSellingProductsApiTester $I): void
    {
        $storeTransfer = $I->haveStore([
            StoreTransfer::NAME => 'DE',
            StoreTransfer::DEFAULT_CURRENCY_ISO_CODE => 'EUR',
            StoreTransfer::AVAILABLE_CURRENCY_ISO_CODES => ['EUR'],
        ]);
        $storeRelationTransfer = (new StoreRelationBuilder())->seed([
            StoreRelationTransfer::ID_STORES => [
                $storeTransfer->getIdStore(),
            ],
            StoreRelationTransfer::STORES => [
                $storeTransfer,
            ],
        ])->build();

        $I->haveProductRelation(
            $this->upSellingProductConcreteTransfer->getAbstractSku(),
            $this->productConcreteTransfer->getFkProductAbstract(),
            uniqid('test-', false),
            'up-selling',
            $storeRelationTransfer,
        );
    }

    /**
     * @param \PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester $I
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteTransfers
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createPersistentQuote(
        UpSellingProductsApiTester $I,
        CustomerTransfer $customerTransfer,
        array $productConcreteTransfers,
    ): QuoteTransfer {
        return $I->havePersistentQuote([
            QuoteTransfer::CUSTOMER => $customerTransfer,
            QuoteTransfer::TOTALS => (new TotalsTransfer())
                ->setSubtotal(random_int(1000, 10000))
                ->setPriceToPay(random_int(1000, 10000)),
            QuoteTransfer::ITEMS => $this->mapProductConcreteTransfersToQuoteTransferItems($productConcreteTransfers),
            QuoteTransfer::STORE => [StoreTransfer::NAME => 'DE'],
        ]);
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteTransfers
     *
     * @return array
     */
    protected function mapProductConcreteTransfersToQuoteTransferItems(array $productConcreteTransfers): array
    {
        $quoteTransferItems = [];

        foreach ($productConcreteTransfers as $productConcreteTransfer) {
            $quoteTransferItems[] = [
                ItemTransfer::SKU => $productConcreteTransfer->getSku(),
                ItemTransfer::GROUP_KEY => $productConcreteTransfer->getSku(),
                ItemTransfer::ABSTRACT_SKU => $productConcreteTransfer->getAbstractSku(),
                ItemTransfer::ID_PRODUCT_ABSTRACT => $productConcreteTransfer->getFkProductAbstract(),
                ItemTransfer::UNIT_PRICE => random_int(100, 1000),
                ItemTransfer::QUANTITY => 5,
            ];
        }

        return $quoteTransferItems;
    }
}
