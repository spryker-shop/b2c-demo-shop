<?php

namespace Pyz\Zed\ProductDetailPageWidget\Business\Manager;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailManagerInterface
{
    /**
     * Specification:
     * - Finds a product abstract by its ID.
     * - Returns the ProductAbstractTransfer if found, null otherwise.
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer;
}
