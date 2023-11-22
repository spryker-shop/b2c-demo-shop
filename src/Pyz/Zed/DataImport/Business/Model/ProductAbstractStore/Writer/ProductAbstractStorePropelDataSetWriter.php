<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\Writer;

use Generated\Shared\Transfer\ProductAbstractStoreTransfer;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\Product\Persistence\SpyProductAbstractStoreQuery;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\ProductAbstractStoreHydratorStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;

class ProductAbstractStorePropelDataSetWriter implements DataSetWriterInterface
{
    /**
     * @var array<int> Keys are SKUs, values are product abstract ids.
     */
    protected static $idProductAbstractBuffer;

    /**
     * @var array<int> Keys are store names, values are store ids.
     */
    protected static $idStoreBuffer;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $this->createOrUpdateProductAbstractStore($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function createOrUpdateProductAbstractStore(DataSetInterface $dataSet): void
    {
        $productAbstractStoreTransfer = $this->getProductAbstractStoreTransfers($dataSet);

        $productAbstractEntity = $this->getIdProductAbstractBySku($productAbstractStoreTransfer->getProductAbstractSku());
        $storeEntity = $this->getIdStoreByName($productAbstractStoreTransfer->getStoreName());

        (new SpyProductAbstractStoreQuery())
            ->filterByFkProductAbstract($productAbstractEntity)
            ->filterByFkStore($storeEntity)
            ->findOneOrCreate()
            ->save();
    }

    /**
     * @param string $productAbstractSku
     *
     * @return int
     */
    protected function getIdProductAbstractBySku($productAbstractSku): int
    {
        if (!isset(static::$idProductAbstractBuffer[$productAbstractSku])) {
            static::$idProductAbstractBuffer[$productAbstractSku] =
                SpyProductAbstractQuery::create()->findOneBySku($productAbstractSku)->getIdProductAbstract();
        }

        return static::$idProductAbstractBuffer[$productAbstractSku];
    }

    /**
     * @param string $storeName
     *
     * @return int
     */
    protected function getIdStoreByName($storeName): int
    {
        if (!isset(static::$idStoreBuffer[$storeName])) {
            static::$idStoreBuffer[$storeName] =
                SpyStoreQuery::create()->findOneByName($storeName)->getIdStore();
        }

        return static::$idStoreBuffer[$storeName];
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        DataImporterPublisher::triggerEvents();
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Generated\Shared\Transfer\ProductAbstractStoreTransfer
     */
    protected function getProductAbstractStoreTransfers(DataSetInterface $dataSet): ProductAbstractStoreTransfer
    {
        return $dataSet[ProductAbstractStoreHydratorStep::DATA_PRODUCT_ABSTRACT_STORE_ENTITY_TRANSFER];
    }
}
