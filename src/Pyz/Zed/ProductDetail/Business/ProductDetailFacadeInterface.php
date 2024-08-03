<?php

namespace Pyz\Zed\ProductDetailWidget\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailFacadeInterface
{
    /**
     * Specification:
     * - Finds a book entity by ID.
     * - Returns null if the book entity does not exist.
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductResponseTransfer|null
     *@api
     *
     */
    public function findProductAbstractById(int $idProductAbstract): ?ProductResponseTransfer;
}
