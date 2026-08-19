<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Carts\RestApi\Fixtures;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use PyzTest\Glue\Carts\CartsApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Carts
 * @group RestApi
 * @group GuestCartsRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class GuestCartsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    use CartsRestApiFixturesTrait;

    /**
     * @var int
     */
    public const QUANTITY_FOR_ITEM_UPDATE = 33;

    /**
     * @var string
     */
    public const TEST_GUEST_CART_NAME = 'Test guest cart name';

    /**
     * @var string
     */
    public const CURRENCY_EUR = 'EUR';

    /**
     * @var string
     */
    public const ANONYMOUS_PREFIX = 'anonymous:';

    protected ProductConcreteTransfer $productConcreteTransfer;

    protected ProductConcreteTransfer $productConcreteTransfer1;

    protected ProductConcreteTransfer $productConcreteTransfer2;

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function getProductConcreteTransfer1(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer1;
    }

    public function getProductConcreteTransfer2(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer2;
    }

    public function buildFixtures(CartsApiTester $I): FixturesContainerInterface
    {
        $I->truncateSalesOrderThresholds();

        $this->productConcreteTransfer = $I->haveFullProduct();
        $this->productConcreteTransfer1 = $this->createProduct($I);
        $this->productConcreteTransfer2 = $this->createProduct($I);

        return $this;
    }
}
