<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business;

use Spryker\Zed\DataImport\Business\DataImportFacade as SprykerDataImportFacade;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

/**
 * @method \Pyz\Zed\DataImport\Business\DataImportBusinessFactory getFactory()
 */
class DataImportFacade extends SprykerDataImportFacade implements DataImportFacadeInterface
{
    public function writeProductAbstractDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createProductAbstractPropelWriter()->write($dataSet);
    }

    public function flushProductAbstractDataImporter(): void
    {
        $this->getFactory()->createProductAbstractPropelWriter()->flush();
    }

    public function writeProductConcreteDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createProductConcretePropelWriter()->write($dataSet);
    }

    public function flushProductConcreteDataImporter(): void
    {
        $this->getFactory()->createProductConcretePropelWriter()->flush();
    }

    public function writeProductImageDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createProductImagePropelWriter()->write($dataSet);
    }

    public function flushProductImageDataImporter(): void
    {
        $this->getFactory()->createProductImagePropelWriter()->flush();
    }

    public function writeProductStockDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createProductStockPropelWriter()->write($dataSet);
    }

    public function flushProductStockDataImporter(): void
    {
        $this->getFactory()->createProductStockPropelWriter()->flush();
    }

    public function writeProductAbstractStoreDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createProductAbstractStorePropelWriter()->write($dataSet);
    }

    public function flushProductAbstractStoreDataImporter(): void
    {
        $this->getFactory()->createProductAbstractStorePropelWriter()->flush();
    }

    public function writeCombinedProductPriceDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createCombinedProductPricePropelDataSetWriter()->write($dataSet);
    }

    public function flushCombinedProductPriceDataImporter(): void
    {
        $this->getFactory()->createCombinedProductPricePropelDataSetWriter()->flush();
    }

    public function writeCombinedProductImageDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createCombinedProductImagePropelDataSetWriter()->write($dataSet);
    }

    public function flushCombinedProductImageDataImporter(): void
    {
        $this->getFactory()->createCombinedProductImagePropelDataSetWriter()->flush();
    }

    public function writeCombinedProductStockDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createCombinedProductStockPropelDataSetWriter()->write($dataSet);
    }

    public function flushCombinedProductStockDataImporter(): void
    {
        $this->getFactory()->createCombinedProductStockPropelDataSetWriter()->flush();
    }

    public function writeCombinedProductAbstractStoreDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createCombinedProductAbstractStorePropelDataSetWriter()->write($dataSet);
    }

    public function flushCombinedProductAbstractStoreDataImporter(): void
    {
        $this->getFactory()->createCombinedProductAbstractStorePropelDataSetWriter()->flush();
    }

    public function writeCombinedProductAbstractDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createCombinedProductAbstractPropelDataSetWriter()->write($dataSet);
    }

    public function flushCombinedProductAbstractDataImporter(): void
    {
        $this->getFactory()->createCombinedProductAbstractPropelDataSetWriter()->flush();
    }

    public function writeCombinedProductConcreteDataSet(DataSetInterface $dataSet): void
    {
        $this->getFactory()->createCombinedProductConcretePropelDataSetWriter()->write($dataSet);
    }

    public function flushCombinedProductConcreteDataImporter(): void
    {
        $this->getFactory()->createCombinedProductConcretePropelDataSetWriter()->flush();
    }
}
