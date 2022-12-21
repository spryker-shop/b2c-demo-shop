<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\AgentPage;

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
}
