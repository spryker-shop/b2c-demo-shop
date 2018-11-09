<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CatalogPage;

use SprykerShop\Yves\CatalogPage\CatalogPageDependencyProvider as SprykerCatalogPageDependencyProvider;
use SprykerShop\Yves\CmsBlockWidget\Plugin\CatalogPage\CatalogCmsBlockWidgetPlugin;
use SprykerShop\Yves\ProductReviewWidget\Plugin\CatalogPage\ProductRatingFilterWidgetPlugin;
use SprykerShop\Yves\ProductWidget\Plugin\CatalogPage\ProductWidgetPlugin;

class CatalogPageDependencyProvider extends SprykerCatalogPageDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getCatalogPageWidgetPlugins(): array
    {
        return [
            ProductWidgetPlugin::class,
            CatalogCmsBlockWidgetPlugin::class,
            ProductRatingFilterWidgetPlugin::class,
        ];
    }
}
