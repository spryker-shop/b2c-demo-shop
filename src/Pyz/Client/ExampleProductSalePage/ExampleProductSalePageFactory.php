<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ExampleProductSalePage;

use Spryker\Client\Kernel\AbstractFactory;

/**
 * @method \Pyz\Client\ExampleProductSalePage\ExampleProductSalePageConfig getConfig()
 */
class ExampleProductSalePageFactory extends AbstractFactory
{
    /**
     * @param array $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function getPyzSaleSearchQueryPlugin(array $requestParameters = [])
    {
        $saleQueryPlugin = $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_SALE_SEARCH_QUERY_PLUGIN);

        return $this->getPyzSearchClient()->expandQuery(
            $saleQueryPlugin,
            $this->getSaleSearchQueryExpanderPlugins(),
            $requestParameters
        );
    }

    /**
     * @return \Spryker\Client\ProductLabelStorage\ProductLabelStorageClientInterface
     */
    public function getPyzProductLabelStorageClient()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_CLIENT_PRODUCT_LABEL_STORAGE);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getPyzStore()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_STORE);
    }

    /**
     * @return \Spryker\Client\Search\SearchClientInterface
     */
    public function getPyzSearchClient()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_CLIENT_SEARCH);
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface[]
     */
    protected function getSaleSearchQueryExpanderPlugins()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_SALE_SEARCH_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface[]
     */
    public function getSaleSearchResultFormatterPlugins()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_SALE_SEARCH_RESULT_FORMATTER_PLUGINS);
    }
}
