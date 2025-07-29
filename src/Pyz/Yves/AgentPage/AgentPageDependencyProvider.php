<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\AgentPage;

use Spryker\Yves\MultiFactorAuth\Plugin\AuthenticationHandler\Agent\AgentUserMultiFactorAuthenticationHandlerPlugin;
use SprykerShop\Yves\AgentPage\AgentPageDependencyProvider as SprykerAgentPageDependencyProvider;
use SprykerShop\Yves\SessionCustomerValidationPage\Plugin\AgentPage\CustomerUpdateSessionPostImpersonationPlugin;

class AgentPageDependencyProvider extends SprykerAgentPageDependencyProvider
{
    /**
     * @return list<\SprykerShop\Yves\AgentPageExtension\Dependency\Plugin\SessionPostImpersonationPluginInterface>
     */
    protected function getSessionPostImpersonationPlugins(): array
    {
        return [
            new CustomerUpdateSessionPostImpersonationPlugin(),
        ];
    }

    /**
     * @return array<\SprykerShop\Yves\AgentPageExtension\Dependency\Plugin\AuthenticationHandlerPluginInterface>
     */
    protected function getAgentUserAuthenticationHandlerPlugins(): array
    {
        return [
            new AgentUserMultiFactorAuthenticationHandlerPlugin(),
        ];
    }
}
