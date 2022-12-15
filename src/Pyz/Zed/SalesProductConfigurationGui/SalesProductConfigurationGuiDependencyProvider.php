<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\SalesProductConfigurationGui;

use Spryker\Zed\SalesProductConfigurationGui\SalesProductConfigurationGuiDependencyProvider as SprykerSalesProductConfigurationGuiDependencyProvider;
use SprykerShop\Zed\DateTimeConfiguratorPageExample\Communication\Plugin\SalesProductConfigurationGui\ExampleDateTimeProductConfigurationRenderStrategyPlugin;

class SalesProductConfigurationGuiDependencyProvider extends SprykerSalesProductConfigurationGuiDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\SalesProductConfigurationGuiExtension\Dependency\Plugin\ProductConfigurationRenderStrategyPluginInterface>
     */
    protected function getProductConfigurationRenderStrategyPlugins(): array
    {
        return [
            new ExampleDateTimeProductConfigurationRenderStrategyPlugin(),
        ];
    }
}
