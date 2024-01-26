<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTaskGui;

use Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CustomerTaskGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_CUSTOMER_TASK_QUERY = 'PROPEL_CUSTOMER_TASK_QUERY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addCustomerTaskPropelQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addCustomerTaskPropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_CUSTOMER_TASK_QUERY, $container->factory(function () {
            return PyzCustomerTaskQuery::create();
        }));

        return $container;
    }
}
