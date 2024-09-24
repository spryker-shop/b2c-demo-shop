<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Products\RestApi;

use Codeception\Util\HttpCode;
use Pyz\Glue\ProductPricesRestApi\ProductPricesRestApiConfig;
use PyzTest\Glue\Products\ProductsApiTester;
use PyzTest\Glue\Products\RestApi\Fixtures\ProductsRestApiFixtures;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Products
 * @group RestApi
 * @group ProductConcreteRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductConcreteRestApiCest
{
    /**
     * @var \PyzTest\Glue\Products\RestApi\Fixtures\ProductsRestApiFixtures
     */
    protected ProductsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Products\ProductsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(ProductsApiTester $I): void
    {
        /** @var \PyzTest\Glue\Products\RestApi\Fixtures\ProductsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(ProductsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Products\ProductsApiTester $I
     *
     * @return void
     */
    public function requestProductConcrete(ProductsApiTester $I): void
    {
        // Arrange
        $productConcreteSku = $this->fixtures->getProductConcreteTransfer()->getSku();
        $url = $I->buildProductConcreteUrl($productConcreteSku);

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource is of correct type')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS);

        $I->amSure('The returned resource has correct id')
            ->whenI()
            ->seeSingleResourceIdEqualTo($productConcreteSku);

        $I->amSure('The returned resource has correct self-link')
            ->whenI()
            ->seeSingleResourceHasSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Products\ProductsApiTester $I
     *
     * @return void
     */
    public function requestProductConcreteWithProductPriceRelationship(ProductsApiTester $I): void
    {
        // Arrange
        $productConcreteSku = $this->fixtures->getProductConcreteTransfer()->getSku();
        $url = $I->buildProductConcreteUrl($productConcreteSku, [ProductPricesRestApiConfig::RESOURCE_CONCRETE_PRODUCT_PRICES]);

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource has relationship')
            ->whenI()
            ->seeSingleResourceHasRelationshipByTypeAndId(
                ProductPricesRestApiConfig::RESOURCE_CONCRETE_PRODUCT_PRICES,
                $productConcreteSku,
            );

        $I->amSure('The returned resource has include')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(
                ProductPricesRestApiConfig::RESOURCE_CONCRETE_PRODUCT_PRICES,
                $productConcreteSku,
            );

        $I->amSure('The include has correct self-link')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdHasSelfLink(
                ProductPricesRestApiConfig::RESOURCE_CONCRETE_PRODUCT_PRICES,
                $productConcreteSku,
                $I->buildProductConcretePricesUrl($productConcreteSku),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Products\ProductsApiTester $I
     *
     * @return void
     */
    public function requestProductConcreteByNotExistingProductConcreteSku(ProductsApiTester $I): void
    {
        // Act
        $I->sendGET($I->buildProductConcreteUrl('NotExistingSku'));

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }
}
