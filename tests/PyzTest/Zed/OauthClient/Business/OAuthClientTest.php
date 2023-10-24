<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\OauthClient\Business;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\AccessTokenRequestBuilder;
use Generated\Shared\Transfer\AccessTokenRequestOptionsTransfer;
use Generated\Shared\Transfer\AccessTokenRequestTransfer;
use Spryker\Zed\OauthClientExtension\Dependency\Plugin\OauthAccessTokenProviderPluginInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group OauthClient
 * @group Business
 * @group OAuthClientTest
 * Add your own group annotations below this line
 */
class OAuthClientTest extends Unit
{
    /**
     * @var \PyzTest\Zed\OauthClient\OauthClientBusinessTester
     */
    protected $tester;

    /**
     * @var string
     */
    protected const AUDIENCE = 'aud';

    /**
     * @var string
     */
    protected const TEST_SUCCESS_PROVIDER_NAME = 'test-success-provider-name';

    /**
     * @return void
     */
    public function testOauthTokenRequestContainsAllTheNecessaryData(): void
    {
        // Arrange
        $accessTokenRequestTransfer = (new AccessTokenRequestBuilder())->withAccessTokenRequestOptions([
            AccessTokenRequestOptionsTransfer::TENANT_IDENTIFIER => $this->tester->getModuleConfig()->getTenantIdentifier(),
        ])->build();
        $expectedAccessTokenRequestTransfer = (new AccessTokenRequestBuilder($accessTokenRequestTransfer->modifiedToArray()))->build();

        $mockOAuthAccessTokenProviderPlugin = $this->createMock(OauthAccessTokenProviderPluginInterface::class);
        $mockOAuthAccessTokenProviderPlugin->method('isApplicable')->willReturn(true);

        // Assert
        $mockOAuthAccessTokenProviderPlugin->expects($this->once())->method('getAccessToken')->with(
            $this->callback(function (AccessTokenRequestTransfer $accessTokenRequestTransfer) use ($expectedAccessTokenRequestTransfer) {
                $this->assertEquals(
                    $expectedAccessTokenRequestTransfer,
                    $accessTokenRequestTransfer,
                );

                return true;
            }),
        );

        $this->tester->setOauthAccessTokenProviderPluginsDependency([$mockOAuthAccessTokenProviderPlugin]);

        // Act
        $this->tester->getOauthClientFacade()->getAccessToken($accessTokenRequestTransfer);
    }
}
