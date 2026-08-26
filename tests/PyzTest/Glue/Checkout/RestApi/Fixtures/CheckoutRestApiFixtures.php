<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Checkout\RestApi\Fixtures;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use PyzTest\Glue\Checkout\CheckoutApiTester;
use SprykerTest\Shared\Shipment\Helper\ShipmentMethodDataHelper;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Checkout
 * @group RestApi
 * @group CheckoutRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CheckoutRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'CheckoutRestApiFixtures';

    /**
     * @var string
     */
    protected const TEST_USERNAME_2 = 'CheckoutRestApiFixtures2';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    /**
     * @var int
     */
    protected const PRODUCT_CONCRETES_GENERATE_NUMBER = 100;

    protected CustomerTransfer $customerTransfer;

    protected CustomerTransfer $customerTransferWithPersistedAddress;

    /**
     * @var array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    protected array $productConcreteTransfers;

    protected QuoteTransfer $emptyQuoteTransfer;

    protected ShipmentMethodTransfer $shipmentMethodTransfer;

    protected AddressTransfer $customerAddress;

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    public function getCustomerTransferWithPersistedAddress(): CustomerTransfer
    {
        return $this->customerTransferWithPersistedAddress;
    }

    /**
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function getProductConcreteTransfers(): array
    {
        return $this->productConcreteTransfers;
    }

    public function getEmptyQuoteTransfer(): QuoteTransfer
    {
        return $this->emptyQuoteTransfer;
    }

    public function getShipmentMethodTransfer(): ShipmentMethodTransfer
    {
        return $this->shipmentMethodTransfer;
    }

    public function getCustomerAddress(): AddressTransfer
    {
        return $this->customerAddress;
    }

    public function buildFixtures(CheckoutApiTester $I): FixturesContainerInterface
    {
        $I->truncateSalesOrderThresholds();

        $customerTransfer = $I->haveCustomer([
            CustomerTransfer::USERNAME => static::TEST_USERNAME,
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        $this->customerTransfer = $I->confirmCustomer($customerTransfer);
        for ($i = 0; $i < static::PRODUCT_CONCRETES_GENERATE_NUMBER; $i++) {
            $this->productConcreteTransfers[] = $I->haveProductWithStock();
        }

        $customerTransferWithPersistedAddress = $I->haveCustomerWithPersistentAddress([
            CustomerTransfer::USERNAME => static::TEST_USERNAME_2,
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        $this->customerTransferWithPersistedAddress = $I->confirmCustomer($customerTransferWithPersistedAddress);

        $this->emptyQuoteTransfer = $I->haveEmptyPersistentQuote([
            CustomerTransfer::CUSTOMER_REFERENCE => $this->customerTransfer->getCustomerReference(),
        ]);

        $this->shipmentMethodTransfer = $I->haveShipmentMethod(
            [
                ShipmentMethodTransfer::CARRIER_NAME => 'Spryker Dummy Shipment',
                ShipmentMethodTransfer::NAME => 'Standard',
            ],
            [],
            ShipmentMethodDataHelper::DEFAULT_PRICE_LIST,
            [
                $I->getStoreFacade()->getCurrentStore()->getIdStore(),
            ],
        );

        $this->customerAddress = $I->haveCustomerAddress([
            AddressTransfer::FK_CUSTOMER => $this->customerTransfer->getIdCustomer(),
            AddressTransfer::FK_COUNTRY => $I->haveCountry()->getIdCountry(),
        ]);

        return $this;
    }
}
