<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\ProductLabels\RestApi;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductLabelTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PyzTest\Glue\ProductLabels\ProductLabelsApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group ProductLabels
 * @group RestApi
 * @group ProductLabelsRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductLabelsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    protected ProductConcreteTransfer $productConcreteTransfer;

    protected ProductConcreteTransfer $productConcreteTransferWithLabel;

    protected ProductLabelTransfer $productLabelTransfer;

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function getProductConcreteTransferWithLabel(): ProductConcreteTransfer
    {
        return $this->productConcreteTransferWithLabel;
    }

    public function getProductLabelTransfer(): ProductLabelTransfer
    {
        return $this->productLabelTransfer;
    }

    public function buildFixtures(ProductLabelsApiTester $I): FixturesContainerInterface
    {
        $this->createProductConcrete($I);
        $this->createProductConcreteWithProductLabelRelationship($I);

        return $this;
    }

    protected function createProductConcrete(ProductLabelsApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();
    }

    protected function createProductConcreteWithProductLabelRelationship(ProductLabelsApiTester $I): void
    {
        $this->productConcreteTransferWithLabel = $I->haveFullProduct();

        $storeTransfer = $I->haveStore([
            StoreTransfer::NAME => 'DE',
            StoreTransfer::DEFAULT_CURRENCY_ISO_CODE => 'EUR',
            StoreTransfer::AVAILABLE_CURRENCY_ISO_CODES => ['EUR'],
        ]);
        $storeRelationSeedData = [
            StoreRelationTransfer::ID_STORES => [
                $storeTransfer->getIdStore(),
            ],
            StoreRelationTransfer::STORES => [
                $storeTransfer,
            ],
        ];
        $this->productLabelTransfer = $I->haveProductLabel([
            ProductLabelTransfer::STORE_RELATION => $storeRelationSeedData,
        ]);

        $I->haveProductLabelToAbstractProductRelation(
            $this->productLabelTransfer->getIdProductLabel(),
            $this->productConcreteTransferWithLabel->getFkProductAbstract(),
        );
    }
}
