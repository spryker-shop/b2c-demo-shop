<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\UpSellingProducts\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester;
use Spryker\Glue\CartsRestApi\CartsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group UpSellingProducts
 * @group RestApi
 * @group GuestCartUpSellingProductsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class GuestCartUpSellingProductsRestApiCest
{
    /**
     * @var \PyzTest\Glue\UpSellingProducts\RestApi\GuestCartUpSellingProductsRestApiFixtures
     */
    protected GuestCartUpSellingProductsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(UpSellingProductsApiTester $I): void
    {
        /** @var \PyzTest\Glue\UpSellingProducts\RestApi\GuestCartUpSellingProductsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(GuestCartUpSellingProductsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester $I
     *
     * @return void
     */
    public function requestGuestCartUpSellingProductsByNotExistingCartUuid(UpSellingProductsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(
            CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
            'NotExistingReference',
        );

        // Act
        $I->sendGET($I->buildGuestCartUpSellingProductsUrl('NotExistingUuid'));

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }
}
