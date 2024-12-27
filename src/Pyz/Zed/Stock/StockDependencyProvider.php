<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Stock;

use Spryker\Zed\Availability\Communication\Plugin\Stock\AvailabilityStockUpdateHandlerPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductBundle\Communication\Plugin\Stock\ProductBundleAvailabilityHandlerPlugin;
use Spryker\Zed\Stock\StockDependencyProvider as SprykerStockDependencyProvider;
use Spryker\Zed\StockAddress\Communication\Plugin\Stock\StockAddressStockCollectionExpanderPlugin;
use Spryker\Zed\StockAddress\Communication\Plugin\Stock\StockAddressStockPostCreatePlugin;
use Spryker\Zed\StockAddress\Communication\Plugin\Stock\StockAddressStockPostUpdatePlugin;

class StockDependencyProvider extends SprykerStockDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\StockExtension\Dependency\Plugin\StockUpdateHandlerPluginInterface>
     */
    protected function getStockUpdateHandlerPlugins(Container $container): array // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        return [
            new AvailabilityStockUpdateHandlerPlugin(),
            new ProductBundleAvailabilityHandlerPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\StockExtension\Dependency\Plugin\StockCollectionExpanderPluginInterface>
     */
    protected function getStockCollectionExpanderPlugins(): array
    {
        return [
            new StockAddressStockCollectionExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\StockExtension\Dependency\Plugin\StockPostCreatePluginInterface>
     */
    protected function getStockPostCreatePlugins(): array
    {
        return [
            new StockAddressStockPostCreatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\StockExtension\Dependency\Plugin\StockPostUpdatePluginInterface>
     */
    protected function getStockPostUpdatePlugins(): array
    {
        return [
            new StockAddressStockPostUpdatePlugin(),
        ];
    }
}
