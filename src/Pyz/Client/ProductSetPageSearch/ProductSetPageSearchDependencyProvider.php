<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductSetPageSearch;

use Spryker\Client\ProductSetPageSearch\Plugin\Elasticsearch\ResultFormatter\ProductSetPageSearchListResultFormatterPlugin;
use Spryker\Client\ProductSetPageSearch\ProductSetPageSearchDependencyProvider as SprykerProductSetPageSearchDependencyProvider;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\LocalizedQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\StoreQueryExpanderPlugin;

class ProductSetPageSearchDependencyProvider extends SprykerProductSetPageSearchDependencyProvider
{
    /**
     * @return array
     */
    protected function getProductSetListResultFormatterPlugins(): array
    {
        return [
            new ProductSetPageSearchListResultFormatterPlugin(),
        ];
    }

    /**
     * @return array
     */
    protected function getProductSetListQueryExpanderPlugins(): array
    {
        return [
            new LocalizedQueryExpanderPlugin(),
            new StoreQueryExpanderPlugin(),
        ];
    }
}
