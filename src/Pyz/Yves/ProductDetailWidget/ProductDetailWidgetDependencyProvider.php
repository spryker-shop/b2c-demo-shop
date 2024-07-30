<?php

namespace Pyz\Yves\ProductDetailWidget;

use Pyz\Yves\ProductDetailWidget\Dependency\Client\ProductDetailWidgetToProductClientBridge;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class ProductDetailWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_PRODUCT = 'CLIENT_PRODUCT';
    const SERVICE_PRODUCT = 'SERVICE_PRODUCT';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addProductClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT, function (Container $container) {
            return new ProductDetailWidgetToProductClientBridge($container->getLocator()->product()->client());
        });

        return $container;
    }
}
