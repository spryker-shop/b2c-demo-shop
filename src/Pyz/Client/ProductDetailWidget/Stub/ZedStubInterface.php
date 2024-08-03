<?php

namespace Pyz\Client\ProductDetailWidget\Stub;

use Generated\Shared\Transfer\ProductDataTransfer;
use Generated\Shared\Transfer\ProductResponseTransfer;

interface ZedStubInterface
{
    /**
     * @param string $sku
     *
     * @return ProductResponseTransfer
     */
    public function findProductAbstractBySku(string $sku): ProductResponseTransfer;
}

