<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductConcrete;

use Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CombinedProductConcreteTypeDataSetCondition implements DataSetConditionInterface
{
    /**
     * @var string
     */
    protected const ASSIGNABLE_PRODUCT_TYPE_CONCRETE = 'concrete';

    /**
     * @var string
     */
    protected const ASSIGNABLE_PRODUCT_TYPE_BOTH = 'both';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return bool
     */
    public function hasData(DataSetInterface $dataSet): bool
    {
        if (
            $dataSet[CombinedProductConcreteHydratorStep::COLUMN_ASSIGNED_PRODUCT_TYPE] === static::ASSIGNABLE_PRODUCT_TYPE_CONCRETE
            || $dataSet[CombinedProductConcreteHydratorStep::COLUMN_ASSIGNED_PRODUCT_TYPE] === static::ASSIGNABLE_PRODUCT_TYPE_BOTH
        ) {
            return true;
        }

        return false;
    }
}
