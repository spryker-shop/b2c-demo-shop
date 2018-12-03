<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ShopRouter;

use SprykerShop\Yves\CatalogPage\Plugin\CatalogPageResourceCreatorPlugin;
use SprykerShop\Yves\CmsPage\Plugin\PageResourceCreatorPlugin;
use SprykerShop\Yves\ProductDetailPage\Plugin\ProductDetailPageResourceCreatorPlugin;
use SprykerShop\Yves\ProductSetDetailPage\Plugin\ProductSetDetailPageResourceCreatorPlugin;
use SprykerShop\Yves\RedirectPage\Plugin\RedirectResourceCreatorPlugin;
use SprykerShop\Yves\ShopRouter\ShopRouterDependencyProvider as SprykerShopRouterDependencyProvider;

class ShopRouterDependencyProvider extends SprykerShopRouterDependencyProvider
{
    /**
     * @return \SprykerShop\Yves\ShopRouterExtension\Dependency\Plugin\ResourceCreatorPluginInterface[]
     */
    protected function getResourceCreatorPlugins()
    {
        return [
            new PageResourceCreatorPlugin(),
            new CatalogPageResourceCreatorPlugin(),
            new ProductDetailPageResourceCreatorPlugin(),
            new ProductSetDetailPageResourceCreatorPlugin(),
            new RedirectResourceCreatorPlugin(),
        ];
    }
}
