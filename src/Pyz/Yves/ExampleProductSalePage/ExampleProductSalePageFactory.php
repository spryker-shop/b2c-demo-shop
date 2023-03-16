<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ExampleProductSalePage;

use Spryker\Client\Catalog\CatalogClientInterface;
use Spryker\Client\Locale\LocaleClientInterface;
use Spryker\Client\UrlStorage\UrlStorageClientInterface;
use Spryker\Service\UtilNumber\UtilNumberServiceInterface;
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

    /**
     * @return \Spryker\Client\Locale\LocaleClientInterface
     */
    public function getPyzLocaleClient(): LocaleClientInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_CLIENT_LOCALE);
    }

    /**
     * @return \Spryker\Service\UtilNumber\UtilNumberServiceInterface
     */
    public function getUtilNumberService(): UtilNumberServiceInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_SERVICE_UTIL_NUMBER);
    }
}
