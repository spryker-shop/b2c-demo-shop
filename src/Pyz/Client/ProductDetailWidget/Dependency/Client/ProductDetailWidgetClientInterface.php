<?php

namespace Pyz\Client\ProductDetailWidget\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailWidgetClientInterface
{
    /**
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku(string $sku): ?ProductAbstractTransfer;
}
