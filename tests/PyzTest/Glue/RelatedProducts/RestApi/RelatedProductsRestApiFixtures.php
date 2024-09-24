<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\RelatedProducts\RestApi;

use Generated\Shared\DataBuilder\StoreRelationBuilder;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PyzTest\Glue\RelatedProducts\RelatedProductsApiTester;
use Spryker\Shared\ProductRelation\ProductRelationTypes;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group RelatedProducts
 * @group RestApi
 * @group RelatedProductsRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class RelatedProductsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productConcreteTransfer;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $anotherProductConcreteTransfer;

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
    public function getAnotherProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->anotherProductConcreteTransfer;
    }

    /**
     * @param \PyzTest\Glue\RelatedProducts\RelatedProductsApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(RelatedProductsApiTester $I): FixturesContainerInterface
    {
        $this->createRelationBetweenProducts($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\RelatedProducts\RelatedProductsApiTester $I
     *
     * @return void
     */
    protected function createRelationBetweenProducts(RelatedProductsApiTester $I): void
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

        $this->productConcreteTransfer = $I->haveFullProduct();
        $this->anotherProductConcreteTransfer = $I->haveFullProduct();

        $I->haveProductRelation(
            $this->anotherProductConcreteTransfer->getAbstractSku(),
            $this->productConcreteTransfer->getFkProductAbstract(),
            uniqid('key-', false),
            ProductRelationTypes::TYPE_RELATED_PRODUCTS,
            $storeRelationTransfer,
        );
        $I->haveProductRelation(
            $this->productConcreteTransfer->getAbstractSku(),
            $this->anotherProductConcreteTransfer->getFkProductAbstract(),
            uniqid('key-', false),
            ProductRelationTypes::TYPE_RELATED_PRODUCTS,
            $storeRelationTransfer,
        );
    }
}
