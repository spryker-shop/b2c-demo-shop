<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Checkout\RestApi;

use Codeception\Util\HttpCode;
use Generated\Shared\DataBuilder\AddressBuilder;
use Generated\Shared\Transfer\RestCheckoutErrorTransfer;
use Generated\Shared\Transfer\RestPaymentTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use PyzTest\Glue\Checkout\CheckoutApiTester;
use PyzTest\Glue\Checkout\RestApi\Fixtures\CheckoutRestApiFixtures;
use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig;
use Spryker\Shared\Price\PriceConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Checkout
 * @group RestApi
 * @group CheckoutRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CheckoutRestApiCest
{
    /**
     * @var string
     */
    protected const RESPONSE_CODE_CART_IS_EMPTY = '1104';

    /**
     * @var string
     */
    protected const RESPONSE_DETAILS_CART_IS_EMPTY = 'Cart is empty.';

    /**
     * @var \PyzTest\Glue\Checkout\RestApi\Fixtures\CheckoutRestApiFixtures
     */
    protected CheckoutRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CheckoutApiTester $I): void
    {
        /** @var \PyzTest\Glue\Checkout\RestApi\Fixtures\CheckoutRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(CheckoutRestApiFixtures::class);
        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithNoItemsInQuote(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();
        $I->authorizeCustomerToGlue($customerTransfer);

        $quoteTransfer = $this->fixtures->getEmptyQuoteTransfer();
        $shippingAddressTransfer = (new AddressBuilder())->build();
        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();

        $url = $I->buildCheckoutUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'customer' => $I->getCustomerRequestPayload($customerTransfer),
                    'payments' => [
                        [
                            RestPaymentTransfer::PAYMENT_METHOD_NAME => 'Invoice',
                            RestPaymentTransfer::PAYMENT_PROVIDER_NAME => 'DummyPayment',
                        ],
                    ],
                    'shipment' => [
                        ShipmentMethodTransfer::ID_SHIPMENT_METHOD => $shipmentMethodTransfer->getIdShipmentMethod(),
                    ],
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $errors = $I->getDataFromResponseByJsonPath('$.errors[0]');
        $I->assertEquals($errors[RestCheckoutErrorTransfer::CODE], static::RESPONSE_CODE_CART_IS_EMPTY);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::STATUS], HttpCode::UNPROCESSABLE_ENTITY);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::DETAIL], static::RESPONSE_DETAILS_CART_IS_EMPTY);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithOneItemInQuoteAndInvoicePayment(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();
        $I->authorizeCustomerToGlue($customerTransfer);

        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();
        $quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $customerTransfer,
            [$I->getQuoteItemOverrideData($this->fixtures->getProductConcreteTransfers()[0], $shipmentMethodTransfer, 10)],
        );
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();

        $url = $I->buildCheckoutUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'customer' => $I->getCustomerRequestPayload($customerTransfer),
                    'payments' => $I->getPaymentRequestPayload(),
                    'shipment' => $I->getShipmentRequestPayload($shipmentMethodTransfer->getIdShipmentMethod()),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutResponseResourceHasCorrectData();

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
    public function requestWithOneItemInQuoteAndCreditCardPayment(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();
        $I->authorizeCustomerToGlue($customerTransfer);

        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();
        $quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $customerTransfer,
            [$I->getQuoteItemOverrideData($this->fixtures->getProductConcreteTransfers()[0], $shipmentMethodTransfer, 10)],
        );
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();

        $url = $I->buildCheckoutUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'customer' => $I->getCustomerRequestPayload($customerTransfer),
                    'payments' => $I->getPaymentRequestPayload('Credit Card'),
                    'shipment' => $I->getShipmentRequestPayload($shipmentMethodTransfer->getIdShipmentMethod()),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutResponseResourceHasCorrectData();

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
    public function requestWithOneItemInQuoteAndPersistedAddresses(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransferWithPersistedAddress();
        $I->authorizeCustomerToGlue($customerTransfer);

        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();
        $quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $customerTransfer,
            [$I->getQuoteItemOverrideData($this->fixtures->getProductConcreteTransfers()[0], $shipmentMethodTransfer, 10)],
        );
        $persistedAddressTransfer = $customerTransfer->getAddresses()->getAddresses()[0];

        $url = $I->buildCheckoutUrl();
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($persistedAddressTransfer),
                    'shippingAddress' => $I->getAddressRequestPayload($persistedAddressTransfer),
                    'customer' => $I->getCustomerRequestPayload($customerTransfer),
                    'payments' => $I->getPaymentRequestPayload(),
                    'shipment' => $I->getShipmentRequestPayload($shipmentMethodTransfer->getIdShipmentMethod()),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutResponseResourceHasCorrectData();

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
    public function requestWithNetPriceModeAndSingleShipment(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();
        $I->authorizeCustomerToGlue($customerTransfer);

        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();
        $quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $customerTransfer,
            [$I->getQuoteItemOverrideData($this->fixtures->getProductConcreteTransfers()[0], $shipmentMethodTransfer, 10)],
            PriceConfig::PRICE_MODE_NET,
        );
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();

        $url = $I->buildCheckoutUrl(['orders']);
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'customer' => $I->getCustomerRequestPayload($customerTransfer),
                    'payments' => $I->getPaymentRequestPayload('Credit Card'),
                    'shipment' => $I->getShipmentRequestPayload($shipmentMethodTransfer->getIdShipmentMethod()),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutResponseResourceHasCorrectData();
        $I->assertShipmentExpensesHaveCorrectPrice(
            $shipmentMethodTransfer->getPrices()->offsetGet(0)->getNetAmountOrFail(),
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithNetPriceModeAndSplitShipment(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();
        $I->authorizeCustomerToGlue($customerTransfer);

        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();
        $quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $customerTransfer,
            [$I->getQuoteItemOverrideData($this->fixtures->getProductConcreteTransfers()[0], $shipmentMethodTransfer, 10)],
            PriceConfig::PRICE_MODE_NET,
        );
        $quoteTransfer = $I->getCartFacade()->reloadItems($quoteTransfer);

        $url = $I->buildCheckoutUrl(['orders']);
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'customer' => $I->getCustomerRequestPayload($customerTransfer),
                    'payments' => $I->getPaymentRequestPayload('Credit Card'),
                    'shipments' => [
                        $I->getSplitShipmentRequestPayload($quoteTransfer->getItems()->offsetGet(0)),
                    ],
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutResponseResourceHasCorrectData();
        $I->assertShipmentExpensesHaveCorrectPrice(
            $shipmentMethodTransfer->getPrices()->offsetGet(0)->getNetAmountOrFail(),
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithGrossPriceModeAndSingleShipment(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();
        $I->authorizeCustomerToGlue($customerTransfer);

        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();
        $quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $customerTransfer,
            [$I->getQuoteItemOverrideData($this->fixtures->getProductConcreteTransfers()[0], $shipmentMethodTransfer, 10)],
        );
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();

        $url = $I->buildCheckoutUrl(['orders']);
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'customer' => $I->getCustomerRequestPayload($customerTransfer),
                    'payments' => $I->getPaymentRequestPayload('Credit Card'),
                    'shipment' => $I->getShipmentRequestPayload($shipmentMethodTransfer->getIdShipmentMethod()),
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutResponseResourceHasCorrectData();
        $I->assertShipmentExpensesHaveCorrectPrice(
            $shipmentMethodTransfer->getPrices()->offsetGet(0)->getGrossAmountOrFail(),
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithGrossPriceModeAndSplitShipment(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();
        $I->authorizeCustomerToGlue($customerTransfer);

        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();
        $quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $customerTransfer,
            [$I->getQuoteItemOverrideData($this->fixtures->getProductConcreteTransfers()[0], $shipmentMethodTransfer, 10)],
        );
        $quoteTransfer = $I->getCartFacade()->reloadItems($quoteTransfer);

        $url = $I->buildCheckoutUrl(['orders']);
        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'customer' => $I->getCustomerRequestPayload($customerTransfer),
                    'payments' => $I->getPaymentRequestPayload('Credit Card'),
                    'shipments' => [
                        $I->getSplitShipmentRequestPayload($quoteTransfer->getItems()->offsetGet(0)),
                    ],
                ],
            ],
        ];

        // Act
        $I->sendPOST($url, $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->assertCheckoutResponseResourceHasCorrectData();
        $I->assertShipmentExpensesHaveCorrectPrice(
            $shipmentMethodTransfer->getPrices()->offsetGet(0)->getGrossAmountOrFail(),
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestWithCustomerBillingAddressIdOnly(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();
        $I->authorizeCustomerToGlue($customerTransfer);

        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();
        $quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $customerTransfer,
            [$I->getQuoteItemOverrideData($this->fixtures->getProductConcreteTransfers()[0], $shipmentMethodTransfer, 10)],
        );
        $quoteTransfer = $I->getCartFacade()->validateQuote($quoteTransfer)->getQuoteTransfer();
        $shippingAddressTransfer = $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress();

        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => [
                        'id' => $this->fixtures->getCustomerAddress()->getUuid(),
                    ],
                    'shippingAddress' => $I->getAddressRequestPayload($shippingAddressTransfer),
                    'payments' => $I->getPaymentRequestPayload(),
                    'shipment' => $I->getShipmentRequestPayload($shipmentMethodTransfer->getIdShipmentMethod()),
                ],
            ],
        ];

        // Act
        $I->sendPOST($I->buildCheckoutUrl(['orders']), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->assertCustomerBillingAddressInOrders($this->fixtures->getCustomerAddress());
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Checkout\CheckoutApiTester $I
     *
     * @return void
     */
    public function requestSplitCheckoutWithCustomerShippingAddressIdOnly(CheckoutApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();
        $I->authorizeCustomerToGlue($customerTransfer);

        $shipmentMethodTransfer = $this->fixtures->getShipmentMethodTransfer();
        $quoteTransfer = $I->havePersistentQuoteWithItemsAndItemLevelShipment(
            $customerTransfer,
            [$I->getQuoteItemOverrideData($this->fixtures->getProductConcreteTransfers()[0], $shipmentMethodTransfer, 1)],
        );
        $quoteTransfer = $I->getCartFacade()->validateQuote($quoteTransfer)->getQuoteTransfer();
        $itemTransfer = $quoteTransfer->getItems()->offsetGet(0);

        $requestPayload = [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
                'attributes' => [
                    'idCart' => $quoteTransfer->getUuid(),
                    'billingAddress' => $I->getAddressRequestPayload($quoteTransfer->getBillingAddress()),
                    'payments' => $I->getPaymentRequestPayload(),
                    'shipments' => [
                        $I->getSplitShipmentRequestPayload($itemTransfer, $this->fixtures->getCustomerAddress()),
                    ],
                ],
            ],
        ];

        // Act
        $I->sendPOST($I->buildCheckoutUrl(['orders', 'order-shipments']), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->assertCustomerShippingAddressInOrderShipments($this->fixtures->getCustomerAddress());
    }
}
