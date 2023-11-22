<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\RelatedProducts\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\RelatedProducts\RelatedProductsApiTester;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group RelatedProducts
 * @group RestApi
 * @group RelatedProductsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class RelatedProductsRestApiCest
{
    /**
     * @var \PyzTest\Glue\RelatedProducts\RestApi\RelatedProductsRestApiFixtures
     */
    protected RelatedProductsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\RelatedProducts\RelatedProductsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(RelatedProductsApiTester $I): void
    {
        /** @var \PyzTest\Glue\RelatedProducts\RestApi\RelatedProductsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(RelatedProductsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\RelatedProducts\RelatedProductsApiTester $I
     *
     * @return void
     */
    public function requestRelatedProducts(RelatedProductsApiTester $I): void
    {
        // Arrange
        $productAbstractSku = $this->fixtures->getProductConcreteTransfer()->getAbstractSku();
        $url = $I->buildRelatedProductsUrl($this->fixtures->getAnotherProductConcreteTransfer()->getAbstractSku());

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Response data contains abstract-products resource collection')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfType(ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS);

        $I->amSure('Resource collection has abstract-products resource')
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($productAbstractSku);

        $I->amSure('Resource has correct self-link')
            ->whenI()
            ->seeResourceByIdHasSelfLink($productAbstractSku, $I->buildProductAbstractUrl($productAbstractSku));
    }
}
