<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductStock;

use Pyz\Zed\DataImport\Business\Model\ProductStock\ProductStockHydratorStep;

class CombinedProductStockHydratorStep extends ProductStockHydratorStep
{
    public const BULK_SIZE = 5000;

    public const COLUMN_CONCRETE_SKU = 'concrete_sku';

    public const COLUMN_NAME = 'product_stock.name';
    public const COLUMN_QUANTITY = 'product_stock.quantity';
    public const COLUMN_IS_NEVER_OUT_OF_STOCK = 'product_stock.is_never_out_of_stock';
    public const COLUMN_IS_BUNDLE = 'product_stock.is_bundle';
}
