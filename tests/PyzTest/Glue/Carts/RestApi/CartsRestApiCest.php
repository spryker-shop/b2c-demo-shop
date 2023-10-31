<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Carts\RestApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\CustomerTransfer;
use PyzTest\Glue\Carts\CartsApiTester;
use PyzTest\Glue\Carts\RestApi\Fixtures\CartsRestApiFixtures;
use Spryker\Glue\CartsRestApi\CartsRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\RequestConstantsInterface;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;
use Spryker\Shared\Calculation\CalculationPriceMode;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Carts
 * @group RestApi
 * @group CartsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CartsRestApiCest
{
    /**
     * @var \PyzTest\Glue\Carts\RestApi\Fixtures\CartsRestApiFixtures
     */
    protected CartsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CartsApiTester $I): void
    {
        /** @var \PyzTest\Glue\Carts\RestApi\Fixtures\CartsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(CartsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCarts(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );
        $quoteUuid = $quoteTransfer->getUuid();
        $oauthResponseTransfer = $I->haveAuthorizationToGlue($quoteTransfer->getCustomer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($I->buildCartsUrl());

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Response data contains resource collection')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfType(CartsRestApiConfig::RESOURCE_CARTS);

        $I->amSure('Resource collection has resource')
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($quoteUuid);

        $I->amSure('Resource has correct self-link')
            ->whenI()
            ->seeResourceByIdHasSelfLink($quoteUuid, $I->buildCartUrl($quoteUuid));
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCartByUuid(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );
        $quoteUuid = $quoteTransfer->getUuid();
        $url = $I->buildCartUrl($quoteUuid);
        $oauthResponseTransfer = $I->haveAuthorizationToGlue($quoteTransfer->getCustomer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource is of correct type')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartsRestApiConfig::RESOURCE_CARTS);

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
    public function requestCartByUuidWithCartItemsRelationship(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );
        $cartItemGroupKey = $quoteTransfer->getItems()->offsetGet(0)->getGroupKey();

        $oauthResponseTransfer = $I->haveAuthorizationToGlue($quoteTransfer->getCustomer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($I->buildCartUrl($quoteTransfer->getUuid(), [CartsRestApiConfig::RESOURCE_CART_ITEMS]));

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource has relationship')
            ->whenI()
            ->seeSingleResourceHasRelationshipByTypeAndId(
                CartsRestApiConfig::RESOURCE_CART_ITEMS,
                $cartItemGroupKey,
            );

        $I->amSure('The returned resource has include')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(
                CartsRestApiConfig::RESOURCE_CART_ITEMS,
                $cartItemGroupKey,
            );

        $I->amSure('The include has correct self-link')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdHasSelfLink(
                CartsRestApiConfig::RESOURCE_CART_ITEMS,
                $cartItemGroupKey,
                $I->buildCartItemUrl($quoteTransfer->getUuid(), $cartItemGroupKey),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCartByUuidWithProductConcreteRelationship(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );
        $cartItemGroupKey = $quoteTransfer->getItems()->offsetGet(0)->getGroupKey();
        $productConcreteSku = $this->fixtures->getProductConcreteTransfer()->getSku();
        $url = $I->buildCartUrl(
            $quoteTransfer->getUuid(),
            [
                CartsRestApiConfig::RESOURCE_CART_ITEMS,
                ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            ],
        );

        $oauthResponseTransfer = $I->haveAuthorizationToGlue($quoteTransfer->getCustomer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The included resource has a relationship')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdHasRelationshipByTypeAndId(
                CartsRestApiConfig::RESOURCE_CART_ITEMS,
                $cartItemGroupKey,
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
    public function requestCartByNotExistingCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $oauthResponseTransfer = $I->haveAuthorizationToGlue($this->fixtures->getCustomerTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($I->buildCartUrl('NotExistingUuid'));

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
    public function requestCreateCart(CartsApiTester $I): void
    {
        // Arrange
        $customerTransfer = $I->confirmCustomer($I->haveCustomer([
            CustomerTransfer::PASSWORD => $this->fixtures::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => $this->fixtures::TEST_PASSWORD,
        ]));
        $this->authorizeCustomer($I, $customerTransfer);

        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_CARTS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CARTS,
                    'attributes' => [
                        'priceMode' => CalculationPriceMode::PRICE_MODE_GROSS,
                        'currency' => $this->fixtures::CURRENCY_EUR,
                        'store' => $this->fixtures::STORE_DE,
                        'name' => $this->fixtures::TEST_CART_NAME,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseMatchesOpenApiSchema();

        $I->seeSingleResourceHasSelfLink(
            $I->formatFullUrl(
                '{resourceCarts}/{cartUuid}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $I->getDataFromResponseByJsonPath('$.data')['id'],
                ],
            ),
        );

        $I->amSure(sprintf('Returned resource is of type %s', CartsRestApiConfig::RESOURCE_CARTS))
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartsRestApiConfig::RESOURCE_CARTS);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateCartWithoutAuthorizationToken(CartsApiTester $I): void
    {
        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_CARTS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CARTS,
                    'attributes' => [
                        'priceMode' => CalculationPriceMode::PRICE_MODE_GROSS,
                        'currency' => $this->fixtures::CURRENCY_EUR,
                        'store' => $this->fixtures::STORE_DE,
                        'name' => $this->fixtures::TEST_CART_NAME,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateCartWithoutPriceMode(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);

        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_CARTS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CARTS,
                    'attributes' => [
                        'currency' => $this->fixtures::CURRENCY_EUR,
                        'store' => $this->fixtures::STORE_DE,
                        'name' => $this->fixtures::TEST_CART_NAME,
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
    public function requestCreateCartWithoutPriceCurrency(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);

        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_CARTS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CARTS,
                    'attributes' => [
                        'priceMode' => CalculationPriceMode::PRICE_MODE_GROSS,
                        'store' => $this->fixtures::STORE_DE,
                        'name' => $this->fixtures::TEST_CART_NAME,
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
    public function requestUpdateCart(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);

        $emptyQuoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );
        $entityTag = $I->createCartResourceEntityTag(
            $I,
            $emptyQuoteTransfer->getUuid(),
            $emptyQuoteTransfer->toArray(),
        );
        $I->haveHttpHeader(RequestConstantsInterface::HEADER_IF_MATCH, $entityTag);
        $emptyQuoteUuid = $emptyQuoteTransfer->getUuid();

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $emptyQuoteUuid,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CARTS,
                    'attributes' => [
                        'name' => $this->fixtures::TEST_CART_NAME,
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
            ->seeSingleResourceIdEqualTo($emptyQuoteUuid);

        $I->amSure(sprintf('Returned resource is of type %s', CartsRestApiConfig::RESOURCE_CARTS))
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartsRestApiConfig::RESOURCE_CARTS);

        $I->seeSingleResourceHasSelfLink(
            $I->formatFullUrl(
                '{resourceCarts}/{cartUuid}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $emptyQuoteUuid,
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
    public function requestUpdatePriceModeOfNonEmptyCart(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );
        $cartUuid = $quoteTransfer->getUuid();
        $entityTag = $I->createCartResourceEntityTag(
            $I,
            $cartUuid,
            $quoteTransfer->toArray(),
        );

        $I->haveHttpHeader(RequestConstantsInterface::HEADER_IF_MATCH, $entityTag);

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $cartUuid,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CARTS,
                    'attributes' => [
                        'name' => $this->fixtures::TEST_CART_NAME,
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
    public function requestUpdateCartWithoutCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );
        $entityTag = $I->createCartResourceEntityTag($I, $quoteTransfer->getUuid(), $quoteTransfer->toArray());
        $I->haveHttpHeader(RequestConstantsInterface::HEADER_IF_MATCH, $entityTag);

        // Act
        $I->sendPATCH(
            CartsRestApiConfig::RESOURCE_CARTS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CARTS,
                    'attributes' => [
                        'name' => $this->fixtures::TEST_CART_NAME,
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
    public function requestUpdateCartWithoutAuthorizationToken(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );
        $entityTag = $I->createCartResourceEntityTag($I, $quoteTransfer->getUuid(), $quoteTransfer->toArray());
        $I->haveHttpHeader(RequestConstantsInterface::HEADER_IF_MATCH, $entityTag);

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CARTS,
                    'attributes' => [
                        'name' => $this->fixtures::TEST_CART_NAME,
                        'currency' => $this->fixtures::CURRENCY_EUR,
                        'priceMode' => CalculationPriceMode::PRICE_MODE_GROSS,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToCart(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );
        $quoteUuid = $quoteTransfer->getUuid();

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}?include={resourceCartItems}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteUuid,
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ],
        );

        $quoteTransfer = $I->getLocator()->quote()->facade()->findQuoteByUuid($quoteTransfer)->getQuoteTransfer();

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource has correct id')
            ->whenI()
            ->seeSingleResourceIdEqualTo($quoteUuid);

        $I->amSure(sprintf('Returned resource is of type %s', CartsRestApiConfig::RESOURCE_CARTS))
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartsRestApiConfig::RESOURCE_CARTS);

        $I->amSure('Returned resource has include of type items')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(
                CartsRestApiConfig::RESOURCE_CART_ITEMS,
                $I->getGroupKeyFromQuote($quoteTransfer, $this->fixtures->getProductConcreteTransfer()->getSku()),
            );

        $I->seeSingleResourceHasSelfLink(
            $I->formatFullUrl(
                '{resourceCarts}/{cartUuid}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $I->getDataFromResponseByJsonPath('$.data')['id'],
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
    public function requestAddItemsToCartWithoutAuthorizationToken(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToCartWithoutItemSku(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'attributes' => [
                        'quantity' => 1,
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
    public function requestAddItemsToCartWithoutItemQuantity(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
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
    public function requestUpdateItemsInCart(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);

        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );

        $itemGroupKey = $I->getGroupKeyFromQuote($quoteTransfer, $this->fixtures->getProductConcreteTransfer()->getSku());

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}/{itemId}?include={resourceCartItems}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'itemId' => $itemGroupKey,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'attributes' => [
                        'quantity' => $this->fixtures::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure(sprintf('Returned resource is of type %s', CartsRestApiConfig::RESOURCE_CARTS))
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartsRestApiConfig::RESOURCE_CARTS);

        $I->seeCartItemQuantityEqualsToQuantityInRequest(
            $this->fixtures::QUANTITY_FOR_ITEM_UPDATE,
            CartsRestApiConfig::RESOURCE_CART_ITEMS,
            $itemGroupKey,
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInCartWithoutCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceCarts}//{resourceCartItems}/{cartItemSku}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'cartItemSku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'attributes' => [
                        'quantity' => $this->fixtures::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInCartWithoutAuthorizationToken(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}/{itemSku}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'attributes' => [
                        'quantity' => $this->fixtures::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInCartWithoutQuantity(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}/{itemSku}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
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
    public function requestUpdateItemsInCartWithoutItemSku(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                ],
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
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
    public function requestDeleteItemsFromCart(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}/{itemSku}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
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
    public function requestDeleteItemsFromCartWithoutCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceCarts}//{resourceCartItems}/{itemSku}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromCartWithoutAuthorizationToken(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}/{itemSku}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromCartWithoutItemSku(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [$this->fixtures->getProductConcreteTransfer()],
        );

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceCarts}/{cartUuid}/{resourceCartItems}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                    'cartUuid' => $quoteTransfer->getUuid(),
                    'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
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
    public function requestDeleteCart(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );

        // Act
        $I->sendDelete($I->buildCartUrl($quoteTransfer->getUuid()));

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
    public function requestDeleteCartWithoutCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $this->authorizeCustomer($I);

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceCarts}',
                [
                    'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
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
    public function requestDeleteCartWithoutAuthorizationToken(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );

        // Act
        $I->sendDelete($I->buildCartUrl($quoteTransfer->getUuid()));

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCustomerCarts(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );

        $url = $I->buildCustomerCartUrl($quoteTransfer->getCustomer()->getCustomerReference());

        $oauthResponseTransfer = $I->haveAuthorizationToGlue($quoteTransfer->getCustomer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCustomerCartsAuthorizationError(CartsApiTester $I): void
    {
        // Arrange
        $quoteTransfer = $I->createPersistentQuote(
            $I,
            $this->fixtures->getCustomerTransfer(),
            [],
        );

        $url = $I->buildCustomerCartUrl('wrongCustomerReference');

        $oauthResponseTransfer = $I->haveAuthorizationToGlue($quoteTransfer->getCustomer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customerTransfer
     *
     * @return void
     */
    protected function authorizeCustomer(CartsApiTester $I, ?CustomerTransfer $customerTransfer = null): void
    {
        if (!$customerTransfer) {
            $customerTransfer = $this->fixtures->getCustomerTransfer();
        }

        $token = $I->haveAuthorizationToGlue($customerTransfer)->getAccessToken();

        $I->amBearerAuthenticated($token);
    }
}
