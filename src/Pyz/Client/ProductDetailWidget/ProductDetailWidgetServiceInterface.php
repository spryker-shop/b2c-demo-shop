<?php

namespace Pyz\Client\ProductDetailWidget;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailWidgetServiceInterface
{
    /**
     * Fetches a product abstract by its ID.
     *
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku(string $sku): ?ProductAbstractTransfer;
}
