<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Checkout\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\Checkout\CheckoutApiTester;
use PyzTest\Glue\Checkout\RestApi\Fixtures\GuestCheckoutDataRestApiFixtures;
use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Checkout
 * @group RestApi
 * @group GuestCheckoutDataRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class GuestCheckoutDataRestApiCest
{
    /**
     * @var string
     */
    protected const HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID = 'X-Anonymous-Customer-Unique-Id';

    /**
     * @var \PyzTest\Glue\Checkout\RestApi\Fixtures\GuestCheckoutDataRestApiFixtures
     */
    protected GuestCheckoutDataRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CheckoutApiTester $I): void
    {
        /** @var \PyzTest\Glue\Checkout\RestApi\Fixtures\GuestCheckoutDataRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(GuestCheckoutDataRestApiFixtures::class);
        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestEmptyRequestWithOneItemInQuote(CheckoutApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $this->fixtures->getGuestQuoteTransfer();
        $I->haveHttpHeader(
            static::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $this->fixtures->getGuestCustomerReference(),
        );

        $url = $I->buildCheckoutDataUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutDataResponseResourceHasCorrectData();

        $I->amSure('The returned resource has correct self link')
            ->whenI()
            ->seeSingleResourceHasSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithOneItemInQuoteAndBillingAndShippingAddresses(CheckoutApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $this->fixtures->getGuestQuoteTransfer();
        $I->haveHttpHeader(
            static::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $this->fixtures->getGuestCustomerReference(),
        );
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();

        $url = $I->buildCheckoutDataUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutDataResponseResourceHasCorrectData();

        $I->amSure('The returned resource has correct self link')
            ->whenI()
            ->seeSingleResourceHasSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithOneItemInQuoteWithoutShipment(CheckoutApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $this->fixtures->getGuestQuoteTransfer();
        $I->haveHttpHeader(
            static::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $this->fixtures->getGuestCustomerReference(),
        );
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();

        $url = $I->buildCheckoutDataUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'payments' => $I->getPaymentRequestPayload(),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutDataResponseResourceHasCorrectData();

        $I->amSure('The returned resource has correct self link')
            ->whenI()
            ->seeSingleResourceHasSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithOneItemInQuoteWithoutPayment(CheckoutApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $this->fixtures->getGuestQuoteTransfer();
        $I->haveHttpHeader(
            static::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $this->fixtures->getGuestCustomerReference(),
        );
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();
        $idShipmentMethod = $this->fixtures->getShipmentMethodTransfer()->getIdShipmentMethod();

        $url = $I->buildCheckoutDataUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'shipment' => $I->getShipmentRequestPayload($idShipmentMethod),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutDataResponseResourceHasCorrectData();

        $I->amSure('The returned resource has correct self link')
            ->whenI()
            ->seeSingleResourceHasSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithOneItemInQuoteAndCustomerAndBillingAndShippingAddressesAndCart(CheckoutApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $this->fixtures->getGuestQuoteTransfer();
        $I->haveHttpHeader(
            static::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $this->fixtures->getGuestCustomerReference(),
        );
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();

        $url = $I->buildCheckoutDataUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'customer' => $I->getCustomerRequestPayload($this->fixtures->getGuestCustomerTransfer()),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutDataResponseResourceHasCorrectData();

        $I->amSure('The returned resource has correct self link')
            ->whenI()
            ->seeSingleResourceHasSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithOneItemInQuoteAndFullBody(CheckoutApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $this->fixtures->getGuestQuoteTransfer();
        $I->haveHttpHeader(
            static::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $this->fixtures->getGuestCustomerReference(),
        );
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();
        $idShipmentMethod = $this->fixtures->getShipmentMethodTransfer()->getIdShipmentMethod();

        $url = $I->buildCheckoutDataUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'customer' => $I->getCustomerRequestPayload($this->fixtures->getGuestCustomerTransfer()),
                    'payments' => $I->getPaymentRequestPayload(),
                    'shipment' => $I->getShipmentRequestPayload($idShipmentMethod),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutDataResponseResourceHasCorrectData();

        $I->amSure('The returned resource has correct self link')
            ->whenI()
            ->seeSingleResourceHasSelfLink($url);
    }
}
