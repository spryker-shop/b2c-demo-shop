<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Checkout\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\Checkout\CheckoutApiTester;
use PyzTest\Glue\Checkout\RestApi\Fixtures\GuestCheckoutDataShipmentRelationshipsFixtures;
use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig;
use Spryker\Glue\ShipmentsRestApi\ShipmentsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Checkout
 * @group RestApi
 * @group GuestCheckoutDataRelationshipsCest
 * Add your own group annotations below this line
 */
class GuestCheckoutDataRelationshipsCest
{
    /**
     * @var string
     */
    protected const HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID = 'X-Anonymous-Customer-Unique-Id';

    /**
     * @var \PyzTest\Glue\Checkout\RestApi\Fixtures\GuestCheckoutDataShipmentRelationshipsFixtures
     */
    protected GuestCheckoutDataShipmentRelationshipsFixtures $guestCheckoutDataShipmentRelationshipsFixtures;

    /**
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function loadShipmentFixtures(CheckoutApiTester $I): void
    {
        /** @var \PyzTest\Glue\Checkout\RestApi\Fixtures\GuestCheckoutDataShipmentRelationshipsFixtures $fixtures */
        $fixtures = $I->loadFixtures(GuestCheckoutDataShipmentRelationshipsFixtures::class);
        $this->guestCheckoutDataShipmentRelationshipsFixtures = $fixtures;
    }

    /**
     * @depends loadShipmentFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestCheckoutDataIncludesShipmentsRelationship(CheckoutApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(
            static::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $this->guestCheckoutDataShipmentRelationshipsFixtures->getGuestCustomerReference(),
        );

        $url = $I->buildCheckoutDataUrl([
            ShipmentsRestApiConfig::RESOURCE_SHIPMENTS,
        ]);
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $this->guestCheckoutDataShipmentRelationshipsFixtures->getGuestQuoteTransfer()->getUuid(),
                ],
            ],
        ];

        $shipmentMethodTransfer = $this->guestCheckoutDataShipmentRelationshipsFixtures->getShipmentMethodTransfer();

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The response contains included shipments')
            ->whenI()
            ->seeIncludesContainResourceOfType(ShipmentsRestApiConfig::RESOURCE_SHIPMENTS);

        $jsonPath = sprintf('$..included[?(@.type == \'%s\')]', 'shipments');
        $shipments = $I->getDataFromResponseByJsonPath($jsonPath)[0];

        $I->amSure('The response contains includes expected shipments resource')
            ->whenI()
            ->assertNotNull($shipments);
        $I->amSure('The included shipments resource contains correct attributes')
            ->whenI()
            ->assertSame(
                [$this->guestCheckoutDataShipmentRelationshipsFixtures->getGuestQuoteTransfer()->getItems()->offsetGet(0)->getGroupKey()],
                $shipments['attributes']['items'],
            );
        $I->amSure('The included shipments resource contains correct attributes')
            ->whenI()
            ->assertArraySubset(
                [
                    'id' => $shipmentMethodTransfer->getIdShipmentMethod(),
                    'name' => $shipmentMethodTransfer->getName(),
                    'carrierName' => $shipmentMethodTransfer->getCarrierName(),
                ],
                $shipments['attributes']['selectedShipmentMethod'],
            );
    }

    /**
     * @depends loadShipmentFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestCheckoutDataIncludesShipmentMethodsRelationship(CheckoutApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(
            static::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $this->guestCheckoutDataShipmentRelationshipsFixtures->getGuestCustomerReference(),
        );

        $url = $I->buildCheckoutDataUrl([
            ShipmentsRestApiConfig::RESOURCE_SHIPMENTS,
            ShipmentsRestApiConfig::RESOURCE_SHIPMENT_METHODS,
        ]);
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $this->guestCheckoutDataShipmentRelationshipsFixtures->getGuestQuoteTransfer()->getUuid(),
                ],
            ],
        ];

        $shipmentMethodTransfer = $this->guestCheckoutDataShipmentRelationshipsFixtures->getShipmentMethodTransfer();

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The response contains included shipment methods')
            ->whenI()
            ->seeIncludesContainResourceOfType(ShipmentsRestApiConfig::RESOURCE_SHIPMENT_METHODS);
        $I->amSure('The response contains includes expected shipment-methods resource')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(
                ShipmentsRestApiConfig::RESOURCE_SHIPMENT_METHODS,
                $shipmentMethodTransfer->getIdShipmentMethod(),
            );
        $I->amSure('The included shipment-methods resource contains correct attributes')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdContainsAttributes(
                ShipmentsRestApiConfig::RESOURCE_SHIPMENT_METHODS,
                $shipmentMethodTransfer->getIdShipmentMethodOrFail(),
                [
                    'name' => $shipmentMethodTransfer->getNameOrFail(),
                    'carrierName' => $shipmentMethodTransfer->getCarrierNameOrFail(),
                ],
            );
    }
}
