<?php

namespace Pyz\Client\ProductDetailWidget;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class ProductDetailWidgetDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_PRODUCT_DETAIL = 'CLIENT_PRODUCT_DETAIL';

    public const SERVICE_ZED = 'SERVICE_ZED';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addProductDetailClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addProductDetailClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT_DETAIL, function (Container $container) {
            return $container->getLocator()->productDetailWidget()->client();
        });

        return $container;
    }
}
