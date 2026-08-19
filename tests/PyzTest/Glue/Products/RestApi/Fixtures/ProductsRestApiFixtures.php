<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Products\RestApi\Fixtures;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use PyzTest\Glue\Products\ProductsApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Products
 * @group RestApi
 * @group ProductAbstractRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    protected ProductConcreteTransfer $productConcreteTransfer;

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function buildFixtures(ProductsApiTester $I): FixturesContainerInterface
    {
        $this->createProductConcrete($I);

        return $this;
    }

    protected function createProductConcrete(ProductsApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();
    }
}
