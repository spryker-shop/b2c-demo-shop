<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\HelloSpryker;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class HelloSprykerDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_HELLO_SPRYKER = 'FACADE_HELLO_SPRYKER';

    /**
     * @param $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
//        $container = parent::provideDependencies($container);

        $container = $this->addContactUsFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addContactUsFacade(Container $container): Container
    {
//        $container->set(static::FACADE_HELLO_SPRYKER, function (Container $container) {
//            return $container->getLocator()->helloSpryker()->facade();
//        });
//
//        return $container;
        $container[static::FACADE_HELLO_SPRYKER] = function (Container $container) {
            $container->getLocator()->helloSpryker()->facade();
        };

        return $container;
    }
}
