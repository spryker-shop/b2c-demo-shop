<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductRelationWidget;

use SprykerShop\Yves\ProductRelationWidget\ProductRelationWidgetDependencyProvider as SprykerShopProductRelationWidgetDependencyProvider;
use SprykerShop\Yves\ProductWidget\Plugin\ProductRelationWidget\ProductWidgetPlugin;

class ProductRelationWidgetDependencyProvider extends SprykerShopProductRelationWidgetDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getProductDetailPageSimilarProductsWidgetPlugins(): array
    {
        return [
            ProductWidgetPlugin::class,
        ];
    }

    /**
     * @return string[]
     */
    protected function getCartPageUpSellingProductsWidgetPlugins(): array
    {
        return [
            ProductWidgetPlugin::class,
        ];
    }
}
