<?php

namespace Pyz\Yves\ProductDetailWidget\Widget;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \Pyz\Yves\ProductDetailWidget\ProductDetailWidgetFactory getFactory()
 */
class ProductDetailWidget extends AbstractWidget
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     */
    public function __construct(ProductAbstractTransfer $productAbstractTransfer)
    {
        $this->addParameter('productAbstractTransfer', $this->getProductAbstractTransfer($productAbstractTransfer));
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'ProductDetailWidget';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@ProductDetailWidget/views/product-detail/product-detail.twig';
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected function getProductAbstractTransfer(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $productAbstractTransfer;
    }
}
