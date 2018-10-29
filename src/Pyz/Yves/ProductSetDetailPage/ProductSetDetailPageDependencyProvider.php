<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductSetDetailPage;

use Pyz\Yves\ProductSetWidget\Plugin\ProductSetDetailPage\ProductSetWidgetPlugin;
use SprykerShop\Yves\ProductLabelWidget\Plugin\ProductDetailPage\ProductAbstractLabelWidgetPlugin;
use SprykerShop\Yves\ProductSetDetailPage\ProductSetDetailPageDependencyProvider as SprykerShopProductSetDetailPageDependencyProvider;

class ProductSetDetailPageDependencyProvider extends SprykerShopProductSetDetailPageDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getProductSetDetailPageWidgetPlugins(): array
    {
        return [
            ProductSetWidgetPlugin::class,
            ProductAbstractLabelWidgetPlugin::class,
        ];
    }
}
