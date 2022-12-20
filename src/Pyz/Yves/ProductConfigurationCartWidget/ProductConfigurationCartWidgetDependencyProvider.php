<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductConfigurationCartWidget;

use SprykerShop\Yves\DateTimeConfiguratorPageExample\Plugin\ProductConfigurationCartWidget\ExampleDateTimeCartProductConfigurationRenderStrategyPlugin;
use SprykerShop\Yves\ProductConfigurationCartWidget\ProductConfigurationCartWidgetDependencyProvider as SprykerProductConfigurationCartWidgetDependencyProvider;

class ProductConfigurationCartWidgetDependencyProvider extends SprykerProductConfigurationCartWidgetDependencyProvider
{
    /**
     * @return array<\SprykerShop\Yves\ProductConfigurationCartWidgetExtension\Dependency\Plugin\CartProductConfigurationRenderStrategyPluginInterface>
     */
    protected function getCartProductConfigurationRenderStrategyPlugins(): array
    {
        return [
            new ExampleDateTimeCartProductConfigurationRenderStrategyPlugin(),
        ];
    }
}
