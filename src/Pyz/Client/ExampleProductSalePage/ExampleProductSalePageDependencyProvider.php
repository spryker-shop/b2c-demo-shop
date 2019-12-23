<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ExampleProductSalePage;

use Pyz\Client\ExampleProductSalePage\Plugin\Elasticsearch\Query\SaleSearchQueryPlugin;
use Spryker\Client\Catalog\Plugin\Elasticsearch\ResultFormatter\RawCatalogSearchResultFormatterPlugin;
use Spryker\Client\CatalogPriceProductConnector\Plugin\CurrencyAwareCatalogSearchResultFormatterPlugin;
use Spryker\Client\CatalogPriceProductConnector\Plugin\ProductPriceQueryExpanderPlugin;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Search\SearchClient;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\FacetQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\LocalizedQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\PaginatedQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\SortedQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\StoreQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\FacetResultFormatterPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\PaginatedResultFormatterPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\SortedResultFormatterPlugin;
use Spryker\Shared\Kernel\Store;

class ExampleProductSalePageDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT_SEARCH = 'CLIENT_SEARCH';
    public const CLIENT_PRODUCT_LABEL_STORAGE = 'CLIENT_PRODUCT_LABEL';
    public const SALE_SEARCH_QUERY_PLUGIN = 'SALE_SEARCH_QUERY_PLUGIN';
    public const SALE_SEARCH_QUERY_EXPANDER_PLUGINS = 'SALE_SEARCH_QUERY_EXPANDER_PLUGINS';
    public const SALE_SEARCH_RESULT_FORMATTER_PLUGINS = 'SALE_SEARCH_RESULT_FORMATTER_PLUGINS';
    public const STORE = 'STORE';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container)
    {
        $container = $this->addSearchClient($container);
        $container = $this->addProductLabelClient($container);
        $container = $this->addSaleSearchQueryPlugin($container);
        $container = $this->addSaleSearchQueryExpanderPlugins($container);
        $container = $this->addSaleSearchResultFormatterPlugins($container);
        $container = $this->addStore($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSearchClient(Container $container)
    {
        $container[self::CLIENT_SEARCH] = function () {
            return new SearchClient();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addProductLabelClient(Container $container)
    {
        $container[self::CLIENT_PRODUCT_LABEL_STORAGE] = function (Container $container) {
            return $container->getLocator()->productLabelStorage()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSaleSearchQueryPlugin(Container $container)
    {
        $container[self::SALE_SEARCH_QUERY_PLUGIN] = function () {
            return new SaleSearchQueryPlugin();
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSaleSearchQueryExpanderPlugins(Container $container)
    {
        $container[self::SALE_SEARCH_QUERY_EXPANDER_PLUGINS] = function () {
            return [
                new StoreQueryExpanderPlugin(),
                new LocalizedQueryExpanderPlugin(),
                new ProductPriceQueryExpanderPlugin(),
                new SortedQueryExpanderPlugin(),
                new PaginatedQueryExpanderPlugin(),

                /**
                 * FacetQueryExpanderPlugin needs to be after other query expanders which filters down the results.
                 */
                new FacetQueryExpanderPlugin(),
            ];
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSaleSearchResultFormatterPlugins(Container $container)
    {
        $container[self::SALE_SEARCH_RESULT_FORMATTER_PLUGINS] = function () {
            return [
                new FacetResultFormatterPlugin(),
                new SortedResultFormatterPlugin(),
                new PaginatedResultFormatterPlugin(),
                new CurrencyAwareCatalogSearchResultFormatterPlugin(
                    new RawCatalogSearchResultFormatterPlugin()
                ),
            ];
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addStore(Container $container)
    {
        $container[self::STORE] = function () {
            return Store::getInstance();
        };

        return $container;
    }
}
