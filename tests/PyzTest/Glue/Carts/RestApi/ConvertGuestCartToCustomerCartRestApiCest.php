<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Carts\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\Carts\CartsApiTester;
use PyzTest\Glue\Carts\RestApi\Fixtures\ConvertGuestCartToCustomerCartRestApiFixtures;
use Spryker\Glue\CartsRestApi\CartsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Carts
 * @group RestApi
 * @group ConvertGuestCartToCustomerCartRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ConvertGuestCartToCustomerCartRestApiCest
{
    /**
     * @var string
     */
    protected const ANONYMOUS_PREFIX = 'anonymous:';

    /**
     * @var \PyzTest\Glue\Carts\RestApi\Fixtures\ConvertGuestCartToCustomerCartRestApiFixtures
     */
    protected ConvertGuestCartToCustomerCartRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CartsApiTester $I): void
    {
        /** @var \PyzTest\Glue\Carts\RestApi\Fixtures\ConvertGuestCartToCustomerCartRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(ConvertGuestCartToCustomerCartRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestGuestCartWithXAnonymousAndAuthorizationTokenValidationError(CartsApiTester $I): void
    {
        // Arrange
        $this->requestCustomerLoginWithXAnonymousCustomerUniqueIdHeader($I);
        $quoteUuid = $this->fixtures->getGuestQuoteTransfer()->getUuid();
        $url = $I->buildCartUrl($quoteUuid, [CartsRestApiConfig::RESOURCE_CART_ITEMS]);

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestGuestCartCollectionIsEmpty(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader(CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID, $this->fixtures->getGuestCustomerReference());

        // Act
        $I->sendGET($I->buildGuestCartsUrl());

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
        $I->seeResponseDataContainsEmptyCollection();
    }

    /**
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    protected function authorizeCustomer(CartsApiTester $I): void
    {
        $token = $I->haveAuthorizationToGlue($this->fixtures->getCustomerTransfer())->getAccessToken();

        $I->amBearerAuthenticated($token);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    protected function requestCustomerLoginWithXAnonymousCustomerUniqueIdHeader(CartsApiTester $I): void
    {
        $I->haveHttpHeader(CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID, $this->fixtures->getGuestCustomerReference());
        $token = $I->haveAuthorizationToGlue(
            $this->fixtures->getCustomerTransfer(),
            static::ANONYMOUS_PREFIX . $this->fixtures->getGuestCustomerReference(),
        )->getAccessToken();

        $I->amBearerAuthenticated($token);
    }
}
