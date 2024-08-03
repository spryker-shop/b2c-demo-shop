<?php

namespace Pyz\Zed\ProductDetail\Business\Manager;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductResponseTransfer;

interface ProductDetailManagerInterface
{
    /**
     * Specification:
     * - Finds a product abstract by its ID.
     * - Returns the ProductAbstractTransfer if found, null otherwise.
     *
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductResponseTransfer|null
     */
    public function findProductAbstractBySku(string $sku): ?ProductResponseTransfer;
}
