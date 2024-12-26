<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\WishlistsRestApi;

use Spryker\Zed\ProductConfigurationWishlistsRestApi\Communication\Plugin\WishlistsRestApi\ProductConfigurationRestWishlistItemsAttributesDeleteStrategyPlugin;
use Spryker\Zed\ProductConfigurationWishlistsRestApi\Communication\Plugin\WishlistsRestApi\ProductConfigurationRestWishlistItemsAttributesUpdateStrategyPlugin;
use Spryker\Zed\WishlistsRestApi\WishlistsRestApiDependencyProvider as SprykerWishlistsRestApiDependencyProvider;

class WishlistsRestApiDependencyProvider extends SprykerWishlistsRestApiDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\WishlistsRestApiExtension\Dependency\Plugin\RestWishlistItemsAttributesDeleteStrategyPluginInterface>
     */
    protected function getRestWishlistItemsAttributesDeleteStrategyPlugins(): array
    {
        return [
            new ProductConfigurationRestWishlistItemsAttributesDeleteStrategyPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\WishlistsRestApiExtension\Dependency\Plugin\RestWishlistItemsAttributesUpdateStrategyPluginInterface>
     */
    protected function getRestWishlistItemsAttributesUpdateStrategyPlugins(): array
    {
        return [
            new ProductConfigurationRestWishlistItemsAttributesUpdateStrategyPlugin(),
        ];
    }
}
