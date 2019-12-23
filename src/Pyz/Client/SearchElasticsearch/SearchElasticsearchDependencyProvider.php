<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\SearchElasticsearch;

use Spryker\Client\Catalog\Plugin\SearchElasticsearch\ElasticsearchCatalogSearchConfigBuilderPlugin;
use Spryker\Client\Kernel\Container;
use Spryker\Client\ProductSearchConfigStorage\Plugin\Config\ProductSearchConfigExpanderPlugin;
use Spryker\Client\SearchElasticsearch\SearchElasticsearchDependencyProvider as SprykerSearchElasticsearchDependencyProvider;

class SearchElasticsearchDependencyProvider extends SprykerSearchElasticsearchDependencyProvider
{
    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\SearchConfigBuilderPluginInterface[]
     */
    protected function getSearchConfigBuilderPlugins(Container $container): array
    {
        return [
            new ElasticsearchCatalogSearchConfigBuilderPlugin(),
        ];
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\SearchConfigExpanderPluginInterface[]
     */
    protected function getSearchConfigExpanderPlugins(Container $container): array
    {
        return [
            new ProductSearchConfigExpanderPlugin(),
        ];
    }
}
