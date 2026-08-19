<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\ExampleProductSalePage;

use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Client\Catalog\CatalogClientInterface;
use Spryker\Client\Locale\LocaleClientInterface;
use Spryker\Client\UrlStorage\UrlStorageClientInterface;
use Spryker\Service\UtilNumber\UtilNumberServiceInterface;
use Spryker\Yves\Kernel\AbstractFactory;

class ExampleProductSalePageFactory extends AbstractFactory
{
    /**
     * @return array<string>
     */
    public function getExampleProductSalePageWidgetPlugins(): array
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PLUGIN_PRODUCT_SALE_PAGE_WIDGETS);
    }

    public function getUrlStorageClient(): UrlStorageClientInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::CLIENT_URL_STORAGE);
    }

    public function getStore(): StoreTransfer
    {
        $storeClient = $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::CLIENT_STORE);

        return $storeClient->getCurrentStore();
    }

    public function getCatalogClient(): CatalogClientInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::CLIENT_CATALOG);
    }

    public function getLocaleClient(): LocaleClientInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::CLIENT_LOCALE);
    }

    public function getUtilNumberService(): UtilNumberServiceInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::SERVICE_UTIL_NUMBER);
    }
}
