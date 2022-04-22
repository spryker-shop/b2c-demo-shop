<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductWidget;

use Spryker\Client\ContentProduct\ContentProductClient;
use Spryker\Client\ProductStorage\ProductStorageClient;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ContentProductWidget\ContentProductWidgetDependencyProvider as SprykerContentProductWidgetDependencyProvider;

class ContentProductWidgetDependencyProvider extends SprykerContentProductWidgetDependencyProvider
{
    /**
     * @var string
     */
    public const PYZ_CLIENT_CONTENT_PRODUCT = 'PYZ_CLIENT_CONTENT_PRODUCT';

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
        $container = $this->addPyzContentProductClient($container);
        $container = $this->addPyzProductStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzContentProductClient(Container $container): Container
    {
        $container->set(static::PYZ_CLIENT_CONTENT_PRODUCT, function () {
            return new ContentProductClient();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzProductStorageClient(Container $container): Container
    {
        $container->set(static::PYZ_CLIENT_PRODUCT_STORAGE, function () {
            return new ProductStorageClient();
        });

        return $container;
    }
}
