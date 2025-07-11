<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\MultiFactorAuth;

use Spryker\Yves\MultiFactorAuth\MultiFactorAuthDependencyProvider as SprykerMultiFactorAuthDependencyProvider;
use Spryker\Yves\MultiFactorAuth\Plugin\Factors\Email\AgentUserEmailMultiFactorAuthPlugin;
use Spryker\Yves\MultiFactorAuth\Plugin\Factors\Email\CustomerEmailMultiFactorAuthPlugin;
use SprykerShop\Yves\AgentPage\Plugin\MultiFactorAuth\PostAgentLoginMultiFactorAuthenticationPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\MultiFactorAuth\PostCustomerLoginMultiFactorAuthenticationPlugin;

class MultiFactorAuthDependencyProvider extends SprykerMultiFactorAuthDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\MultiFactorAuthExtension\Dependency\Plugin\MultiFactorAuthPluginInterface>
     */
    protected function getCustomerMultiFactorAuthPlugins(): array
    {
        return [
            new CustomerEmailMultiFactorAuthPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\MultiFactorAuthExtension\Dependency\Plugin\MultiFactorAuthPluginInterface>
     */
    protected function getAgentMultiFactorAuthPlugins(): array
    {
        return [
            new AgentUserEmailMultiFactorAuthPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\MultiFactorAuthExtension\Dependency\Plugin\PostLoginMultiFactorAuthenticationPluginInterface>
     */
    protected function getPostLoginMultiFactorAuthenticationPlugins(): array
    {
        return [
            new PostCustomerLoginMultiFactorAuthenticationPlugin(),
            new PostAgentLoginMultiFactorAuthenticationPlugin(),
        ];
    }
}
