<?php

namespace Pyz\Yves\ProductDetailWidget\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Pyz\Client\ProductDetailWidget\Dependency\Client\ProductDetailWidgetClientInterface;

class ProductDetailWidgetToProductDetailClientBridge implements ProductDetailWidgetToProductDetailClientInterface
{
    /**
     * @var ProductDetailWidgetClientInterface
     */
    protected $productDetailWidgetClient;

    /**
     * @param ProductDetailWidgetClientInterface $productDetailWidgetClient
     */
    public function __construct($productDetailWidgetClient)
    {
        $this->productDetailWidgetClient = $productDetailWidgetClient;
    }

    /**
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku(string $sku): ?ProductAbstractTransfer
    {
        return $this->productDetailWidgetClient->findProductAbstractBySku($sku);
    }
}
