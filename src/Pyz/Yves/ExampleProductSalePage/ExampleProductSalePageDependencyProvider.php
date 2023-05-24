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
    public const PYZ_CLIENT_SEARCH = 'PYZ_CLIENT_SEARCH';

    /**
     * @var string
     */
    public const PYZ_CLIENT_URL_STORAGE = 'PYZ_CLIENT_URL_STORAGE';

    /**
     * @var string
     */
    public const PYZ_CLIENT_STORE = 'PYZ_CLIENT_STORE';

    /**
     * @var string
     */
    public const PYZ_PLUGIN_PRODUCT_SALE_PAGE_WIDGETS = 'PYZ_PLUGIN_PRODUCT_SALE_PAGE_WIDGETS';

    /**
     * @var string
     */
    public const PYZ_CLIENT_CATALOG = 'PYZ_CLIENT_CATALOG';

    /**
     * @var string
     */
    public const PYZ_CLIENT_LOCALE = 'PYZ_CLIENT_LOCALE';

    /**
     * @var string
     */
    public const PYZ_SERVICE_UTIL_NUMBER = 'PYZ_SERVICE_UTIL_NUMBER';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addPyzSearchClient($container);
        $container = $this->addPyzUrlStorageClient($container);
        $container = $this->addPyzClientStore($container);
        $container = $this->addProductSalePageWidgetPlugins($container);
        $container = $this->addPyzCatalogClient($container);
        $container = $this->addPyzLocaleClient($container);
        $container = $this->addPyzUtilNumberService($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzSearchClient(Container $container): Container
    {
        $container->set(static::PYZ_CLIENT_SEARCH, function (Container $container) {
            return $container->getLocator()->search()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzUrlStorageClient(Container $container): Container
    {
        $container->set(static::PYZ_CLIENT_URL_STORAGE, function (Container $container) {
            return $container->getLocator()->urlStorage()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzClientStore($container): Container
    {
        $container->set(static::PYZ_CLIENT_STORE, function (Container $container) {
            return $container->getLocator()->store()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzCatalogClient(Container $container): Container
    {
        $container->set(static::PYZ_CLIENT_CATALOG, function (Container $container) {
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
        $container->set(static::PYZ_PLUGIN_PRODUCT_SALE_PAGE_WIDGETS, function () {
            return $this->getProductSalePageWidgetPlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzLocaleClient(Container $container): Container
    {
        $container->set(static::PYZ_CLIENT_LOCALE, function (Container $container) {
            return $container->getLocator()->locale()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzUtilNumberService(Container $container): Container
    {
        $container->set(static::PYZ_SERVICE_UTIL_NUMBER, function (Container $container) {
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
