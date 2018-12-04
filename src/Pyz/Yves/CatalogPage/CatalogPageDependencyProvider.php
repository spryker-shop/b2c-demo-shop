<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CatalogPage;

use SprykerShop\Yves\CatalogPage\CatalogPageDependencyProvider as SprykerCatalogPageDependencyProvider;
use SprykerShop\Yves\CmsBlockWidget\Plugin\CatalogPage\CatalogCmsBlockWidgetPlugin;

class CatalogPageDependencyProvider extends SprykerCatalogPageDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getCatalogPageWidgetPlugins(): array
    {
        return [
            CatalogCmsBlockWidgetPlugin::class,
        ];
    }
}
