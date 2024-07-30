<?php

namespace Pyz\Yves\ProductDetailWidget;

use Spryker\Yves\Kernel\AbstractFactory;
use Pyz\Yves\ProductDetailWidget\Dependency\Client\ProductDetailWidgetToProductClientInterface;

class ProductDetailWidgetFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Yves\ProductDetailWidget\Dependency\Client\ProductDetailWidgetToProductClientInterface
     */
    public function getProductClient(): ProductDetailWidgetToProductClientInterface
    {
        return $this->getProvidedDependency(ProductDetailWidgetDependencyProvider::CLIENT_PRODUCT);
    }
}
