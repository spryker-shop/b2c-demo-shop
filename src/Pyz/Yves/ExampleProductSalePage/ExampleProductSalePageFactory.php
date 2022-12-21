<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ExampleProductSalePage;

use Spryker\Client\Catalog\CatalogClientInterface;
use Spryker\Client\UrlStorage\UrlStorageClientInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\AbstractFactory;

class ExampleProductSalePageFactory extends AbstractFactory
{
    /**
     * @return array<string>
     */
    public function getExampleProductSalePageWidgetPlugins(): array
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_PLUGIN_PRODUCT_SALE_PAGE_WIDGETS);
    }

    /**
     * @return \Spryker\Client\UrlStorage\UrlStorageClientInterface
     */
    public function getPyzUrlStorageClient(): UrlStorageClientInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_CLIENT_URL_STORAGE);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getPyzStore(): Store
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_STORE);
    }

    /**
     * @return \Spryker\Client\Catalog\CatalogClientInterface
     */
    public function getPyzCatalogClient(): CatalogClientInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_CLIENT_CATALOG);
    }
}
