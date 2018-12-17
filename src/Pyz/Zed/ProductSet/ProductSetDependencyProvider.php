<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductSet;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductSet\ProductSetDependencyProvider as SprykerProductSetDependencyProvider;

class ProductSetDependencyProvider extends SprykerProductSetDependencyProvider
{
    public const FACADE_EVENT = 'FACADE_EVENT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $this->addEventFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventFacade(Container $container)
    {
        $container[static::FACADE_EVENT] = function (Container $container) {
            return $container->getLocator()->event()->facade();
        };

        return $container;
    }
}
