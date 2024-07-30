<?php
namespace Pyz\Client\ProductDetailWidget;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Pyz\Client\ProductDetailWidget\Dependency\Client\ProductDetailWidgetClientInterface;
use Spryker\Client\Kernel\AbstractClient;

class ProductDetailWidgetClient extends AbstractClient implements ProductDetailWidgetClientInterface
{
    public function getProductAbstractData(int $id): ?ProductAbstractTransfer
    {
        return $this->getFactory()->createProductService()->findProductAbstractById($id);
    }
}
