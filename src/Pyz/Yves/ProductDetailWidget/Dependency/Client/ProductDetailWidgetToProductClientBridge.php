<?php

namespace Pyz\Yves\ProductDetailWidget\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractTransfer;

class ProductDetailWidgetToProductClientBridge implements ProductDetailWidgetToProductClientInterface
{
    /**
     * @var \Spryker\Client\Product\ProductClientInterface
     */
    protected $productClient;

    /**
     * @param \Spryker\Client\Product\ProductClientInterface $productClient
     */
    public function __construct($productClient)
    {
        $this->productClient = $productClient;
    }

    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer
    {
        return $this->productClient->findProductAbstractById($idProductAbstract);
    }
}
