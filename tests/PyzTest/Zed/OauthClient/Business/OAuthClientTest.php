<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\OauthClient\Business;

use Codeception\Test\Unit;
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
    protected const STORE_REFERENCE = 'dev-DE';

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
        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);

        $accessTokenRequestTransfer = (new AccessTokenRequestTransfer());

        $mockOAuthAccessTokenProviderPlugin = $this->createMock(OauthAccessTokenProviderPluginInterface::class);
        $mockOAuthAccessTokenProviderPlugin->method('isApplicable')->willReturn(true);

        // Assert
        $mockOAuthAccessTokenProviderPlugin->expects($this->once())->method('getAccessToken')->with(
            $this->callback(function (AccessTokenRequestTransfer $accessTokenRequestTransfer) {
                $this->assertNotNull($accessTokenRequestTransfer->getAccessTokenRequestOptions());
                $this->assertSame(
                    $accessTokenRequestTransfer->getAccessTokenRequestOptions()->getStoreReference(),
                    static::STORE_REFERENCE,
                );

                return true;
            }),
        );

        $this->tester->setOauthAccessTokenProviderPluginsDependency([$mockOAuthAccessTokenProviderPlugin]);

        // Act
        $this->tester->getOauthClientFacade()->getAccessToken($accessTokenRequestTransfer);
    }
}
