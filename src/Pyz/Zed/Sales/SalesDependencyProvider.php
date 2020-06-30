<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Sales;

use Spryker\Zed\Customer\Communication\Plugin\Sales\CustomerOrderHydratePlugin;
use Spryker\Zed\Discount\Communication\Plugin\Sales\DiscountOrderHydratePlugin;
use Spryker\Zed\Oms\Communication\Plugin\Sales\IsCancellableOrderExpanderPlugin;
use Spryker\Zed\Oms\Communication\Plugin\Sales\IsCancellableSearchOrderExpanderPlugin;
use Spryker\Zed\Payment\Communication\Plugin\Sales\PaymentOrderHydratePlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Sales\ProductBundleIdHydratorPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Sales\ProductBundleOptionOrderExpanderPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Sales\ProductBundleOrderHydratePlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Sales\UniqueOrderBundleItemsExpanderPlugin;
use Spryker\Zed\ProductOption\Communication\Plugin\Sales\ProductOptionGroupIdHydratorPlugin;
use Spryker\Zed\ProductOption\Communication\Plugin\Sales\ProductOptionOrderHydratePlugin;
use Spryker\Zed\Sales\SalesDependencyProvider as SprykerSalesDependencyProvider;
use Spryker\Zed\SalesConfigurableBundle\Communication\Plugin\Sales\ConfiguredBundleItemPreTransformerPlugin;
use Spryker\Zed\SalesConfigurableBundle\Communication\Plugin\Sales\ConfiguredBundleOrderExpanderPlugin;
use Spryker\Zed\SalesConfigurableBundle\Communication\Plugin\Sales\ConfiguredBundlesOrderPostSavePlugin;
use Spryker\Zed\SalesProductConnector\Communication\Plugin\Sales\ItemMetadataHydratorPlugin;
use Spryker\Zed\SalesProductConnector\Communication\Plugin\Sales\ProductIdHydratorPlugin;
use Spryker\Zed\SalesQuantity\Communication\Plugin\SalesExtension\IsQuantitySplittableOrderItemExpanderPreSavePlugin;
use Spryker\Zed\SalesQuantity\Communication\Plugin\SalesExtension\NonSplittableItemTransformerStrategyPlugin;
use Spryker\Zed\SalesReclamationGui\Communication\Plugin\Sales\ReclamationSalesTablePlugin;
use Spryker\Zed\Shipment\Communication\Plugin\ShipmentOrderHydratePlugin;

class SalesDependencyProvider extends SprykerSalesDependencyProvider
{
    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\OrderExpanderPluginInterface[]
     */
    protected function getOrderHydrationPlugins()
    {
        return [
            new ProductIdHydratorPlugin(),
            new ProductOptionOrderHydratePlugin(),
            new ProductBundleOrderHydratePlugin(),
            new DiscountOrderHydratePlugin(),
            new ShipmentOrderHydratePlugin(),
            new PaymentOrderHydratePlugin(),
            new CustomerOrderHydratePlugin(),
            new ItemMetadataHydratorPlugin(),
            new ProductBundleIdHydratorPlugin(),
            new ProductOptionGroupIdHydratorPlugin(),
            new ProductBundleOptionOrderExpanderPlugin(),
            new ConfiguredBundleOrderExpanderPlugin(),
            new IsCancellableOrderExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\OrderItemExpanderPreSavePluginInterface[]
     */
    protected function getOrderItemExpanderPreSavePlugins()
    {
        return [
            new IsQuantitySplittableOrderItemExpanderPreSavePlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\ItemTransformerStrategyPluginInterface[]
     */
    public function getItemTransformerStrategyPlugins(): array
    {
        return [
            new NonSplittableItemTransformerStrategyPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\SalesTablePluginInterface[]
     */
    protected function getSalesTablePlugins()
    {
        return [
            new ReclamationSalesTablePlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\UniqueOrderItemsExpanderPluginInterface[]
     */
    protected function getUniqueOrderItemsExpanderPlugins(): array
    {
        return [
            new UniqueOrderBundleItemsExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\OrderPostSavePluginInterface[]
     */
    protected function getOrderPostSavePlugins()
    {
        return [
            new ConfiguredBundlesOrderPostSavePlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\ItemPreTransformerPluginInterface[]
     */
    protected function getItemPreTransformerPlugins(): array
    {
        return [
            new ConfiguredBundleItemPreTransformerPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\SearchOrderExpanderPluginInterface[]
     */
    protected function getSearchOrderExpanderPlugins(): array
    {
        return [
            new IsCancellableSearchOrderExpanderPlugin(),
        ];
    }
}
