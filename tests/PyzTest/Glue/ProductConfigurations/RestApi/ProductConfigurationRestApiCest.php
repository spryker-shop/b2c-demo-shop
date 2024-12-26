<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\ProductConfigurations\RestApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PyzTest\Glue\ProductConfigurations\ProductConfigurationsApiTester;
use PyzTest\Glue\ProductConfigurations\RestApi\Fixtures\ProductConfigurationsRestApiFixtures;
use Spryker\Glue\CartsRestApi\CartsRestApiConfig;
use Spryker\Glue\OrdersRestApi\OrdersRestApiConfig;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;
use Spryker\Shared\Price\PriceConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group ProductConfigurations
 * @group RestApi
 * @group ProductConfigurationRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductConfigurationRestApiCest
{
    /**
     * @var \PyzTest\Glue\ProductConfigurations\RestApi\Fixtures\ProductConfigurationsRestApiFixtures
     */
    protected ProductConfigurationsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\ProductConfigurations\ProductConfigurationsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(ProductConfigurationsApiTester $I): void
    {
        /** @var \PyzTest\Glue\ProductConfigurations\RestApi\Fixtures\ProductConfigurationsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(ProductConfigurationsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\ProductConfigurations\ProductConfigurationsApiTester $I
     *
     * @return void
     */
    public function requestProductConcrete(ProductConfigurationsApiTester $I): void
    {
        // Act
        $I->sendGET($I->formatFullUrl(
            '{resourceConcreteProducts}/{productConcreteSku}',
            [
                'resourceConcreteProducts' => ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                'productConcreteSku' => $this->fixtures->getProductConcreteTransfer()->getSkuOrFail(),
            ],
        ));

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource is of type concrete-products')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS);

        $I->amSure('Returned resource has correct id')
            ->whenI()
            ->seeSingleResourceIdEqualTo($this->fixtures->getProductConcreteTransfer()->getSkuOrFail());

        $I->amSure('Returned resource has product configuration instance')
            ->whenI()
            ->seeSingleResourceHasAttribute($this->fixtures::PRODUCT_CONFIGURATION_INSTANCE_ATTRIBUTE_JSON_PATH);

        $I->amSure('Returned product configuration instance is correct')
            ->whenI()
            ->seeProductConfigurationInstanceEqualToExpectedValue($this->fixtures->getProductConfigurationTransfer());
    }

    /**
     * @param \PyzTest\Glue\ProductConfigurations\ProductConfigurationsApiTester $I
     *
     * @return void
     */
    public function requestAddConfigurableItemsToCart(ProductConfigurationsApiTester $I): void
    {
        // Arrange
        $I->amAuthorizedCustomer($this->fixtures->getCustomerTransfer());
        $quoteTransfer = $I->havePersistentQuote([
            QuoteTransfer::CUSTOMER => $this->fixtures->getCustomerTransfer(),
            QuoteTransfer::STORE => [StoreTransfer::NAME => $this->fixtures::STORE_NAME_DE],
            QuoteTransfer::PRICE_MODE => PriceConfig::PRICE_MODE_GROSS,
        ]);
        $quoteUuid = $quoteTransfer->getUuidOrFail();
        $productConcreteSku = $this->fixtures->getProductConcreteTransfer()->getSkuOrFail();

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
                        'sku' => $productConcreteSku,
                        'quantity' => 1,
                        'productConfigurationInstance' => $this->fixtures::PRODUCT_CONFIGURATION_CART_ITEM_DATA,
                    ],
                ],
            ],
        );

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
            ->seeIncludesContainResourceOfType(CartsRestApiConfig::RESOURCE_CART_ITEMS);

        $I->amSure('Included resource has product configuration instance')
            ->whenI()
            ->seeCartItemContainsProductConfigurationInstance(
                CartsRestApiConfig::RESOURCE_CART_ITEMS,
                $productConcreteSku,
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
     * @param \PyzTest\Glue\ProductConfigurations\ProductConfigurationsApiTester $I
     *
     * @return void
     */
    public function requestGetOrderDetails(ProductConfigurationsApiTester $I): void
    {
        // Arrange
        $I->amAuthorizedCustomer($this->fixtures->getCustomerTransfer());
        $orderReference = $this->fixtures->getSaveOrderTransfer()->getOrderReferenceOrFail();

        // Act
        $I->sendGET(
            $I->formatUrl(
                '{orders}/{customerOrderReference}?include=items',
                [
                    'orders' => OrdersRestApiConfig::RESOURCE_ORDERS,
                    'customerOrderReference' => $orderReference,
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource is of correct type')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType('orders');

        $I->amSure('The returned resource has correct id')
            ->whenI()
            ->seeSingleResourceIdEqualTo($orderReference);

        $I->amSure('Order item contains product configuration data')
            ->whenI()
            ->seeOrderItemContainProductConfigurationInstance($this->fixtures->getProductConfigurationTransfer());
    }
}
