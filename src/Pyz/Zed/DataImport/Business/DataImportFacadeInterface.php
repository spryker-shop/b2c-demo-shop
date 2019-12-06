<?php
/**
 * Created by PhpStorm.
 * User: kravchenko
 * Date: 2019-12-06
 * Time: 13:07
 */

namespace Pyz\Zed\DataImport\Business;

use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

interface DataImportFacadeInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeProductStockDataSet(DataSetInterface $dataSet): void;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function writeProductStockPdoDataSet(DataSetInterface $dataSet): void;

    /**
     * @return void
     */
    public function flushProductStockDataImporter(): void;

    /**
     * @return void
     */
    public function flushProductStockPdoDataImporter(): void;
}
