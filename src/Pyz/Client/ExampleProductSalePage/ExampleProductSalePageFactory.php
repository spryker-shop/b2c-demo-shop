<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ExampleProductSalePage;

use Spryker\Client\Kernel\AbstractFactory;

class ExampleProductSalePageFactory extends AbstractFactory
{
    /**
     * @param array $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function getSaleSearchQueryPlugin(array $requestParameters = [])
    {
        $saleQueryPlugin = $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::SALE_SEARCH_QUERY_PLUGIN);

        return $this->getSearchClient()->expandQuery(
            $saleQueryPlugin,
            $this->getSaleSearchQueryExpanderPlugins(),
            $requestParameters
        );
    }

    /**
     * @return \Spryker\Client\ProductLabelStorage\ProductLabelStorageClientInterface
     */
    public function getProductLabelStorageClient()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::CLIENT_PRODUCT_LABEL_STORAGE);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::STORE);
    }

    /**
     * @return \Pyz\Client\ExampleProductSalePage\ExampleProductSalePageConfig
     */
    public function getConfig()
    {
        /** @var \Pyz\Client\ExampleProductSalePage\ExampleProductSalePageConfig $config */
        $config = parent::getConfig();

        return $config;
    }

    /**
     * @return \Spryker\Client\Search\SearchClientInterface
     */
    public function getSearchClient()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::CLIENT_SEARCH);
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface[]
     */
    protected function getSaleSearchQueryExpanderPlugins()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::SALE_SEARCH_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface[]
     */
    public function getSaleSearchResultFormatterPlugins()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::SALE_SEARCH_RESULT_FORMATTER_PLUGINS);
    }
}
