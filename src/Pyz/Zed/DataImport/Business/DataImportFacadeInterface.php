<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business;

use Spryker\Zed\DataImport\Business\DataImportFacadeInterface as SprykerDataImportFacadeInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

/**
 * @method \Pyz\Zed\DataImport\Business\DataImportBusinessFactory getFactory()
 */
interface DataImportFacadeInterface extends SprykerDataImportFacadeInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeProductAbstractDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushProductAbstractDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeProductConcreteDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushProductConcreteDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeProductImageDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushProductImageDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeProductStockDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushProductStockDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeProductAbstractStoreDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushProductAbstractStoreDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeCombinedProductPriceDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushCombinedProductPriceDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeCombinedProductImageDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushCombinedProductImageDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeCombinedProductStockDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushCombinedProductStockDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeCombinedProductAbstractStoreDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushCombinedProductAbstractStoreDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeCombinedProductAbstractDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushCombinedProductAbstractDataImporter(): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeCombinedProductConcreteDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushCombinedProductConcreteDataImporter(): void;
}
