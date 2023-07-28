<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PyzTest\Zed\OauthClient;

use Codeception\Actor;
use Spryker\Zed\OauthClient\Business\OauthClientFacadeInterface;
use Spryker\Zed\OauthClient\OauthClientDependencyProvider;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(\PyzTest\Zed\OauthClient\PHPMD)
 */
class OauthClientBusinessTester extends Actor
{
    use _generated\OauthClientBusinessTesterActions;

    /**
     * @return \Spryker\Zed\MessageBroker\Business\MessageBrokerFacadeInterface
     */
    public function getOauthClientFacade(): OauthClientFacadeInterface
    {
        return $this->getLocator()->oauthClient()->facade();
    }

    /**
     * @param array<\Spryker\Zed\OauthClientExtension\Dependency\Plugin\OauthAccessTokenProviderPluginInterface> $pluginStack
     *
     * @return void
     */
    public function setOauthAccessTokenProviderPluginsDependency(array $pluginStack): void
    {
        $this->setDependency(
            OauthClientDependencyProvider::PLUGINS_OAUTH_ACCESS_TOKEN_PROVIDER,
            $pluginStack,
        );
    }
}
