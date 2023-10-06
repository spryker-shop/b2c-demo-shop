<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductGroupWidget;

use SprykerShop\Yves\CartPage\Plugin\ProductGroupWidget\AddToCartUrlProductViewExpanderPlugin;
use SprykerShop\Yves\ProductGroupWidget\ProductGroupWidgetDependencyProvider as SprykerShopProductGroupWidgetDependencyProvider;
use SprykerShop\Yves\ProductLabelWidget\Plugin\ProductGroupWidget\ProductLabelProductViewExpanderPlugin;
use SprykerShop\Yves\ProductReviewWidget\Plugin\ProductGroupWidget\ProductReviewSummaryProductViewBulkExpanderPlugin;

class ProductGroupWidgetDependencyProvider extends SprykerShopProductGroupWidgetDependencyProvider
{
    /**
     * @return array<\SprykerShop\Yves\ProductGroupWidgetExtension\Dependency\Plugin\ProductViewExpanderPluginInterface>
     */
    protected function getProductViewExpanderPlugins(): array
    {
        return [
            new AddToCartUrlProductViewExpanderPlugin(),
            new ProductLabelProductViewExpanderPlugin(),
        ];
    }

    /**
     * @return array<\SprykerShop\Yves\ProductGroupWidgetExtension\Dependency\Plugin\ProductViewBulkExpanderPluginInterface>
     */
    protected function getProductViewBulkExpanderPlugins(): array
    {
        return [
            new ProductReviewSummaryProductViewBulkExpanderPlugin(),
        ];
    }
}
