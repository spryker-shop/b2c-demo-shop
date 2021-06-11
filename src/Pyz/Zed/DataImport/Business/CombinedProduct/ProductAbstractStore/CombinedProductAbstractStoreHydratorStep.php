<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductAbstractStore;

use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\ProductAbstractStoreHydratorStep;

class CombinedProductAbstractStoreHydratorStep extends ProductAbstractStoreHydratorStep
{
    public const BULK_SIZE = 5000;

    public const COLUMN_ABSTRACT_SKU = 'abstract_sku';
    public const COLUMN_STORE_NAME = 'product_abstract_store.store_name';
}
