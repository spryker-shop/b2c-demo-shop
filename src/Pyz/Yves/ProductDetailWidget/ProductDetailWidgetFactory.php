<?php

namespace Pyz\Yves\ProductDetailWidget;

use Pyz\Client\ProductDetailWidget\Dependency\Client\ProductDetailWidgetClientInterface;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Yves\Kernel\AbstractFactory;

class ProductDetailWidgetFactory extends AbstractFactory
{
    /**
     * @return ProductDetailWidgetClientInterface
     */
    public function getProductDetailClient(): ProductDetailWidgetClientInterface
    {
        return $this->getProvidedDependency(ProductDetailWidgetDependencyProvider::CLIENT_PRODUCT_DETAIL);
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    public function getZedClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(ProductDetailWidgetDependencyProvider::SERVICE_ZED);
    }
}

