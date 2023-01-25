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
    /**
     * @var int
     */
    public const BULK_SIZE = 100;

    /**
     * @var string
     */
    public const COLUMN_CONCRETE_SKU = 'concrete_sku';

    /**
     * @var string
     */
    public const COLUMN_NAME = 'name';

    /**
     * @var string
     */
    public const COLUMN_QUANTITY = 'quantity';

    /**
     * @var string
     */
    public const COLUMN_IS_NEVER_OUT_OF_STOCK = 'is_never_out_of_stock';

    /**
     * @var string
     */
    public const COLUMN_IS_BUNDLE = 'is_bundle';

    /**
     * @var string
     */
    public const KEY_FK_PRODUCT = 'fk_product';

    /**
     * @var string
     */
    public const KEY_FK_STOCK = 'fk_stock';

    /**
     * @var string
     */
    public const STOCK_ENTITY_TRANSFER = 'STOCK_ENTITY_TRANSFER';

    /**
     * @var string
     */
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
        $stockEntityTransfer->setName($dataSet[static::COLUMN_NAME]);

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
            ->setQuantity($dataSet[static::COLUMN_QUANTITY])
            ->setIsNeverOutOfStock($dataSet[static::COLUMN_IS_NEVER_OUT_OF_STOCK]);

        $dataSet[static::STOCK_PRODUCT_ENTITY_TRANSFER] = $stockProductEntityTransfer;
    }
}
