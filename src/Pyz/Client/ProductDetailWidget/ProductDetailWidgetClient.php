<?php
namespace Pyz\Client\ProductDetailWidget;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Pyz\Client\ProductDetailWidget\Dependency\Client\ProductDetailWidgetClientInterface;
use Spryker\Client\Kernel\AbstractClient;

class ProductDetailWidgetClient  extends AbstractClient implements ProductDetailWidgetClientInterface
{
    /**
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku(string $sku): ?ProductAbstractTransfer
    {
        return $this->getFactory()->createZedStub()->findProductAbstractBySku($sku);
    }
}
