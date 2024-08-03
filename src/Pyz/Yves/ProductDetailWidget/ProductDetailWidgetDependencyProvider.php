<?php

namespace Pyz\Yves\ProductDetailWidget;

use Pyz\Yves\ProductDetailWidget\Dependency\Client\ProductDetailWidgetToProductDetailClientBridge;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class ProductDetailWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_PRODUCT_DETAIL = 'CLIENT_PRODUCT_DETAIL';
    const SERVICE_ZED = "SERVICE_ZED";

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addServiceZed($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductDetailClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT_DETAIL, function (Container $container) {
            return $container->getLocator()->productDetailWidget()->client();
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addServiceZed(Container $container): Container
    {
        $container[self::SERVICE_ZED] = function (Container $container) {
            return $container->getLocator()->zedRequest()->client();
        };

        return $container;
    }
}
