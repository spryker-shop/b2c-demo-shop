<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ExampleProductSalePage;

use Spryker\Yves\Kernel\AbstractFactory;

class ExampleProductSalePageFactory extends AbstractFactory
{
    /**
     * @return string[]
     */
    public function getExampleProductSalePageWidgetPlugins(): array
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_PLUGIN_PRODUCT_SALE_PAGE_WIDGETS);
    }

    /**
     * @return \Spryker\Client\UrlStorage\UrlStorageClientInterface
     */
    public function getPyzUrlStorageClient()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_CLIENT_URL_STORAGE);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getPyzStore()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_STORE);
    }

    /**
     * @return \Spryker\Client\Catalog\CatalogClientInterface
     */
    public function getPyzCatalogClient()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_CLIENT_CATALOG);
    }
}
