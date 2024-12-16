<?php

namespace Pyz\Yves\ProductDetailWidget\Widget;

use Generated\Shared\Transfer\ProductResponseTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \Pyz\Yves\ProductDetailWidget\ProductDetailWidgetFactory getFactory()
 */
class ProductDetailWidget extends AbstractWidget
{
    /**
     * @param string $sku
     */
    public function __construct(string $sku)
    {
        $this->addParameter('sku', $sku);
        $zedClient = $this->getFactory()->getZedClient(); // Get Zed client

        $productAbstractTransfer = new ProductAbstractTransfer();
        $productAbstractTransfer->setSku($sku);

        /** @var \Generated\Shared\Transfer\ProductResponseTransfer $productResponseTransfer */
        $productResponseTransfer = $zedClient->call('/product-detail/gateway/get-product-detail', $productAbstractTransfer);

        if ($productResponseTransfer->getIsSuccess()) {
            $productAbstractTransfer = $productResponseTransfer->getProductAbstract();
            $this->addParameter('productAbstract', $productAbstractTransfer);
        } else {
            // Handle the error case, maybe set a default or error message
            $this->addParameter('errorMessage', $productResponseTransfer->getMessage());
        }
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
}
