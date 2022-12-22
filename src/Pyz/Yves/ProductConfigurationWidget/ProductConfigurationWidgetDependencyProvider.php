<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductConfigurationWidget;

use SprykerShop\Yves\DateTimeConfiguratorPageExample\Plugin\ProductConfigurationWidget\ExampleDateTimeProductConfigurationRenderStrategyPlugin;
use SprykerShop\Yves\ProductConfigurationWidget\ProductConfigurationWidgetDependencyProvider as SprykerProductConfigurationWidgetDependencyProvider;

class ProductConfigurationWidgetDependencyProvider extends SprykerProductConfigurationWidgetDependencyProvider
{
    /**
     * @return array<\SprykerShop\Yves\ProductConfigurationWidgetExtension\Dependency\Plugin\ProductConfigurationRenderStrategyPluginInterface>
     */
    protected function getProductConfigurationRenderStrategyPlugins(): array
    {
        return [
            new ExampleDateTimeProductConfigurationRenderStrategyPlugin(),
        ];
    }
}
