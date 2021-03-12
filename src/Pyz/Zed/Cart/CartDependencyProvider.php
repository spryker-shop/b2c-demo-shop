<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Cart;

use Pyz\Zed\ProductUrlCartConnector\Communication\Plugin\ProductUrlCartExpanderPlugin;
use Spryker\Zed\AvailabilityCartConnector\Communication\Plugin\CheckAvailabilityPlugin;
use Spryker\Zed\Cart\CartDependencyProvider as SprykerCartDependencyProvider;
use Spryker\Zed\Cart\Communication\Plugin\CleanUpItemsPreReloadPlugin;
use Spryker\Zed\Cart\Communication\Plugin\SkuGroupKeyPlugin;
use Spryker\Zed\ConfigurableBundle\Communication\Plugin\Cart\CartConfigurableBundlePreReloadPlugin;
use Spryker\Zed\ConfigurableBundleCart\Communication\Plugin\Cart\ConfiguredBundleGroupKeyItemExpanderPlugin;
use Spryker\Zed\ConfigurableBundleCart\Communication\Plugin\Cart\ConfiguredBundleQuantityCartTerminationPlugin;
use Spryker\Zed\ConfigurableBundleCart\Communication\Plugin\Cart\ConfiguredBundleQuantityPerSlotItemExpanderPlugin;
use Spryker\Zed\ConfigurableBundleCart\Communication\Plugin\Cart\ConfiguredBundleQuantityPerSlotPreReloadItemsPlugin;
use Spryker\Zed\ConfigurableBundleCart\Communication\Plugin\Cart\ConfiguredBundleQuantityPostSavePlugin;
use Spryker\Zed\ConfigurableBundleCart\Communication\Plugin\Cart\ConfiguredBundleTemplateSlotCombinationPreCheckPlugin;
use Spryker\Zed\Discount\Communication\Plugin\Cart\DiscountQuoteChangeObserverPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Cart\CartGroupPromotionItems;
use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardMetadataExpanderPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\PaymentCartConnector\Communication\Plugin\Cart\RemovePaymentCartPostSavePlugin;
use Spryker\Zed\PriceCartConnector\Communication\Plugin\CartItemPricePlugin;
use Spryker\Zed\PriceCartConnector\Communication\Plugin\CartItemPricePreCheckPlugin;
use Spryker\Zed\PriceCartConnector\Communication\Plugin\FilterItemsWithoutPricePlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Cart\BundleItemPriceQuoteChangeObserverPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Cart\CartBundleActivePreCheckPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Cart\CartBundleAvailabilityPreCheckPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Cart\CartBundleItemsPreReloadPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Cart\CartBundlePricesPreCheckPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Cart\CartItemWithBundleGroupKeyExpanderPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Cart\CartPostSaveUpdateBundlesPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Cart\ExpandBundleItemsPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Cart\ExpandBundleItemsWithImagesPlugin;
use Spryker\Zed\ProductCartConnector\Communication\Plugin\ProductCartPlugin;
use Spryker\Zed\ProductCartConnector\Communication\Plugin\ProductExistsCartPreCheckPlugin;
use Spryker\Zed\ProductCartConnector\Communication\Plugin\RemoveInactiveItemsPreReloadPlugin;
use Spryker\Zed\ProductDiscontinued\Communication\Plugin\Cart\ProductDiscontinuedCartPreCheckPlugin;
use Spryker\Zed\ProductImageCartConnector\Communication\Plugin\ProductImageCartPlugin;
use Spryker\Zed\ProductList\Communication\Plugin\CartExtension\ProductListRestrictedItemsPreCheckPlugin;
use Spryker\Zed\ProductList\Communication\Plugin\CartExtension\RemoveRestrictedItemsPreReloadPlugin;
use Spryker\Zed\ProductOptionCartConnector\Communication\Plugin\Cart\CartItemOptionPreCheckPlugin;
use Spryker\Zed\ProductOptionCartConnector\Communication\Plugin\CartItemGroupKeyOptionPlugin;
use Spryker\Zed\ProductOptionCartConnector\Communication\Plugin\CartItemProductOptionPlugin;
use Spryker\Zed\ProductOptionCartConnector\Communication\Plugin\ChangeProductOptionQuantityPlugin;
use Spryker\Zed\ProductOptionCartConnector\Communication\Plugin\ProductOptionValuePriceExistsCartPreCheckPlugin;
use Spryker\Zed\ProductQuantity\Communication\Plugin\Cart\ProductQuantityRestrictionCartPreCheckPlugin;
use Spryker\Zed\ProductQuantity\Communication\Plugin\CartExtension\ProductQuantityRestrictionCartRemovalPreCheckPlugin;
use Spryker\Zed\SalesOrderThreshold\Communication\Plugin\Cart\AddThresholdMessagesCartPostReloadItemsPlugin;
use Spryker\Zed\SalesQuantity\Communication\Plugin\Cart\IsQuantitySplittableItemExpanderPlugin;
use Spryker\Zed\ShipmentCartConnector\Communication\Plugin\Cart\CartShipmentExpanderPlugin;
use Spryker\Zed\ShipmentCartConnector\Communication\Plugin\Cart\CartShipmentPreCheckPlugin;

