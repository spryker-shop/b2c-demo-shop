<?php
namespace Pyz\Client\ProductDetailWidget;

use Pyz\Yves\ProductDetailWidget\ProductDetailWidgetDependencyProvider;
use Spryker\Client\Kernel\AbstractFactory;

class ProductDetailWidgetFactory extends AbstractFactory
{
    public function createProductService(): ProductDetailWidgetServiceInterface
    {
        return $this->getProvidedDependency(ProductDetailWidgetDependencyProvider::SERVICE_PRODUCT);
    }
}
