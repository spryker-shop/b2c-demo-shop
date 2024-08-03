<?php

namespace Pyz\Yves\ProductDetailWidget\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailWidgetToProductDetailClientInterface
{
    /**
     * Fetches the product abstract data by its ID.
     *
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku(string $sku): ?ProductAbstractTransfer;
}
