<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\PriceProductVolumes\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\PriceProductVolumes\PriceProductVolumesApiTester;
use PyzTest\Glue\PriceProductVolumes\RestApi\Fixtures\PriceProductVolumesRestApiFixtures;
use Spryker\Glue\ProductPricesRestApi\ProductPricesRestApiConfig;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group PriceProductVolumes
 * @group RestApi
 * @group ProductAbstractPriceProductVolumesRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductAbstractPriceProductVolumesRestApiCest
{
    /**
     * @var \PyzTest\Glue\PriceProductVolumes\RestApi\Fixtures\PriceProductVolumesRestApiFixtures
     */
    protected PriceProductVolumesRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\PriceProductVolumes\PriceProductVolumesApiTester $I
     *
     * @return void
     */
    public function loadFixtures(PriceProductVolumesApiTester $I): void
    {
        /** @var \PyzTest\Glue\PriceProductVolumes\RestApi\Fixtures\PriceProductVolumesRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(PriceProductVolumesRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PriceProductVolumes\PriceProductVolumesApiTester $I
     *
     * @return void
     */
    public function requestProductAbstractPrices(PriceProductVolumesApiTester $I): void
    {
        // Act
        $I->sendGET($I->formatFullUrl(
            '{resourceAbstractProducts}/{productAbstractSku}/{resourceAbstractProductPrices}',
            [
                'resourceAbstractProducts' => ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
                'resourceAbstractProductPrices' => ProductPricesRestApiConfig::RESOURCE_ABSTRACT_PRODUCT_PRICES,
                'productAbstractSku' => $this->fixtures->getProductConcreteTransfer()->getAbstractSku(),
            ],
        ));

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource is of type abstract-product-prices')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfTypeWithSizeOf(ProductPricesRestApiConfig::RESOURCE_ABSTRACT_PRODUCT_PRICES, 1);

        $I->amSure('Returned resource has correct id')
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($this->fixtures->getProductConcreteTransfer()->getAbstractSku());

        $I->amSure('Returned resource has volume prices')
            ->whenI()
            ->seeResourceCollectionHasAttribute($this->fixtures::VOLUME_PRICE_ATTRIBUTE_JSON_PATH);

        $I->amSure('Returned volume prices are correct')
            ->whenI()
            ->seeVolumePricesEqualToExpectedValue($this->fixtures::VOLUME_PRICE_DATA);
    }
}
