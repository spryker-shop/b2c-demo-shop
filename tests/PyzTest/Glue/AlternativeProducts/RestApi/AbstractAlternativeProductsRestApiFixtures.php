<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\AlternativeProducts\RestApi;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\StockProductTransfer;
use PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group AlternativeProducts
 * @group RestApi
 * @group AbstractAlternativeProductsRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class AbstractAlternativeProductsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productConcreteTransfer;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $alternativeProductConcreteTransfer;

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
    public function getAlternativeProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->alternativeProductConcreteTransfer;
    }

    /**
     * @param \PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(AlternativeProductsRestApiTester $I): FixturesContainerInterface
    {
        $this->createAlternativeRelationBetweenProducts($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester $I
     *
     * @return void
     */
    protected function createAlternativeRelationBetweenProducts(AlternativeProductsRestApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();
        $I->haveProductInStock([StockProductTransfer::SKU => $this->productConcreteTransfer->getSku()]);

        $this->alternativeProductConcreteTransfer = $I->haveFullProduct();
        $I->haveProductInStock([StockProductTransfer::SKU => $this->alternativeProductConcreteTransfer->getSku()]);

        $I->haveProductAlternative($this->productConcreteTransfer, $this->alternativeProductConcreteTransfer->getAbstractSku());
    }
}
