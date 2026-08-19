<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Checkout\RestApi\Fixtures;

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
 * @group CheckoutDataShipmentRelationshipsFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CheckoutDataShipmentRelationshipsFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'CheckoutDataRelationshipsFixtures';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    protected CustomerTransfer $customerTransfer;

    protected QuoteTransfer $quoteTransfer;

    protected ShipmentMethodTransfer $shipmentMethodTransfer;

    public function getQuoteTransfer(): QuoteTransfer
    {
        return $this->quoteTransfer;
    }

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    public function getShipmentMethodTransfer(): ShipmentMethodTransfer
    {
        return $this->shipmentMethodTransfer;
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

        $this->shipmentMethodTransfer = $I->haveShipmentMethod(
            [
                ShipmentMethodTransfer::CARRIER_NAME => 'Spryker Dummy Shipment with Shipment Type',
                ShipmentMethodTransfer::NAME => 'Standard with Shipment Type',
            ],
            [],
            ShipmentMethodDataHelper::DEFAULT_PRICE_LIST,
            [
                $I->getStoreFacade()->getCurrentStore()->getIdStore(),
            ],
        );

        $this->quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $this->customerTransfer,
            [$I->getQuoteItemOverrideData($I->haveProductWithStock(), $this->shipmentMethodTransfer, 10)],
        );

        return $this;
    }
}
