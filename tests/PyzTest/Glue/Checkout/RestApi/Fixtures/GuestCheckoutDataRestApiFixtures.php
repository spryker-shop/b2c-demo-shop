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
 * @group GuestCheckoutDataRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class GuestCheckoutDataRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const ANONYMOUS_PREFIX = 'anonymous:';

    protected string $guestCustomerReference;

    protected CustomerTransfer $guestCustomerTransfer;

    protected QuoteTransfer $guestQuoteTransfer;

    protected ShipmentMethodTransfer $shipmentMethodTransfer;

    public function getGuestCustomerReference(): string
    {
        return $this->guestCustomerReference;
    }

    public function getGuestCustomerTransfer(): CustomerTransfer
    {
        return $this->guestCustomerTransfer;
    }

    public function getGuestQuoteTransfer(): QuoteTransfer
    {
        return $this->guestQuoteTransfer;
    }

    public function getShipmentMethodTransfer(): ShipmentMethodTransfer
    {
        return $this->shipmentMethodTransfer;
    }

    public function buildFixtures(CheckoutApiTester $I): FixturesContainerInterface
    {
        $I->truncateSalesOrderThresholds();

        $this->guestCustomerReference = $I->createGuestCustomerReference();
        $this->guestCustomerTransfer = $I->createCustomerTransfer([
            CustomerTransfer::CUSTOMER_REFERENCE => static::ANONYMOUS_PREFIX . $this->guestCustomerReference,
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

        $this->guestQuoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $this->guestCustomerTransfer,
            [$I->getQuoteItemOverrideData($I->haveProductWithStock(), $this->shipmentMethodTransfer, 10)],
        );

        return $this;
    }
}
