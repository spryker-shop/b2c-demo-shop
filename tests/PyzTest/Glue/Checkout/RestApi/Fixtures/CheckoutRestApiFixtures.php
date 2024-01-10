<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerTransfer;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerTransferWithPersistedAddress;

    /**
     * @var array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    protected array $productConcreteTransfers;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer
     */
    protected QuoteTransfer $emptyQuoteTransfer;

    /**
     * @var \Generated\Shared\Transfer\ShipmentMethodTransfer
     */
    protected ShipmentMethodTransfer $shipmentMethodTransfer;

    /**
     * @var \Generated\Shared\Transfer\AddressTransfer
     */
    protected AddressTransfer $customerAddress;

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
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

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getEmptyQuoteTransfer(): QuoteTransfer
    {
        return $this->emptyQuoteTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\ShipmentMethodTransfer
     */
    public function getShipmentMethodTransfer(): ShipmentMethodTransfer
    {
        return $this->shipmentMethodTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    public function getCustomerAddress(): AddressTransfer
    {
        return $this->customerAddress;
    }

    /**
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
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
