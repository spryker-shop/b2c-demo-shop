<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Configuration;

use Spryker\Zed\Configuration\ConfigurationDependencyProvider as SprykerConfigurationDependencyProvider;
use Spryker\Zed\Store\Communication\Plugin\Configuration\StoreConfigurationScopeIdentifierProviderPlugin;

class ConfigurationDependencyProvider extends SprykerConfigurationDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\ConfigurationExtension\Dependency\Plugin\ConfigurationScopeIdentifierProviderPluginInterface>
     */
    protected function getScopeIdentifierProviderPlugins(): array
    {
        return [
            new StoreConfigurationScopeIdentifierProviderPlugin(),
        ];
    }
}
