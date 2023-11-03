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
 * @group AbstractAlternativeProductsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class AbstractAlternativeProductsRestApiCest
{
    /**
     * @var \PyzTest\Glue\AlternativeProducts\RestApi\AbstractAlternativeProductsRestApiFixtures
     */
    protected AbstractAlternativeProductsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester $I
     *
     * @return void
     */
    public function loadFixtures(AlternativeProductsRestApiTester $I): void
    {
        /** @var \PyzTest\Glue\AlternativeProducts\RestApi\AbstractAlternativeProductsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(AbstractAlternativeProductsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester $I
     *
     * @return void
     */
    public function requestAbstractAlternativeProducts(AlternativeProductsRestApiTester $I): void
    {
        // Arrange
        $I->haveFullProduct();
        $productAbstractSku = $this->fixtures->getAlternativeProductConcreteTransfer()->getAbstractSku();
        $url = $I->buildAbstractAlternativeProductsUrl(
            $this->fixtures->getProductConcreteTransfer()->getSku(),
        );

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Response data contains resource collection')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfType(ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS);

        $I->amSure('Resource collection has resource')
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($productAbstractSku);

        $I->amSure('Resource has correct self-link')
            ->whenI()
            ->seeResourceByIdHasSelfLink($productAbstractSku, $I->buildProductAbstractUrl($productAbstractSku));
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\AlternativeProducts\AlternativeProductsRestApiTester $I
     *
     * @return void
     */
    public function requestAbstractAlternativeProductsByNotExistingProductConcreteSku(
        AlternativeProductsRestApiTester $I,
    ): void {
        // Act
        $I->sendGET($I->buildAbstractAlternativeProductsUrl('NotExistingSku'));

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }
}