class CartDependencyProvider extends SprykerCartDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\CartExtension\Dependency\Plugin\ItemExpanderPluginInterface[]
     */
    protected function getExpanderPlugins(Container $container)
    {
        return [
            new ProductCartPlugin(),
            new IsQuantitySplittableItemExpanderPlugin(),
            new CartItemPricePlugin(),
            new CartItemProductOptionPlugin(),
            new ProductUrlCartExpanderPlugin(),
            new ExpandBundleItemsPlugin(),
            new ExpandBundleItemsWithImagesPlugin(),
            new SkuGroupKeyPlugin(),
            new CartItemGroupKeyOptionPlugin(),
            new CartItemWithBundleGroupKeyExpanderPlugin(),
            new ProductImageCartPlugin(),
            new CartGroupPromotionItems(),
            new CartShipmentExpanderPlugin(),
            new GiftCardMetadataExpanderPlugin(), #GiftCardFeature
            new ConfiguredBundleQuantityPerSlotItemExpanderPlugin(),
            new ConfiguredBundleGroupKeyItemExpanderPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\CartExtension\Dependency\Plugin\CartPreCheckPluginInterface[]
     */
    protected function getCartPreCheckPlugins(Container $container)
    {
        /** @var \Spryker\Zed\CartExtension\Dependency\Plugin\CartPreCheckPluginInterface[] $cartPreCheckPlugins */
        $cartPreCheckPlugins = [
            new ProductExistsCartPreCheckPlugin(),
            new CartItemPricePreCheckPlugin(),
            new CartBundlePricesPreCheckPlugin(),
            new CartItemOptionPreCheckPlugin(),
            new ProductOptionValuePriceExistsCartPreCheckPlugin(),
            new CartBundleAvailabilityPreCheckPlugin(),
            new CartBundleActivePreCheckPlugin(),
            new CartShipmentPreCheckPlugin(),
            new ProductQuantityRestrictionCartPreCheckPlugin(),
            new ProductDiscontinuedCartPreCheckPlugin(),
            new CheckAvailabilityPlugin(),
            new ConfiguredBundleTemplateSlotCombinationPreCheckPlugin(),
            new ProductListRestrictedItemsPreCheckPlugin(),
        ];

        return $cartPreCheckPlugins;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\CartExtension\Dependency\Plugin\CartOperationPostSavePluginInterface[]
     */
    protected function getPostSavePlugins(Container $container)
    {
        return [
            new ChangeProductOptionQuantityPlugin(),
            new CartPostSaveUpdateBundlesPlugin(),
            new RemovePaymentCartPostSavePlugin(),
            new ConfiguredBundleQuantityPostSavePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\CartExtension\Dependency\Plugin\PreReloadItemsPluginInterface[]
     */
    protected function getPreReloadPlugins(Container $container)
    {
        /** @var \Spryker\Zed\CartExtension\Dependency\Plugin\PreReloadItemsPluginInterface[] $preReloadPlugins */
        $preReloadPlugins = [
            new CartConfigurableBundlePreReloadPlugin(),
            new CartBundleItemsPreReloadPlugin(),
            new RemoveInactiveItemsPreReloadPlugin(),
            new CleanUpItemsPreReloadPlugin(),
            new FilterItemsWithoutPricePlugin(),
            new ConfiguredBundleQuantityPerSlotPreReloadItemsPlugin(),
            new RemoveRestrictedItemsPreReloadPlugin(),
        ];

        return $preReloadPlugins;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\CartExtension\Dependency\Plugin\PostReloadItemsPluginInterface[]
     */
    protected function getPostReloadItemsPlugins(Container $container): array
    {
        return [
            new AddThresholdMessagesCartPostReloadItemsPlugin(), #SalesOrderThresholdFeature
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\CartExtension\Dependency\Plugin\CartRemovalPreCheckPluginInterface[]
     */
    protected function getCartRemovalPreCheckPlugins(Container $container)
    {
        return [
            new ProductQuantityRestrictionCartRemovalPreCheckPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\CartExtension\Dependency\Plugin\QuoteChangeObserverPluginInterface[]
     */
    protected function getQuoteChangeObserverPlugins(Container $container): array
    {
        return [
            new DiscountQuoteChangeObserverPlugin(),
            new BundleItemPriceQuoteChangeObserverPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\CartExtension\Dependency\Plugin\CartTerminationPluginInterface[]
     */
    protected function getTerminationPlugins(Container $container)
    {
        return [
            new ConfiguredBundleQuantityCartTerminationPlugin(),
        ];
    }
}
