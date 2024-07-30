<?php

namespace Pyz\Yves\ProductDetailWidget\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailWidgetToProductClientInterface
{
    /**
     * Fetches the product abstract data by its ID.
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer;
}
