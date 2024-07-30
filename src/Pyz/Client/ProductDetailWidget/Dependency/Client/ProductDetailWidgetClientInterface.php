<?php
namespace Pyz\Client\ProductDetailWidget\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailWidgetClientInterface
{
    public function getProductAbstractData(int $id): ?ProductAbstractTransfer;
}
