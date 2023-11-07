<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Checkout\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\Checkout\CheckoutApiTester;
use PyzTest\Glue\Checkout\RestApi\Fixtures\CheckoutDataShipmentRelationshipsFixtures;
use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig;
use Spryker\Glue\ShipmentsRestApi\ShipmentsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Checkout
 * @group RestApi
 * @group CheckoutDataRelationshipsCest
 * Add your own group annotations below this line
 */
class CheckoutDataRelationshipsCest
{
    /**
     * @var \PyzTest\Glue\Checkout\RestApi\Fixtures\CheckoutDataShipmentRelationshipsFixtures
     */
    protected CheckoutDataShipmentRelationshipsFixtures $checkoutDataShipmentRelationshipsFixtures;

    /**
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function loadShipmentFixtures(CheckoutApiTester $I): void
    {
        /** @var \PyzTest\Glue\Checkout\RestApi\Fixtures\CheckoutDataShipmentRelationshipsFixtures $fixtures */
        $fixtures = $I->loadFixtures(CheckoutDataShipmentRelationshipsFixtures::class);
        $this->checkoutDataShipmentRelationshipsFixtures = $fixtures;
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
        $I->authorizeCustomerToGlue($this->checkoutDataShipmentRelationshipsFixtures->getCustomerTransfer());

        $url = $I->buildCheckoutDataUrl([
            ShipmentsRestApiConfig::RESOURCE_SHIPMENTS,
        ]);
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $this->checkoutDataShipmentRelationshipsFixtures->getQuoteTransfer()->getUuid(),
                ],
            ],
        ];

        $shipmentMethodTransfer = $this->checkoutDataShipmentRelationshipsFixtures->getShipmentMethodTransfer();

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

        $I->amSure('The included shipments resource contains correct attributes')
            ->whenI()
            ->assertSame(
                [$this->checkoutDataShipmentRelationshipsFixtures->getQuoteTransfer()->getItems()->offsetGet(0)->getGroupKey()],
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
        $I->authorizeCustomerToGlue($this->checkoutDataShipmentRelationshipsFixtures->getCustomerTransfer());

        $url = $I->buildCheckoutDataUrl([
            ShipmentsRestApiConfig::RESOURCE_SHIPMENTS,
            ShipmentsRestApiConfig::RESOURCE_SHIPMENT_METHODS,
        ]);
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $this->checkoutDataShipmentRelationshipsFixtures->getQuoteTransfer()->getUuid(),
                ],
            ],
        ];

        $shipmentMethodTransfer = $this->checkoutDataShipmentRelationshipsFixtures->getShipmentMethodTransfer();

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
