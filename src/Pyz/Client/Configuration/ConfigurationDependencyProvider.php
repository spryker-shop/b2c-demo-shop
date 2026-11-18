<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\Configuration;

use Spryker\Client\Configuration\ConfigurationDependencyProvider as SprykerConfigurationDependencyProvider;
use Spryker\Client\Store\Plugin\Configuration\StoreScopeConfigurationValueRequestExpanderPlugin;

class ConfigurationDependencyProvider extends SprykerConfigurationDependencyProvider
{
    /**
     * @return array<\Spryker\Client\ConfigurationExtension\Dependency\Plugin\ConfigurationValueRequestExpanderPluginInterface>
     */
    protected function getConfigurationValueRequestExpanderPlugins(): array
    {
        return [
            new StoreScopeConfigurationValueRequestExpanderPlugin(),
        ];
    }
}
