<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Carts\RestApi\Fixtures;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
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
 * @group ConvertGuestCartToCustomerCartRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ConvertGuestCartToCustomerCartRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    use CartsRestApiFixturesTrait;

    /**
     * @var string
     */
    protected const TEST_USERNAME = 'UserConvertGuestCartToCustomerCartRestApiFixtures';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    /**
     * @var string
     */
    protected const ANONYMOUS_PREFIX = 'anonymous:';

    protected ProductConcreteTransfer $productConcreteTransfer;

    protected CustomerTransfer $customerTransfer;

    protected string $guestCustomerReference;

    protected QuoteTransfer $guestQuoteTransfer;

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    public function getGuestCustomerReference(): string
    {
        return $this->guestCustomerReference;
    }

    public function getGuestQuoteTransfer(): QuoteTransfer
    {
        return $this->guestQuoteTransfer;
    }

    public function buildFixtures(CartsApiTester $I): FixturesContainerInterface
    {
        $I->truncateSalesOrderThresholds();

        $this->createGuestQuote($I);
        $this->createCustomer($I);

        return $this;
    }

    protected function createGuestQuote(CartsApiTester $I): void
    {
        $this->productConcreteTransfer = $this->createProduct($I);
        $this->guestCustomerReference = $this->createGuestCustomerReference();
        $guestCustomerTransfer = (new CustomerTransfer())
            ->setCustomerReference(static::ANONYMOUS_PREFIX . $this->guestCustomerReference);
        $this->guestQuoteTransfer = $this->createPersistentQuote($I, $guestCustomerTransfer, [$this->productConcreteTransfer]);
    }

    protected function createCustomer(CartsApiTester $I): void
    {
        $customerTransfer = $I->haveCustomer([
            CustomerTransfer::USERNAME => static::TEST_USERNAME,
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        $this->customerTransfer = $I->confirmCustomer($customerTransfer);
    }
}
