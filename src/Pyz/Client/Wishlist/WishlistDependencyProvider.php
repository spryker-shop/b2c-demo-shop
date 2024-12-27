<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\Wishlist;

use Spryker\Client\ProductConfigurationWishlist\Plugin\Wishlist\ProductConfigurationWishlistCollectionToRemoveExpanderPlugin;
use Spryker\Client\ProductConfigurationWishlist\Plugin\Wishlist\ProductConfigurationWishlistPostMoveToCartCollectionExpanderPlugin;
use Spryker\Client\Wishlist\WishlistDependencyProvider as SprykerWishlistDependencyProvider;

class WishlistDependencyProvider extends SprykerWishlistDependencyProvider
{
    /**
     * @return array<\Spryker\Client\WishlistExtension\Dependency\Plugin\WishlistPostMoveToCartCollectionExpanderPluginInterface>
     */
    protected function getWishlistPostMoveToCartCollectionExpanderPlugins(): array
    {
        return [
            new ProductConfigurationWishlistPostMoveToCartCollectionExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\WishlistExtension\Dependency\Plugin\WishlistCollectionToRemoveExpanderPluginInterface>
     */
    protected function getWishlistCollectionToRemoveExpanderPlugins(): array
    {
        return [
            new ProductConfigurationWishlistCollectionToRemoveExpanderPlugin(),
        ];
    }
}
