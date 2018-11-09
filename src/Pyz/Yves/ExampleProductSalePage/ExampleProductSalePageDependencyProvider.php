<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ExampleProductSalePage;

use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ProductReviewWidget\Plugin\CatalogPage\ProductRatingFilterWidgetPlugin;
use SprykerShop\Yves\ProductWidget\Plugin\CatalogPage\ProductWidgetPlugin;

class ExampleProductSalePageDependencyProvider extends AbstractBundleDependencyProvider
{
    const CLIENT_SEARCH = 'CLIENT_SEARCH';
    const CLIENT_URL_STORAGE = 'CLIENT_URL_STORAGE';
    const STORE = 'STORE';
    const PLUGIN_PRODUCT_SALE_PAGE_WIDGETS = 'PLUGIN_PRODUCT_SALE_PAGE_WIDGETS';
    const CLIENT_CATALOG = 'CLIENT_CATALOG';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addSearchClient($container);
        $container = $this->addUrlStorageClient($container);
        $container = $this->addStore($container);
        $container = $this->addProductSalePageWidgetPlugins($container);
        $container = $this->addCatalogClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addSearchClient(Container $container)
    {
        $container[self::CLIENT_SEARCH] = function (Container $container) {
            return $container->getLocator()->search()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addUrlStorageClient(Container $container)
    {
        $container[self::CLIENT_URL_STORAGE] = function (Container $container) {
            return $container->getLocator()->urlStorage()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addStore($container)
    {
        $container[self::STORE] = function () {
            return Store::getInstance();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCatalogClient(Container $container)
    {
        $container[self::CLIENT_CATALOG] = function (Container $container) {
            return $container->getLocator()->catalog()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductSalePageWidgetPlugins($container)
    {
        $container[self::PLUGIN_PRODUCT_SALE_PAGE_WIDGETS] = function () {
            return $this->getProductSalePageWidgetPlugins();
        };

        return $container;
    }

    /**
     * @return string[]
     */
    protected function getProductSalePageWidgetPlugins(): array
    {
        return [
            ProductWidgetPlugin::class,
            ProductRatingFilterWidgetPlugin::class,
        ];
    }
}
