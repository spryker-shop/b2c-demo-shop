<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTasksRestApi;

use Pyz\Zed\CustomerTask\Business\CustomerTaskFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CustomerTasksRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_CUSTOMER_TASK = 'FACADE_CUSTOMER_TASK';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addCustomerTaskFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addCustomerTaskFacade(Container $container): Container
    {
        $container->set(static::FACADE_CUSTOMER_TASK, static function (Container $container): CustomerTaskFacadeInterface {
            return $container->getLocator()->customerTask()->facade();
        });

        return $container;
    }
}
