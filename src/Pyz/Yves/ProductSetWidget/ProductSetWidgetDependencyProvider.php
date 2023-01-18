<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductSetWidget;

use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ProductSetWidget\ProductSetWidgetDependencyProvider as SprykerProductSetWidgetDependencyProvider;

class ProductSetWidgetDependencyProvider extends SprykerProductSetWidgetDependencyProvider
{
    /**
     * @var string
     */
    public const PYZ_CLIENT_PRODUCT_SET_STORAGE = 'PYZ_CLIENT_PRODUCT_SET_STORAGE';

    /**
     * @var string
     */
    public const PYZ_CLIENT_PRODUCT_STORAGE = 'PYZ_CLIENT_PRODUCT_STORAGE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addPyzProductStorageClient($container);
        $container = $this->addPyzProductSetStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return mixed
     */
    protected function addPyzProductStorageClient(Container $container)
    {
        $container->set(static::PYZ_CLIENT_PRODUCT_STORAGE, function (Container $container) {
            return $container->getLocator()->productStorage()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzProductSetStorageClient(Container $container): Container
    {
        $container->set(static::PYZ_CLIENT_PRODUCT_SET_STORAGE, function (Container $container) {
            return $container->getLocator()->productSetStorage()->client();
        });

        return $container;
    }
}
