<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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
 * @group ConcreteAlternativeProductsRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ConcreteAlternativeProductsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    protected ProductConcreteTransfer $productConcreteTransfer;

    protected ProductConcreteTransfer $alternativeProductConcreteTransfer;

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function getAlternativeProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->alternativeProductConcreteTransfer;
    }

    public function buildFixtures(AlternativeProductsRestApiTester $I): FixturesContainerInterface
    {
        $this->createAlternativeRelationBetweenProducts($I);

        return $this;
    }

    protected function createAlternativeRelationBetweenProducts(AlternativeProductsRestApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();
        $I->haveProductInStock([StockProductTransfer::SKU => $this->productConcreteTransfer->getSku()]);

        $this->alternativeProductConcreteTransfer = $I->haveFullProduct();
        $I->haveProductInStock([StockProductTransfer::SKU => $this->alternativeProductConcreteTransfer->getSku()]);

        $I->haveProductAlternative($this->productConcreteTransfer, $this->alternativeProductConcreteTransfer->getSku());
    }
}
