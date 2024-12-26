<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Carts\RestApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\CustomerTransfer;
use PyzTest\Glue\Carts\CartsApiTester;
use PyzTest\Glue\Carts\RestApi\Fixtures\GuestCartsRestApiFixtures;
use Spryker\Glue\CartsRestApi\CartsRestApiConfig;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;
use Spryker\Shared\Calculation\CalculationPriceMode;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Carts
 * @group RestApi
 * @group GuestCartsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class GuestCartsRestApiCest
{
    /**
     * @var \PyzTest\Glue\Carts\RestApi\Fixtures\GuestCartsRestApiFixtures
     */
    protected GuestCartsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CartsApiTester $I): void
    {
        /** @var \PyzTest\Glue\Carts\RestApi\Fixtures\GuestCartsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(GuestCartsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestGuestCartByUuid(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $quoteUuid = $quoteTransfer->getUuid();
        $url = $I->buildGuestCartUrl($quoteUuid);
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource is of correct type')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartsRestApiConfig::RESOURCE_GUEST_CARTS);

        $I->amSure('The returned resource has correct id')
            ->whenI()
            ->seeSingleResourceIdEqualTo($quoteUuid);

        $I->amSure('The returned resource has correct self-link')
            ->whenI()
            ->seeSingleResourceHasSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestGuestCarts(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $quoteUuid = $quoteTransfer->getUuid();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendGET($I->buildGuestCartsUrl());

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Response data contains resource collection')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfType(CartsRestApiConfig::RESOURCE_GUEST_CARTS);

        $I->amSure('Resource collection has resource')
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($quoteUuid);

        $I->amSure('Resource has correct self-link')
            ->whenI()
            ->seeResourceByIdHasSelfLink($quoteUuid, $I->buildGuestCartUrl($quoteUuid));
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestGuestCartByUuidWithGuestCartItemsRelationship(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $quoteUuid = $quoteTransfer->getUuid();
        $guestCartItemGroupKey = $quoteTransfer->getItems()->offsetGet(0)->getGroupKey();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );
        $url = $I->buildGuestCartUrl(
            $quoteUuid,
            [
                CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            ],
        );

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource has relationship')
            ->whenI()
            ->seeSingleResourceHasRelationshipByTypeAndId(
                CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                $guestCartItemGroupKey,
            );

        $I->amSure('The returned resource has include')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(
                CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                $guestCartItemGroupKey,
            );

        $I->amSure('The include has correct self-link')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdHasSelfLink(
                CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                $guestCartItemGroupKey,
                $I->buildGuestCartItemUrl($quoteUuid, $guestCartItemGroupKey),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestGuestCartByUuidWithProductConcreteRelationship(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );

        $guestCartItemGroupKey = $quoteTransfer->getItems()->offsetGet(0)->getGroupKey();
        $productConcreteSku = $this->fixtures->getProductConcreteTransfer1()->getSku();
        $url = $I->buildGuestCartUrl(
            $quoteTransfer->getUuid(),
            [
                CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            ],
        );
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The included resource has a relationship')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdHasRelationshipByTypeAndId(
                CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                $guestCartItemGroupKey,
                ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                $productConcreteSku,
            );

        $I->amSure('The returned resource has include')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(
                ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                $productConcreteSku,
            );

        $I->amSure('The include has correct self-link')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdHasSelfLink(
                ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                $productConcreteSku,
                $I->buildProductConcreteUrl($productConcreteSku),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestGuestCartByNotExistingGuestCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            'NotExistingReference',
        );

        // Act
        $I->sendGET($I->buildGuestCartUrl('NotExistingUuid'));

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID, uniqid('123', true));

        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->amSure('Returned resource is of type guest-carts')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartsRestApiConfig::RESOURCE_GUEST_CARTS);

        $I->seeSingleResourceHasSelfLink(
            $I->formatFullUrl(
                '{resourceGuestCarts}/{guestCartUuid}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $I->getDataFromResponseByJsonPath('$.data')['id'],
                ],
            ),
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateGuestCartWithoutSku(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $I->createGuestCustomerReference(),
        );

        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => 1,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateGuestCartWithoutQuantity(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $I->createGuestCustomerReference(),
        );

        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestGetGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Act
        $I->sendGET(
            $I->formatUrl(
                '{resourceGuestCarts}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();
        $formattedUrl = $I->formatUrl(
            '{resourceGuestCarts}/{guestCartUuid}',
            [
                'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                'guestCartUuid' => $guestQuoteUuid,
            ],
        );

        // Act
        $I->sendPATCH(
            $formattedUrl,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'attributes' => [
                        'name' => $this->fixtures::TEST_GUEST_CART_NAME,
                        'currency' => $this->fixtures::CURRENCY_EUR,
                        'priceMode' => CalculationPriceMode::PRICE_MODE_GROSS,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource has correct id')
            ->whenI()
            ->seeSingleResourceIdEqualTo($guestQuoteUuid);

        $I->amSure(sprintf('Returned resource is of type %s', CartsRestApiConfig::RESOURCE_GUEST_CARTS))
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartsRestApiConfig::RESOURCE_GUEST_CARTS);

        $I->seeSingleResourceHasSelfLink(
            $I->formatFullUrl(
                '{resourceGuestCarts}/{guestCartUuid}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                ],
            ),
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdatePriceModeOfNonEmptyGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();

        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'attributes' => [
                        'name' => $this->fixtures::TEST_GUEST_CART_NAME,
                        'currency' => $this->fixtures::CURRENCY_EUR,
                        'priceMode' => CalculationPriceMode::PRICE_MODE_NET,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateGuestCartWithoutGuestCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $I->createGuestCustomerReference(),
        );

        // Act
        $I->sendPATCH(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'attributes' => [
                        'name' => $this->fixtures::TEST_GUEST_CART_NAME,
                        'currency' => $this->fixtures::CURRENCY_EUR,
                        'priceMode' => CalculationPriceMode::PRICE_MODE_GROSS,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $I->createGuestCustomerReference()),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'attributes' => [
                        'name' => $this->fixtures::TEST_GUEST_CART_NAME,
                        'currency' => $this->fixtures::CURRENCY_EUR,
                        'priceMode' => CalculationPriceMode::PRICE_MODE_GROSS,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource has correct id')
            ->whenI()
            ->seeSingleResourceIdEqualTo($guestQuoteUuid);

        $I->amSure(sprintf('Returned resource is of type %s', CartsRestApiConfig::RESOURCE_GUEST_CARTS))
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartsRestApiConfig::RESOURCE_GUEST_CARTS);

        $I->seeSingleResourceHasSelfLink(
            $I->formatFullUrl(
                '{resourceGuestCarts}/{guestCartUuid}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                ],
            ),
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $I->createGuestCustomerReference()),
            [],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer2()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToGuestCartWithoutItemSku(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();

        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => 1,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToGuestCartWithoutItemQuantity(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer2()->getSku(),
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();
        $itemGroupKey = $I->getGroupKeyFromQuote($quoteTransfer, $this->fixtures->getProductConcreteTransfer1()->getSku());

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemId}?include={resourceGuestCartItems}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemId' => $itemGroupKey,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => $this->fixtures::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource has correct id')
            ->whenI()
            ->seeSingleResourceIdEqualTo($guestQuoteUuid);

        $I->seeCartItemQuantityEqualsToQuantityInRequest(
            $this->fixtures::QUANTITY_FOR_ITEM_UPDATE,
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            $itemGroupKey,
        );

        $I->seeSingleResourceHasSelfLink(
            $I->formatFullUrl(
                '{resourceGuestCarts}/{guestCartUuid}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                ],
            ),
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCartWithoutGuestCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $I->createGuestCustomerReference(),
        );

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}//{resourceGuestCartItems}/{guestCartItemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'guestCartItemSku' => $this->fixtures->getProductConcreteTransfer2()->getSku(),
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => $this->fixtures::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $I->createGuestCustomerReference()),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => $this->fixtures::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCartWithoutQuantity(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCartWithoutItemSku(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => $this->fixtures::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromGuestCartWithoutGuestCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $I->createGuestCustomerReference(),
        );

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceGuestCarts}//{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $I->createGuestCustomerReference()),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromGuestCartWithoutItemSku(CartsApiTester $I): void
    {
        // Arrange
        $guestCustomerReference = $I->createGuestCustomerReference();
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            (new CustomerTransfer())->setCustomerReference(GuestCartsRestApiFixtures::ANONYMOUS_PREFIX . $guestCustomerReference),
            [$this->fixtures->getProductConcreteTransfer1()],
        );
        $guestQuoteUuid = $quoteTransfer->getUuid();
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            $guestCustomerReference,
        );

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $guestQuoteUuid,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }
}
