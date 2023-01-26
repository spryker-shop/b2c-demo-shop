<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\Cart;

use Spryker\Client\Cart\CartDependencyProvider as SprykerCartDependencyProvider;
use Spryker\Client\Cart\Dependency\Plugin\ItemCountPluginInterface;
use Spryker\Client\Cart\Plugin\ProductSeparateCartChangeExpanderPlugin;
use Spryker\Client\CartExtension\Dependency\Plugin\QuoteItemFinderPluginInterface;
use Spryker\Client\DiscountPromotion\Plugin\AddDiscountPromotionCartRequestExpandPlugin;
use Spryker\Client\PersistentCart\Plugin\DatabaseQuoteStorageStrategy;
use Spryker\Client\ProductBundle\Plugin\Cart\BundleProductQuoteItemFinderPlugin;
use Spryker\Client\ProductBundle\Plugin\Cart\ProductBundleItemCountQuantityPlugin;
use Spryker\Client\ProductBundle\Plugin\Cart\RemoveBundleChangeRequestExpanderPlugin;
use Spryker\Client\ProductConfigurationCart\Plugin\Cart\ProductConfigurationCartChangeRequestExpanderPlugin;

class CartDependencyProvider extends SprykerCartDependencyProvider
{
    /**
     * @return \Spryker\Client\Cart\Dependency\Plugin\ItemCountPluginInterface
     */
    protected function getItemCountPlugin(): ItemCountPluginInterface
    {
        return new ProductBundleItemCountQuantityPlugin();
    }

    /**
     * @return array<\Spryker\Client\CartExtension\Dependency\Plugin\QuoteStorageStrategyPluginInterface>
     */
    protected function getQuoteStorageStrategyPlugins(): array
    {
        $quoteStorageStrategyPlugins = parent::getQuoteStorageStrategyPlugins();
        $quoteStorageStrategyPlugins[] = new DatabaseQuoteStorageStrategy(); #PersistentCartFeature

        return $quoteStorageStrategyPlugins;
    }

    /**
     * @return \Spryker\Client\CartExtension\Dependency\Plugin\QuoteItemFinderPluginInterface
     */
    protected function getQuoteItemFinderPlugin(): QuoteItemFinderPluginInterface
    {
        return new BundleProductQuoteItemFinderPlugin();
    }

    /**
     * @return array<\Spryker\Client\CartExtension\Dependency\Plugin\CartChangeRequestExpanderPluginInterface>
     */
    protected function getAddItemsRequestExpanderPlugins(): array
    {
        return [
            new AddDiscountPromotionCartRequestExpandPlugin(),
            new ProductSeparateCartChangeExpanderPlugin(),
            new ProductConfigurationCartChangeRequestExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\CartExtension\Dependency\Plugin\CartChangeRequestExpanderPluginInterface>
     */
    protected function getRemoveItemsRequestExpanderPlugins(): array
    {
        return [
            new RemoveBundleChangeRequestExpanderPlugin(),
        ];
    }
}
