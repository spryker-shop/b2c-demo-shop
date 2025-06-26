<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Products\RestApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\AbstractProductsRestAttributesTransfer;
use PyzTest\Glue\Products\ProductsApiTester;
use PyzTest\Glue\Products\RestApi\Fixtures\ProductsRestApiFixtures;
use Spryker\Glue\ProductPricesRestApi\ProductPricesRestApiConfig;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Products
 * @group RestApi
 * @group ProductAbstractRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductAbstractRestApiCest
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
    public function requestProductAbstractByNotExistingProductAbstractSku(ProductsApiTester $I): void
    {
        // Act
        $I->sendGET($I->buildProductAbstractUrl('NotExistingSku'));

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Products\ProductsApiTester $I
     *
     * @return void
     */
    public function requestProductAbstractWithoutId(ProductsApiTester $I): void
    {
        // Act
        $I->sendGET($I->buildProductAbstractUrl(''));

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Products\ProductsApiTester $I
     *
     * @return void
     */
    public function requestProductAbstract(ProductsApiTester $I): void
    {
        // Arrange
        $url = $I->buildProductAbstractUrl($this->fixtures->getProductConcreteTransfer()->getAbstractSku());

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource is of correct type')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS);

        $I->amSure('The returned resource has correct id')
            ->whenI()
            ->seeSingleResourceIdEqualTo($this->fixtures->getProductConcreteTransfer()->getAbstractSku());

        $I->amSure('The returned resource has correct self-link')
            ->whenI()
            ->seeSingleResourceHasSelfLink($url);

        $I->amSure('The returned resource contains attribute')
            ->whenI()
            ->seeSingleResourceHasAttribute(AbstractProductsRestAttributesTransfer::URL);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Products\ProductsApiTester $I
     *
     * @return void
     */
    public function requestProductAbstractWithProductConcreteRelationship(ProductsApiTester $I): void
    {
        // Arrange
        $productConcreteTransfer = $this->fixtures->getProductConcreteTransfer();
        $url = $I->buildProductAbstractUrl(
            $productConcreteTransfer->getAbstractSku(),
            [
                ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
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
                ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                $productConcreteTransfer->getSku(),
            );

        $I->amSure('The returned resource has include')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(
                ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                $productConcreteTransfer->getSku(),
            );

        $I->amSure('The include has correct self-link')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdHasSelfLink(
                ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                $productConcreteTransfer->getSku(),
                $I->buildProductConcreteUrl($productConcreteTransfer->getSku()),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Products\ProductsApiTester $I
     *
     * @return void
     */
    public function requestProductAbstractWithProductPriceRelationship(ProductsApiTester $I): void
    {
        // Arrange
        $productAbstractSku = $this->fixtures->getProductConcreteTransfer()->getAbstractSku();
        $url = $I->buildProductAbstractUrl($productAbstractSku, [ProductPricesRestApiConfig::RESOURCE_ABSTRACT_PRODUCT_PRICES]);

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource has relationship')
            ->whenI()
            ->seeSingleResourceHasRelationshipByTypeAndId(
                ProductPricesRestApiConfig::RESOURCE_ABSTRACT_PRODUCT_PRICES,
                $productAbstractSku,
            );

        $I->amSure('The returned resource has include')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(
                ProductPricesRestApiConfig::RESOURCE_ABSTRACT_PRODUCT_PRICES,
                $productAbstractSku,
            );

        $I->amSure('The include has correct self-link')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdHasSelfLink(
                ProductPricesRestApiConfig::RESOURCE_ABSTRACT_PRODUCT_PRICES,
                $productAbstractSku,
                $I->buildProductAbstractPricesUrl($productAbstractSku),
            );
    }
}
