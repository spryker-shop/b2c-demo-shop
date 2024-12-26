<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductAbstractStore;

use Pyz\Zed\DataImport\Business\CombinedProduct\DataSet\CombinedProductMandatoryColumnCondition;

class CombinedProductAbstractStoreMandatoryColumnCondition extends CombinedProductMandatoryColumnCondition
{
    /**
     * @return array<string>
     */
    protected function getMandatoryColumns(): array
    {
        return [
            CombinedProductAbstractStoreHydratorStep::COLUMN_STORE_NAME,
        ];
    }
}
