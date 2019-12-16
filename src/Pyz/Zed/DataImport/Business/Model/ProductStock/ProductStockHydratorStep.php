<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductStock;

use Generated\Shared\Transfer\SpyStockEntityTransfer;
use Generated\Shared\Transfer\SpyStockProductEntityTransfer;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class ProductStockHydratorStep implements DataImportStepInterface
{
    public const BULK_SIZE = 100;
    public const KEY_NAME = 'name';
    public const KEY_CONCRETE_SKU = 'concrete_sku';
    public const KEY_QUANTITY = 'quantity';
    public const KEY_IS_NEVER_OUT_OF_STOCK = 'is_never_out_of_stock';
    public const KEY_IS_BUNDLE = 'is_bundle';
    public const KEY_FK_PRODUCT = 'fk_product';
    public const KEY_FK_STOCK = 'fk_stock';
    public const STOCK_ENTITY_TRANSFER = 'STOCK_ENTITY_TRANSFER';
    public const STOCK_PRODUCT_ENTITY_TRANSFER = 'STOCK_PRODUCT_ENTITY_TRANSFER';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $this->importStock($dataSet);
        $this->importStockProduct($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importStock(DataSetInterface $dataSet): void
    {
        $stockEntityTransfer = new SpyStockEntityTransfer();
        $stockEntityTransfer->setName($dataSet[static::KEY_NAME]);
        $dataSet[static::STOCK_ENTITY_TRANSFER] = $stockEntityTransfer;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importStockProduct(DataSetInterface $dataSet): void
    {
        $stockProductEntityTransfer = new SpyStockProductEntityTransfer();
        $stockProductEntityTransfer
            ->setQuantity($dataSet[static::KEY_QUANTITY])
            ->setIsNeverOutOfStock($dataSet[static::KEY_IS_NEVER_OUT_OF_STOCK]);
        $dataSet[static::STOCK_PRODUCT_ENTITY_TRANSFER] = $stockProductEntityTransfer;
    }
}
