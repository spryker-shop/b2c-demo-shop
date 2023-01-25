<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ExampleProductSalePageDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PYZ_QUERY_CONTAINER_PRODUCT_LABEL = 'PYZ_QUERY_CONTAINER_PRODUCT_LABEL';

    /**
     * @var string
     */
    public const PYZ_QUERY_CONTAINER_PRODUCT = 'PYZ_QUERY_CONTAINER_PRODUCT';

    /**
     * @var string
     */
    public const PYZ_FACADE_CURRENCY = 'PYZ_FACADE_CURRENCY';

    /**
     * @var string
     */
    public const PYZ_FACADE_PRICE = 'PYZ_FACADE_PRICE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        $container = $this->addPyzProductLabelQueryContainer($container);
        $container = $this->addPyzProductQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addPyzCurrencyFacade($container);
        $container = $this->addPyzPriceFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPyzProductLabelQueryContainer(Container $container): Container
    {
        $container->set(static::PYZ_QUERY_CONTAINER_PRODUCT_LABEL, function (Container $container) {
            return $container->getLocator()->productLabel()->queryContainer();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPyzProductQueryContainer(Container $container): Container
    {
        $container->set(static::PYZ_QUERY_CONTAINER_PRODUCT, function (Container $container) {
            return $container->getLocator()->product()->queryContainer();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPyzCurrencyFacade(Container $container): Container
    {
        $container->set(static::PYZ_FACADE_CURRENCY, function (Container $container) {
            return $container->getLocator()->currency()->facade();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPyzPriceFacade(Container $container): Container
    {
        $container->set(static::PYZ_FACADE_PRICE, function (Container $container) {
            return $container->getLocator()->price()->facade();
        });

        return $container;
    }
}
