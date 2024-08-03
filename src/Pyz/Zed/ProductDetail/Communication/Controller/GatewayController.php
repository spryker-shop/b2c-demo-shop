<?php
namespace Pyz\Zed\ProductDetail\Communication\Controller;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductResponseTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Pyz\Zed\ProductDetail\Business\ProductDetailFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productDataTransfer
     *
     * @return \Generated\Shared\Transfer\ProductResponseTransfer
     */
    public function getProductDetailAction(ProductAbstractTransfer $productDataTransfer): ProductResponseTransfer
    {
        return $this->getFacade()->findProductAbstractBySku($productDataTransfer->getSku());
    }
}
