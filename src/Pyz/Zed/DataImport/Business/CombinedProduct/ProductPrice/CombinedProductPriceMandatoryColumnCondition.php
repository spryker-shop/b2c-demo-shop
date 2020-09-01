<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductPrice;

use Pyz\Zed\DataImport\Business\CombinedProduct\DataSet\CombinedProductMandatoryColumnCondition;

class CombinedProductPriceMandatoryColumnCondition extends CombinedProductMandatoryColumnCondition
{
    /**
     * @return string[]
     */
    protected function getMandatoryColumns(): array
    {
        return [
            CombinedProductPriceHydratorStep::COLUMN_CURRENCY,
            CombinedProductPriceHydratorStep::COLUMN_STORE,
            CombinedProductPriceHydratorStep::COLUMN_PRICE_NET,
            CombinedProductPriceHydratorStep::COLUMN_PRICE_GROSS,
            CombinedProductPriceHydratorStep::COLUMN_PRICE_DATA,
            CombinedProductPriceHydratorStep::COLUMN_PRICE_DATA_CHECKSUM,
            CombinedProductPriceHydratorStep::COLUMN_PRICE_TYPE,
            CombinedProductPriceHydratorStep::COLUMN_ASSIGNED_PRODUCT_TYPE,
        ];
    }
}
