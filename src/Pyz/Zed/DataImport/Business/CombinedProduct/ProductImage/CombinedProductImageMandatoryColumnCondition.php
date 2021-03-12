<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductImage;

use Pyz\Zed\DataImport\Business\CombinedProduct\DataSet\CombinedProductMandatoryColumnCondition;

class CombinedProductImageMandatoryColumnCondition extends CombinedProductMandatoryColumnCondition
{
    /**
     * @return string[]
     */
    protected function getMandatoryColumns(): array
    {
        return [
            CombinedProductImageHydratorStep::COLUMN_IMAGE_SET_NAME,
            CombinedProductImageHydratorStep::COLUMN_EXTERNAL_URL_LARGE,
            CombinedProductImageHydratorStep::COLUMN_EXTERNAL_URL_SMALL,
            CombinedProductImageHydratorStep::COLUMN_LOCALE,
            CombinedProductImageHydratorStep::COLUMN_SORT_ORDER,
            CombinedProductImageHydratorStep::COLUMN_PRODUCT_IMAGE_KEY,
            CombinedProductImageHydratorStep::COLUMN_PRODUCT_IMAGE_SET_KEY,
            CombinedProductImageHydratorStep::COLUMN_ASSIGNED_PRODUCT_TYPE,
        ];
    }
}
