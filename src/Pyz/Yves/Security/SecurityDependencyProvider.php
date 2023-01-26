<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Security;

use Spryker\Yves\Security\Plugin\Security\RememberMeSecurityPlugin;
use Spryker\Yves\Security\SecurityDependencyProvider as SprykerSecurityDependencyProvider;
use SprykerShop\Yves\AgentPage\Plugin\Security\AgentPageSecurityPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\Security\CustomerPageSecurityPlugin;
use SprykerShop\Yves\SessionAgentValidation\Plugin\Security\SaveAgentSessionSecurityPlugin;
use SprykerShop\Yves\SessionAgentValidation\Plugin\Security\SessionAgentValidationSecurityAuthenticationListenerFactoryTypeExpanderPlugin;
use SprykerShop\Yves\SessionAgentValidation\Plugin\Security\ValidateAgentSessionSecurityPlugin;
use SprykerShop\Yves\SessionCustomerValidationPage\Plugin\Security\SaveCustomerSessionSecurityPlugin;
use SprykerShop\Yves\SessionCustomerValidationPage\Plugin\Security\ValidateCustomerSessionSecurityPlugin;

class SecurityDependencyProvider extends SprykerSecurityDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\SecurityExtension\Dependency\Plugin\SecurityPluginInterface>
     */
    protected function getSecurityPlugins(): array
    {
        return [
            new RememberMeSecurityPlugin(),
            new AgentPageSecurityPlugin(),
            new CustomerPageSecurityPlugin(),
            new ValidateCustomerSessionSecurityPlugin(),
            new SaveCustomerSessionSecurityPlugin(),
            new ValidateAgentSessionSecurityPlugin(),
            new SaveAgentSessionSecurityPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Shared\SecurityExtension\Dependency\Plugin\SecurityAuthenticationListenerFactoryTypeExpanderPluginInterface>
     */
    protected function getSecurityAuthenticationListenerFactoryTypeExpanderPlugins(): array
    {
        return [
            new SessionAgentValidationSecurityAuthenticationListenerFactoryTypeExpanderPlugin(),
        ];
    }
}
