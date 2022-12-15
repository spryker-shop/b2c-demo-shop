<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Application;

use Spryker\Yves\Application\ApplicationDependencyProvider as SprykerApplicationDependencyProvider;
use SprykerShop\Yves\DateTimeConfiguratorPageExample\Plugin\Application\ConfiguratorSecurityHeaderExpanderPlugin;

class ApplicationDependencyProvider extends SprykerApplicationDependencyProvider
{
    /**
     * @return array<\Spryker\Yves\ApplicationExtension\Dependency\Plugin\SecurityHeaderExpanderPluginInterface>
     */
    protected function getSecurityHeaderExpanderPlugins(): array
    {
        return [
            new ConfiguratorSecurityHeaderExpanderPlugin(),
        ];
    }
}
