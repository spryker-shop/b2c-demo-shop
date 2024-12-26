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
 * @group ProductConcretePriceProductVolumesRestApiCest
 * Add your own group annotations below this line
 */
class ProductConcretePriceProductVolumesRestApiCest
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
    public function requestConcreteProductPrices(PriceProductVolumesApiTester $I): void
    {
        // Act
        $I->sendGET($I->formatFullUrl(
            '{resourceConcreteProducts}/{productConcreteSku}/{resourceConcreteProductPrices}',
            [
                'resourceConcreteProducts' => ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                'resourceConcreteProductPrices' => ProductPricesRestApiConfig::RESOURCE_CONCRETE_PRODUCT_PRICES,
                'productConcreteSku' => $this->fixtures->getProductConcreteTransfer()->getSku(),
            ],
        ));

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource is of type concrete-product-prices')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfTypeWithSizeOf(ProductPricesRestApiConfig::RESOURCE_CONCRETE_PRODUCT_PRICES, 1);

        $I->amSure('Returned resource has correct id')
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($this->fixtures->getProductConcreteTransfer()->getSku());

        $I->amSure('Returned resource has volume prices')
            ->whenI()
            ->seeResourceCollectionHasAttribute($this->fixtures::VOLUME_PRICE_ATTRIBUTE_JSON_PATH);

        $I->amSure('Returned volume prices are correct')
            ->whenI()
            ->seeVolumePricesEqualToExpectedValue($this->fixtures::VOLUME_PRICE_DATA);
    }
}
