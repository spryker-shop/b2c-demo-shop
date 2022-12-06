<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Wishlist;

use Spryker\Zed\ProductConfigurationWishlist\Communication\Plugin\Wishlist\ProductConfigurationItemExpanderPlugin;
use Spryker\Zed\ProductConfigurationWishlist\Communication\Plugin\Wishlist\ProductConfigurationWishlistAddItemPreCheckPlugin;
use Spryker\Zed\ProductConfigurationWishlist\Communication\Plugin\Wishlist\ProductConfigurationWishlistItemExpanderPlugin;
use Spryker\Zed\ProductConfigurationWishlist\Communication\Plugin\Wishlist\ProductConfigurationWishlistPreAddItemPlugin;
use Spryker\Zed\ProductConfigurationWishlist\Communication\Plugin\Wishlist\ProductConfigurationWishlistPreUpdateItemPlugin;
use Spryker\Zed\ProductConfigurationWishlist\Communication\Plugin\Wishlist\ProductConfigurationWishlistReloadItemsPlugin;
use Spryker\Zed\ProductConfigurationWishlist\Communication\Plugin\Wishlist\ProductConfigurationWishlistUpdateItemPreCheckPlugin;
use Spryker\Zed\ProductDiscontinued\Communication\Plugin\Wishlist\ProductDiscontinuedAddItemPreCheckPlugin;
use Spryker\Zed\Wishlist\Communication\Plugin\Wishlist\WishlistItemAddItemPreCheckPlugin;
use Spryker\Zed\Wishlist\WishlistDependencyProvider as SprykerWishlistDependencyProvider;

class WishlistDependencyProvider extends SprykerWishlistDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\Wishlist\Dependency\Plugin\ItemExpanderPluginInterface>
     */
    protected function getItemExpanderPlugins(): array
    {
        return [
            new ProductConfigurationItemExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\WishlistExtension\Dependency\Plugin\AddItemPreCheckPluginInterface>
     */
    protected function getAddItemPreCheckPlugins(): array
    {
        return [
            new ProductConfigurationWishlistAddItemPreCheckPlugin(),
            new ProductDiscontinuedAddItemPreCheckPlugin(),
            new WishlistItemAddItemPreCheckPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\WishlistExtension\Dependency\Plugin\WishlistReloadItemsPluginInterface>
     */
    protected function getWishlistReloadItemsPlugins(): array
    {
        return [
            new ProductConfigurationWishlistReloadItemsPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\WishlistExtension\Dependency\Plugin\WishlistPreAddItemPluginInterface>
     */
    protected function getWishlistPreAddItemPlugins(): array
    {
        return [
            new ProductConfigurationWishlistPreAddItemPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\WishlistExtension\Dependency\Plugin\WishlistItemExpanderPluginInterface>
     */
    protected function getWishlistItemExpanderPlugins(): array
    {
        return [
            new ProductConfigurationWishlistItemExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\WishlistExtension\Dependency\Plugin\WishlistPreUpdateItemPluginInterface>
     */
    protected function getWishlistPreUpdateItemPlugins(): array
    {
        return [
            new ProductConfigurationWishlistPreUpdateItemPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\WishlistExtension\Dependency\Plugin\UpdateItemPreCheckPluginInterface>
     */
    protected function getUpdateItemPreCheckPlugins(): array
    {
        return [
            new ProductConfigurationWishlistUpdateItemPreCheckPlugin(),
        ];
    }
}
