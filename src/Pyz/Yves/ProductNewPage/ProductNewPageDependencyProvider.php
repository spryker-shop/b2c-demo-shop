<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductNewPage;

use SprykerShop\Yves\ProductNewPage\ProductNewPageDependencyProvider as SprykerShopProductNewPageDependencyProvider;
use SprykerShop\Yves\ProductReviewWidget\Plugin\CatalogPage\ProductRatingFilterWidgetPlugin;
use SprykerShop\Yves\ProductWidget\Plugin\CatalogPage\ProductWidgetPlugin;

class ProductNewPageDependencyProvider extends SprykerShopProductNewPageDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getProductNewPageWidgetPlugins(): array
    {
        return [
            ProductWidgetPlugin::class,
            ProductRatingFilterWidgetPlugin::class,
        ];
    }
}
