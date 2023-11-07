<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\AgentAuth\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\AgentAuth\AgentAuthRestApiTester;
use PyzTest\Glue\AgentAuth\RestApi\Fixtures\AgentAccessTokensRestApiFixtures;
use Spryker\Glue\AgentAuthRestApi\AgentAuthRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group AgentAuth
 * @group RestApi
 * @group AgentAccessTokensRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class AgentAccessTokensRestApiCest
{
    /**
     * @var \PyzTest\Glue\AgentAuth\RestApi\Fixtures\AgentAccessTokensRestApiFixtures
     */
    protected AgentAccessTokensRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\AgentAuth\AgentAuthRestApiTester $I
     *
     * @return void
     */
    public function loadFixtures(AgentAuthRestApiTester $I): void
    {
        /** @var \PyzTest\Glue\AgentAuth\RestApi\Fixtures\AgentAccessTokensRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(AgentAccessTokensRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\AgentAuth\AgentAuthRestApiTester $I
     *
     * @return void
     */
    public function requestAccessTokenForExistingAgentUser(AgentAuthRestApiTester $I): void
    {
        // Act
        $I->sendPOST(AgentAuthRestApiConfig::RESOURCE_AGENT_ACCESS_TOKENS, [
            'data' => [
                'type' => AgentAuthRestApiConfig::RESOURCE_AGENT_ACCESS_TOKENS,
                'attributes' => [
                    'username' => $this->fixtures->getUserTransfer()->getUsername(),
                    'password' => AgentAccessTokensRestApiFixtures::TEST_PASSWORD,
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
     * @param \PyzTest\Glue\AgentAuth\AgentAuthRestApiTester $I
     *
     * @return void
     */
    public function requestAccessTokenForNonExistingAgentUser(AgentAuthRestApiTester $I): void
    {
        // Act
        $I->sendPOST(AgentAuthRestApiConfig::RESOURCE_AGENT_ACCESS_TOKENS, [
            'data' => [
                'type' => AgentAuthRestApiConfig::RESOURCE_AGENT_ACCESS_TOKENS,
                'attributes' => [
                    'username' => 'NonExistingAgent',
                    'password' => AgentAccessTokensRestApiFixtures::TEST_PASSWORD,
                ],
            ],
        ]);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
        $I->seeResponseDoesNotHaveAccessToken();
        $I->seeResponseDoesNotHaveRefreshToken();
        $I->seeResponseMatchesOpenApiSchema();
    }
}
