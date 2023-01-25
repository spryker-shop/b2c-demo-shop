<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\TabsWidget;

use SprykerShop\Yves\CatalogPage\Plugin\FullTextSearchProductsTabPlugin;
use SprykerShop\Yves\CmsSearchPage\Plugin\FullTextSearchCmsPageTabPlugin;
use SprykerShop\Yves\TabsWidget\TabsWidgetDependencyProvider as SprykerTabsWidgetDependencyProvider;

class TabsWidgetDependencyProvider extends SprykerTabsWidgetDependencyProvider
{
    /**
     * @return array<\SprykerShop\Yves\TabsWidgetExtension\Plugin\FullTextSearchTabPluginInterface>
     */
    protected function createFullTextSearchPlugins(): array
    {
        return [
            new FullTextSearchProductsTabPlugin(),
            new FullTextSearchCmsPageTabPlugin(),
        ];
    }
}
