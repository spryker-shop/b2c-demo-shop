<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Auth\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\Auth\AuthRestApiTester;
use Spryker\Glue\AuthRestApi\AuthRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Auth
 * @group RestApi
 * @group AccessTokensRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class AccessTokensRestApiCest
{
    /**
     * @var \PyzTest\Glue\Auth\RestApi\AccessTokensRestApiFixtures
     */
    protected AccessTokensRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return void
     */
    public function loadFixtures(AuthRestApiTester $I): void
    {
        /** @var \PyzTest\Glue\Auth\RestApi\AccessTokensRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(AccessTokensRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return void
     */
    public function requestAccessTokenForExistingCustomer(AuthRestApiTester $I): void
    {
        // Act
        $I->sendPOST(AuthRestApiConfig::RESOURCE_ACCESS_TOKENS, [
            'data' => [
                'type' => AuthRestApiConfig::RESOURCE_ACCESS_TOKENS,
                'attributes' => [
                    'username' => $this->fixtures->getCustomerTransfer()->getEmail(),
                    'password' => AccessTokensRestApiFixtures::TEST_PASSWORD,
                ],
            ],
        ]);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->seeResponseHasAccessToken();
        $I->seeResponseHasRefreshToken();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return void
     */
    public function requestAccessTokenForNotExistingCustomer(AuthRestApiTester $I): void
    {
        // Act
        $I->sendPOST(AuthRestApiConfig::RESOURCE_ACCESS_TOKENS, [
            'data' => [
                'type' => AuthRestApiConfig::RESOURCE_ACCESS_TOKENS,
                'attributes' => [
                    'username' => uniqid($this->fixtures->getCustomerTransfer()->getEmail()),
                    'password' => AccessTokensRestApiFixtures::TEST_PASSWORD,
                ],
            ],
        ]);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
        $I->dontSeeResponseHasAccessToken();
        $I->dontSeeResponseHasRefreshToken();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return void
     */
    public function requestAccessTokenWithWrongCredentials(AuthRestApiTester $I): void
    {
        // Act
        $I->sendPOST(AuthRestApiConfig::RESOURCE_ACCESS_TOKENS, [
            'data' => [
                'type' => AuthRestApiConfig::RESOURCE_ACCESS_TOKENS,
                'attributes' => [
                    'username' => uniqid($this->fixtures->getCustomerTransfer()->getEmail()),
                    'password' => uniqid(AccessTokensRestApiFixtures::TEST_PASSWORD),
                ],
            ],
        ]);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
        $I->dontSeeResponseHasAccessToken();
        $I->dontSeeResponseHasRefreshToken();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return void
     */
    public function requestAccessTokenWithEmptyPassword(AuthRestApiTester $I): void
    {
        // Act
        $I->sendPOST(AuthRestApiConfig::RESOURCE_ACCESS_TOKENS, [
            'data' => [
                'type' => AuthRestApiConfig::RESOURCE_ACCESS_TOKENS,
                'attributes' => [
                    'username' => $this->fixtures->getCustomerTransfer()->getEmail(),
                    'password' => '',
                ],
            ],
        ]);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->dontSeeResponseHasAccessToken();
        $I->dontSeeResponseHasRefreshToken();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return void
     */
    public function requestAccessTokenWithEmptyUsername(AuthRestApiTester $I): void
    {
        // Act
        $I->sendPOST(AuthRestApiConfig::RESOURCE_ACCESS_TOKENS, [
            'data' => [
                'type' => AuthRestApiConfig::RESOURCE_ACCESS_TOKENS,
                'attributes' => [
                    'username' => '',
                    'password' => AccessTokensRestApiFixtures::TEST_PASSWORD,
                ],
            ],
        ]);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->dontSeeResponseHasAccessToken();
        $I->dontSeeResponseHasRefreshToken();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return void
     */
    public function requestAccessTokenWithInvalidPostData(AuthRestApiTester $I): void
    {
        // Act
        $I->sendPOST(AuthRestApiConfig::RESOURCE_ACCESS_TOKENS, [
            'type' => AuthRestApiConfig::RESOURCE_ACCESS_TOKENS,
            'attributes' => [
                'username' => $this->fixtures->getCustomerTransfer()->getEmail(),
                'password' => AccessTokensRestApiFixtures::TEST_PASSWORD,
            ],
        ]);

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->dontSeeResponseHasAccessToken();
        $I->dontSeeResponseHasRefreshToken();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return void
     */
    public function requestAccessTokenWithInvalidType(AuthRestApiTester $I): void
    {
        // Act
        $I->sendPOST(AuthRestApiConfig::RESOURCE_ACCESS_TOKENS, [
            'data' => [
                'type' => AuthRestApiConfig::RESOURCE_REFRESH_TOKENS,
                'attributes' => [
                    'username' => $this->fixtures->getCustomerTransfer()->getEmail(),
                    'password' => AccessTokensRestApiFixtures::TEST_PASSWORD,
                ],
            ],
        ]);

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->dontSeeResponseHasAccessToken();
        $I->dontSeeResponseHasRefreshToken();
        $I->seeResponseMatchesOpenApiSchema();
    }
}
