<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductNew;

use Spryker\Client\Catalog\Plugin\Elasticsearch\ResultFormatter\RawCatalogSearchResultFormatterPlugin;
use Spryker\Client\CatalogPriceProductConnector\Plugin\CurrencyAwareCatalogSearchResultFormatterPlugin;
use Spryker\Client\CatalogPriceProductConnector\Plugin\ProductPriceQueryExpanderPlugin;
use Spryker\Client\ProductNew\ProductNewDependencyProvider as SprykerProductNewDependencyProvider;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\FacetQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\LocalizedQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\PaginatedQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\SortedQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\StoreQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\FacetResultFormatterPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\PaginatedResultFormatterPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\SortedResultFormatterPlugin;

class ProductNewDependencyProvider extends SprykerProductNewDependencyProvider
{
    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>|array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function getNewProductsQueryExpanderPlugins(): array
    {
        return [
            new StoreQueryExpanderPlugin(),
            new LocalizedQueryExpanderPlugin(),
            new ProductPriceQueryExpanderPlugin(),
            new SortedQueryExpanderPlugin(),
            new PaginatedQueryExpanderPlugin(),

            /*
             * FacetQueryExpanderPlugin needs to be after other query expanders which filters down the results.
             */
            new FacetQueryExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>|array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    protected function getNewProductsResultFormatterPlugins(): array
    {
        return [
            new FacetResultFormatterPlugin(),
            new SortedResultFormatterPlugin(),
            new PaginatedResultFormatterPlugin(),
            new CurrencyAwareCatalogSearchResultFormatterPlugin(
                new RawCatalogSearchResultFormatterPlugin(),
            ),
        ];
    }
}
