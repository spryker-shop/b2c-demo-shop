<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\UpSellingProducts\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group UpSellingProducts
 * @group RestApi
 * @group CartUpSellingProductsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CartUpSellingProductsRestApiCest
{
    /**
     * @var \PyzTest\Glue\UpSellingProducts\RestApi\CartUpSellingProductsRestApiFixtures
     */
    protected CartUpSellingProductsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(UpSellingProductsApiTester $I): void
    {
        /** @var \PyzTest\Glue\UpSellingProducts\RestApi\CartUpSellingProductsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(CartUpSellingProductsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\UpSellingProducts\UpSellingProductsApiTester $I
     *
     * @return void
     */
    public function requestCartUpSellingProductsByNotExistingCartUuid(UpSellingProductsApiTester $I): void
    {
        // Arrange
        $oauthResponseTransfer = $I->haveAuthorizationToGlue($this->fixtures->getQuoteTransfer()->getCustomer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($I->buildCartUpSellingProductsUrl('NotExistingUuid'));

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }
}
