<?php
namespace Pyz\Client\ProductDetailWidget;

use Pyz\Yves\ProductDetailWidget\ProductDetailWidgetDependencyProvider;
use Spryker\Client\Kernel\AbstractFactory;

class ProductDetailFactory extends AbstractFactory
{
    public function createProductService(): ProductDetailWidgetClient
    {
        return $this->getProvidedDependency(ProductDetailWidgetDependencyProvider::CLIENT_PRODUCT_DETAIL);
    }
}
