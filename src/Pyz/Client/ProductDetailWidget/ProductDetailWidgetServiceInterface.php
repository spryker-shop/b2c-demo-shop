<?php

namespace Pyz\Client\ProductDetailWidget;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailWidgetServiceInterface
{
    /**
     * Fetches a product abstract by its ID.
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer;
}
