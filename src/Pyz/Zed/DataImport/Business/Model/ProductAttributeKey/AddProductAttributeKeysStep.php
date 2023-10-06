<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductAttributeKey;

use Orm\Zed\Product\Persistence\Map\SpyProductAttributeKeyTableMap;
use Orm\Zed\Product\Persistence\SpyProductAttributeKeyQuery;
use Propel\Runtime\Formatter\SimpleArrayFormatter;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class AddProductAttributeKeysStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    public const KEY_TARGET = 'attributeKeys';

    /**
     * @var array<string, int>
     */
    protected $productAttributeKeys = [];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        if (!$this->productAttributeKeys) {
            $query = SpyProductAttributeKeyQuery::create()
                ->select([
                    SpyProductAttributeKeyTableMap::COL_ID_PRODUCT_ATTRIBUTE_KEY,
                    SpyProductAttributeKeyTableMap::COL_KEY,
                ])
                ->setFormatter(new SimpleArrayFormatter());

            /** @var array<array<string, mixed>> $productAttributeKeys */
            $productAttributeKeys = $query->find();
            foreach ($productAttributeKeys as $productAttributeKey) {
                /** @var string $key */
                $key = $productAttributeKey[SpyProductAttributeKeyTableMap::COL_KEY];
                $value = $productAttributeKey[SpyProductAttributeKeyTableMap::COL_ID_PRODUCT_ATTRIBUTE_KEY];

                $this->productAttributeKeys[$key] = $value;
            }
        }

        $dataSet[static::KEY_TARGET] = $this->productAttributeKeys;
    }
}
