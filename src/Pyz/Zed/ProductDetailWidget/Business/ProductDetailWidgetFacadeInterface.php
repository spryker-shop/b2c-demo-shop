<?php

namespace Pyz\Zed\ProductDetailPageWidget\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailWidgetFacadeInterface
{
    /**
     * Specification:
     * - Finds a book entity by ID.
     * - Returns null if the book entity does not exist.
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     *@api
     *
     */
    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer;
}
