<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\SecurityBlocker;

use Spryker\Client\SecurityBlocker\SecurityBlockerDependencyProvider as SprykerSecurityBlockerDependencyProvider;
use Spryker\Client\SecurityBlockerBackoffice\Plugin\SecurityBlocker\BackofficeUserSecurityBlockerConfigurationSettingsExpanderPlugin;
use Spryker\Client\SecurityBlockerBackoffice\Plugin\SecurityBlocker\UserSecurityBlockerLoginRealmConfigurationExpanderPlugin;
use Spryker\Client\SecurityBlockerStorefrontAgent\Plugin\SecurityBlocker\AgentSecurityBlockerConfigurationSettingsExpanderPlugin;
use Spryker\Client\SecurityBlockerStorefrontCustomer\Plugin\SecurityBlocker\CustomerSecurityBlockerConfigurationSettingsExpanderPlugin;
use Spryker\Client\SecurityBlockerStorefrontCustomer\Plugin\SecurityBlocker\CustomerSecurityBlockerLoginRealmConfigurationExpanderPlugin;

/**
 * @method \Spryker\Client\SecurityBlocker\SecurityBlockerConfig getConfig()
 */
class SecurityBlockerDependencyProvider extends SprykerSecurityBlockerDependencyProvider
{
    /**
     * @return list<\Spryker\Client\SecurityBlockerExtension\Dependency\Plugin\SecurityBlockerConfigurationSettingsExpanderPluginInterface>
     */
    protected function getSecurityBlockerConfigurationSettingsExpanderPlugins(): array
    {
        return [
            new BackofficeUserSecurityBlockerConfigurationSettingsExpanderPlugin(),
            new AgentSecurityBlockerConfigurationSettingsExpanderPlugin(),
            new CustomerSecurityBlockerConfigurationSettingsExpanderPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Client\SecurityBlockerExtension\Dependency\Plugin\SecurityBlockerLoginRealmConfigurationExpanderPluginInterface>
     */
    protected function getSecurityBlockerLoginRealmConfigurationExpanderPlugins(): array
    {
        return [
            new CustomerSecurityBlockerLoginRealmConfigurationExpanderPlugin(),
            new UserSecurityBlockerLoginRealmConfigurationExpanderPlugin(),
        ];
    }
}
