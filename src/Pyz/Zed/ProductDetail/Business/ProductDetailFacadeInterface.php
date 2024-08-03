<?php

namespace Pyz\Zed\ProductDetail\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductResponseTransfer;

interface ProductDetailFacadeInterface
{
    /**
     * Specification:
     * - Finds a book entity by ID.
     * - Returns null if the book entity does not exist.
     *
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductResponseTransfer|null
     *@api
     *
     */
    public function findProductAbstractBySku(string $sku): ?ProductResponseTransfer;
}
