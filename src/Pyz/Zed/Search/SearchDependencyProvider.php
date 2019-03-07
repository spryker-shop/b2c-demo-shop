<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Search;

use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Search\CategoryNodeDataPageMapBuilder;
use Spryker\Zed\CmsPageSearch\Communication\Plugin\Search\CmsDataPageMapBuilder;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Search\ProductConcretePageMapPlugin;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Search\ProductPageMapPlugin;
use Spryker\Zed\ProductSetPageSearch\Communication\Plugin\Search\ProductSetPageMapPlugin;
use Spryker\Zed\Search\SearchDependencyProvider as SprykerSearchDependencyProvider;

class SearchDependencyProvider extends SprykerSearchDependencyProvider
{
    /**
     * @return \Spryker\Zed\Search\Dependency\Plugin\PageMapInterface[]
     */
    protected function getSearchPageMapPlugins()
    {
        return [
            new ProductPageMapPlugin(),
            new ProductConcretePageMapPlugin(),
            new ProductSetPageMapPlugin(),
            new CmsDataPageMapBuilder(),
            new CategoryNodeDataPageMapBuilder(),
        ];
    }
}
