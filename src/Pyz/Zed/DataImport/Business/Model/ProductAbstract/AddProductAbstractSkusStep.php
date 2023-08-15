<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductAbstract;

use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Propel\Runtime\Formatter\SimpleArrayFormatter;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class AddProductAbstractSkusStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    public const KEY_PRODUCT_ABSTRACT_SKUS = 'productAbstractSkus';

    /**
     * @var array<string, int>
     */
    protected $productAbstractSkus = [];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        if (!$this->productAbstractSkus) {
            $query = SpyProductAbstractQuery::create();
            $query->select([
                SpyProductAbstractTableMap::COL_SKU,
                SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
            ])->setFormatter(new SimpleArrayFormatter());

            /** @var array<array<string, mixed>> $productAbstractEntities */
            $productAbstractEntities = $query->find();

            foreach ($productAbstractEntities as $productAbstractEntity) {
                /** @var string $key */
                $key = $productAbstractEntity[SpyProductAbstractTableMap::COL_SKU];
                $value = $productAbstractEntity[SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT];
                $this->productAbstractSkus[$key] = $value;
            }
        }

        $dataSet[static::KEY_PRODUCT_ABSTRACT_SKUS] = $this->productAbstractSkus;
    }
}
