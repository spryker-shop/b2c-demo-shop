<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductGroup;

use Pyz\Zed\DataImport\Business\CombinedProduct\DataSet\CombinedProductMandatoryColumnCondition;

class CombinedProductGroupMandatoryColumnCondition extends CombinedProductMandatoryColumnCondition
{
    /**
     * @return array<string>
     */
    protected function getMandatoryColumns(): array
    {
        return [
            CombinedProductGroupWriter::COLUMN_PRODUCT_GROUP_KEY,
            CombinedProductGroupWriter::COLUMN_POSITION,
        ];
    }
}
