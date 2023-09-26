<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ExampleProductSalePage;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class ExampleProductSalePageDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_SEARCH = 'CLIENT_SEARCH';

    /**
     * @var string
     */
    public const CLIENT_URL_STORAGE = 'CLIENT_URL_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_STORE = 'CLIENT_STORE';

    /**
     * @var string
     */
    public const PLUGIN_PRODUCT_SALE_PAGE_WIDGETS = 'PLUGIN_PRODUCT_SALE_PAGE_WIDGETS';

    /**
     * @var string
     */
    public const CLIENT_CATALOG = 'CLIENT_CATALOG';

    /**
     * @var string
     */
    public const CLIENT_LOCALE = 'CLIENT_LOCALE';

    /**
     * @var string
     */
    public const SERVICE_UTIL_NUMBER = 'SERVICE_UTIL_NUMBER';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addSearchClient($container);
        $container = $this->addUrlStorageClient($container);
        $container = $this->addClientStore($container);
        $container = $this->addProductSalePageWidgetPlugins($container);
        $container = $this->addCatalogClient($container);
        $container = $this->addLocaleClient($container);
        $container = $this->addUtilNumberService($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addSearchClient(Container $container): Container
    {
        $container->set(static::CLIENT_SEARCH, function (Container $container) {
            return $container->getLocator()->search()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addUrlStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_URL_STORAGE, function (Container $container) {
            return $container->getLocator()->urlStorage()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addClientStore($container): Container
    {
        $container->set(static::CLIENT_STORE, function (Container $container) {
            return $container->getLocator()->store()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCatalogClient(Container $container): Container
    {
        $container->set(static::CLIENT_CATALOG, function (Container $container) {
            return $container->getLocator()->catalog()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductSalePageWidgetPlugins($container): Container
    {
        $container->set(static::PLUGIN_PRODUCT_SALE_PAGE_WIDGETS, function () {
            return $this->getProductSalePageWidgetPlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addLocaleClient(Container $container): Container
    {
        $container->set(static::CLIENT_LOCALE, function (Container $container) {
            return $container->getLocator()->locale()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addUtilNumberService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_NUMBER, function (Container $container) {
            return $container->getLocator()->utilNumber()->service();
        });

        return $container;
    }

    /**
     * @return array<string>
     */
    protected function getProductSalePageWidgetPlugins(): array
    {
        return [];
    }
}
