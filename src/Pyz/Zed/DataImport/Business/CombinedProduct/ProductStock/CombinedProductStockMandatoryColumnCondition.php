<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductStock;

use Pyz\Zed\DataImport\Business\CombinedProduct\DataSet\CombinedProductMandatoryColumnCondition;

class CombinedProductStockMandatoryColumnCondition extends CombinedProductMandatoryColumnCondition
{
    /**
     * @return string[]
     */
    protected function getMandatoryColumns(): array
    {
        return [
            CombinedProductStockHydratorStep::COLUMN_NAME,
            CombinedProductStockHydratorStep::COLUMN_QUANTITY,
            CombinedProductStockHydratorStep::COLUMN_IS_NEVER_OUT_OF_STOCK,
            CombinedProductStockHydratorStep::COLUMN_IS_BUNDLE,
        ];
    }
}
