<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\PriceProducts\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\PriceProducts\PriceProductsApiTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group PriceProducts
 * @group RestApi
 * @group PriceProductConcreteRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class PriceProductConcreteRestApiCest
{
    /**
     * @var \PyzTest\Glue\PriceProducts\RestApi\PriceProductsRestApiFixtures
     */
    protected PriceProductsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\PriceProducts\PriceProductsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(PriceProductsApiTester $I): void
    {
        /** @var \PyzTest\Glue\PriceProducts\RestApi\PriceProductsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(PriceProductsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PriceProducts\PriceProductsApiTester $I
     *
     * @return void
     */
    public function requestTheNonExistingProductConcretePrices(PriceProductsApiTester $I): void
    {
        // Act
        $I->sendGET('concrete-products/non-exist/concrete-product-prices');

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PriceProducts\PriceProductsApiTester $I
     *
     * @return void
     */
    public function requestProductConcretePricesWithoutId(PriceProductsApiTester $I): void
    {
        // Act
        $I->sendGET('concrete-product-prices');

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PriceProducts\PriceProductsApiTester $I
     *
     * @return void
     */
    public function requestExistingProductConcretePrices(PriceProductsApiTester $I): void
    {
        // Act
        $I->sendGET(
            $I->formatUrl(
                'concrete-products/{ProductConcreteSku}/concrete-product-prices',
                [
                    'ProductConcreteSku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource is of type concrete-product-prices')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfTypeWithSizeOf('concrete-product-prices', 1);

        $I->amSure('Returned resource has correct id')
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($this->fixtures->getProductConcreteTransfer()->getSku());
    }
}
