<?php
namespace Pyz\Client\ProductDetailWidget;

use Pyz\Client\ProductDetailWidget\Stub\ZedStub;
use Pyz\Yves\ProductDetailWidget\ProductDetailWidgetDependencyProvider;
use Spryker\Client\Kernel\AbstractFactory;

class ProductDetailWidgetFactory extends AbstractFactory
{
    /**
     */
    public function createZedStub(): ZedStub
    {
        return new ZedStub($this->getZedService());
    }

    public function getZedService()
    {
        return $this->getProvidedDependency(ProductDetailWidgetDependencyProvider::SERVICE_ZED);
    }
}
