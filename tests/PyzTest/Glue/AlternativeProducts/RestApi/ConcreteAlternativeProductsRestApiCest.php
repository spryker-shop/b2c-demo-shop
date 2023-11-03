<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\AlternativeProducts\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group AlternativeProducts
 * @group RestApi
 * @group ConcreteAlternativeProductsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ConcreteAlternativeProductsRestApiCest
{
    /**
     * @var \PyzTest\Glue\AlternativeProducts\RestApi\ConcreteAlternativeProductsRestApiFixtures
     */
    protected ConcreteAlternativeProductsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester $I
     *
     * @return void
     */
    public function loadFixtures(AlternativeProductsRestApiTester $I): void
    {
        /** @var \PyzTest\Glue\AlternativeProducts\RestApi\ConcreteAlternativeProductsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(ConcreteAlternativeProductsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester $I
     *
     * @return void
     */
    public function requestConcreteAlternativeProducts(AlternativeProductsRestApiTester $I): void
    {
        // Arrange
        $productConcreteSku = $this->fixtures->getAlternativeProductConcreteTransfer()->getSku();
        $url = $I->buildConcreteAlternativeProductsUrl($this->fixtures->getProductConcreteTransfer()->getSku());

        // Act
        $I->sendGET($url);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        // Assert
        $I->amSure('Response data contains resource collection')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfType(ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS);

        $I->amSure('Resource collection has resource')
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($productConcreteSku);

        $I->amSure('Resource has correct self-link')
            ->whenI()
            ->seeResourceByIdHasSelfLink($productConcreteSku, $I->buildProductConcreteUrl($productConcreteSku));
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester $I
     *
     * @return void
     */
    public function requestConcreteAlternativeProductsByNotExistingProductConcreteSku(
        AlternativeProductsRestApiTester $I,
    ): void {
        // Act
        $I->sendGET($I->buildConcreteAlternativeProductsUrl('NotExistingSku'));

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }
}
