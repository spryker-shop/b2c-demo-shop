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
 * @group PriceProductAbstractRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class PriceProductAbstractRestApiCest
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
    public function requestTheNonExistingProductAbstractPrices(PriceProductsApiTester $I): void
    {
        // Act
        $I->sendGET('abstract-products/non-exist/abstract-product-prices');

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
    public function requestProductAbstractPricesWithoutId(PriceProductsApiTester $I): void
    {
        // Act
        $I->sendGET('abstract-product-prices');

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
    public function requestExistingProductAbstractPrices(PriceProductsApiTester $I): void
    {
        // Act
        $I->sendGET(
            $I->formatUrl(
                'abstract-products/{ProductAbstractSku}/abstract-product-prices',
                [
                    'ProductAbstractSku' => $this->fixtures->getProductConcreteTransfer()->getAbstractSku(),
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource is of type abstract-product-prices')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfTypeWithSizeOf('abstract-product-prices', 1);

        $I->amSure('Returned resource has correct id')
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($this->fixtures->getProductConcreteTransfer()->getAbstractSku());
    }
}
