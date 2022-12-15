<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceCartConnector;

use Spryker\Zed\PriceCartConnector\PriceCartConnectorDependencyProvider as SprykerPriceCartConnectorDependencyProvider;
use Spryker\Zed\ProductConfigurationCart\Communication\Plugin\PriceCartConnector\ProductConfigurationCartItemQuantityCounterStrategyPlugin;
use Spryker\Zed\ProductConfigurationCart\Communication\Plugin\PriceCartConnector\ProductConfigurationPriceProductExpanderPlugin;

class PriceCartConnectorDependencyProvider extends SprykerPriceCartConnectorDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\PriceCartConnectorExtension\Dependency\Plugin\PriceProductExpanderPluginInterface>
     */
    protected function getPriceProductExpanderPlugins(): array
    {
        return [
            new ProductConfigurationPriceProductExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PriceCartConnectorExtension\Dependency\Plugin\CartItemQuantityCounterStrategyPluginInterface>
     */
    protected function getCartItemQuantityCounterStrategyPlugins(): array
    {
        return [
            new ProductConfigurationCartItemQuantityCounterStrategyPlugin(),
        ];
    }
}
