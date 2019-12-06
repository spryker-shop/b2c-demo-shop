<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductStock\Writer;

use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Availability\Persistence\Map\SpyAvailabilityAbstractTableMap;
use Orm\Zed\Oms\Persistence\Map\SpyOmsProductReservationTableMap;
use Orm\Zed\Oms\Persistence\SpyOmsProductReservationQuery;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\Stock\Persistence\Map\SpyStockProductTableMap;
use Orm\Zed\Stock\Persistence\Map\SpyStockTableMap;
use Orm\Zed\Stock\Persistence\SpyStockProductQuery;
use Pyz\Zed\DataImport\Business\Model\DataFormatter\DataImportDataFormatterInterface;
use Pyz\Zed\DataImport\Business\Model\ProductStock\ProductStockHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\Sql\ProductStockSqlInterface;
use Pyz\Zed\DataImport\Business\Model\PropelExecutorInterface;
use Spryker\DecimalObject\Decimal;
use Spryker\Zed\Availability\Dependency\AvailabilityEvents;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface;
use Spryker\Zed\Stock\Business\StockFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class ProductStockBulkPdoDataSetWriter implements DataSetWriterInterface
{
    public const BULK_SIZE = 2000;
    protected const KEY_SKU = 'sku';
    protected const KEY_QUANTITY = 'qty';
    protected const KEY_IS_NEVER_OUT_OF_STOCK = 'is_never_out_of_stock';

    /**
     * @var array
     */
    protected static $stockCollection = [];

    /**
     * @var array
     */
    protected static $stockProductCollection = [];

    /**
     * @var array
     */
    protected static $storeToStock = [];

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository
     */
    protected $productRepository;

    /**
     * @var \Spryker\Zed\Stock\Business\StockFacadeInterface
     */
    protected $stockFacade;

    /**
     * @var \Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface
     */
    protected $productBundleFacade;

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\Sql\ProductStockSqlInterface
     */
    protected $productStockSql;

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\PropelExecutorInterface
     */
    protected $propelExecutor;

    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\DataFormatter\DataImportDataFormatterInterface
     */
    protected $dataFormatter;

    /**
     * @var int[]
     */
    protected $availabilityAbstractIds = [];

    /**
     * @param \Spryker\Zed\Stock\Business\StockFacadeInterface $stockFacade
     * @param \Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface $productBundleFacade
     * @param \Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\Sql\ProductStockSqlInterface $productStockSql
     * @param \Pyz\Zed\DataImport\Business\Model\PropelExecutorInterface $propelExecutor
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     * @param \Pyz\Zed\DataImport\Business\Model\DataFormatter\DataImportDataFormatterInterface $dataFormatter
     */
    public function __construct(
        StockFacadeInterface $stockFacade,
        ProductBundleFacadeInterface $productBundleFacade,
        ProductStockSqlInterface $productStockSql,
        PropelExecutorInterface $propelExecutor,
        StoreFacadeInterface $storeFacade,
        DataImportDataFormatterInterface $dataFormatter
    ) {
        $this->stockFacade = $stockFacade;
        $this->productBundleFacade = $productBundleFacade;
        $this->productStockSql = $productStockSql;
        $this->propelExecutor = $propelExecutor;
        $this->storeFacade = $storeFacade;
        $this->dataFormatter = $dataFormatter;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $this->collectStock($dataSet);
        $this->collectStockProduct($dataSet);
        if (count(static::$stockProductCollection) >= static::BULK_SIZE) {
            $this->writeEntities();
        }
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->writeEntities();
        $this->triggerAvailabilityPublishEvents();
    }

    /**
     * @return void
     */
    protected function writeEntities(): void
    {
        $this->persistStockEntities();
        $this->persistStockProductEntities();
        $this->persistAvailability();
        $this->flushMemory();
    }

    /**
     * @return void
     */
    protected function flushMemory(): void
    {
        static::$stockCollection = [];
        static::$stockProductCollection = [];
    }

    /**
     * @return void
     */
    protected function persistStockEntities(): void
    {
        $names = $this->dataFormatter->getCollectionDataByKey(static::$stockCollection, ProductStockHydratorStep::KEY_NAME);
        $uniqueNames = array_unique($names);
        $name = $this->dataFormatter->formatPostgresArrayString($uniqueNames);
        $sql = $this->productStockSql->createStockSQL();
        $parameters = [
            $name,
        ];
        $this->propelExecutor->execute($sql, $parameters);
    }

    /**
     * @return void
     */
    protected function persistStockProductEntities(): void
    {
        $sku = $this->dataFormatter->formatPostgresArrayString(
            $this->dataFormatter->getCollectionDataByKey(static::$stockProductCollection, ProductStockHydratorStep::KEY_CONCRETE_SKU)
        );
        $stockName = $this->dataFormatter->formatPostgresArray(
            $this->dataFormatter->getCollectionDataByKey(static::$stockCollection, ProductStockHydratorStep::KEY_NAME)
        );
        $quantity = $this->dataFormatter->formatPostgresArray(
            $this->dataFormatter->getCollectionDataByKey(static::$stockProductCollection, ProductStockHydratorStep::KEY_QUANTITY)
        );
        $isNeverOutOfStock = $this->dataFormatter->formatPostgresArray(
            $this->dataFormatter->getCollectionDataByKey(static::$stockProductCollection, ProductStockHydratorStep::KEY_IS_NEVER_OUT_OF_STOCK)
        );
        $sql = $this->productStockSql->createStockProductSQL();
        $parameters = [
            $sku,
            $stockName,
            $quantity,
            $isNeverOutOfStock,
        ];
        $this->propelExecutor->execute($sql, $parameters);
    }

    /**
     * @return void
     */
    protected function persistAvailability(): void
    {
        $skus = $this->dataFormatter->getCollectionDataByKey(static::$stockProductCollection, ProductStockHydratorStep::KEY_CONCRETE_SKU);
        $storeTransfer = $this->storeFacade->getCurrentStore();
        $concreteSkusToAbstractMap = $this->mapConcreteSkuToAbstractSku($skus);
        $reservationItems = $this->getReservationsBySkus($skus);
        $this->updateAvailability($skus, $storeTransfer, $concreteSkusToAbstractMap, $reservationItems);
        $sharedStores = $storeTransfer->getStoresWithSharedPersistence();
        foreach ($sharedStores as $storeName) {
            $storeTransfer = $this->storeFacade->getStoreByName($storeName);
            $this->updateAvailability($skus, $storeTransfer, $concreteSkusToAbstractMap, $reservationItems);
        }
        $this->updateBundleAvailability();
    }

    /**
     * @param array $skus
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param array $concreteSkusToAbstractMap
     * @param array $reservationItems
     *
     * @return void
     */
    protected function updateAvailability(array $skus, StoreTransfer $storeTransfer, array $concreteSkusToAbstractMap, array $reservationItems): void
    {
        $stockProductsForStore = $this->getStockProductBySkusAndStore($skus, $storeTransfer);
        $concreteAvailabilityData = $this->prepareConcreteAvailabilityData($stockProductsForStore, $reservationItems);
        $abstractAvailabilityData = $this->prepareAbstractAvailabilityData($concreteAvailabilityData, $concreteSkusToAbstractMap);
        $abstractAvailabilityQueryParams = [
            $this->dataFormatter->formatPostgresArrayString(array_column($abstractAvailabilityData, static::KEY_SKU)),
            $this->dataFormatter->formatPostgresArray(array_column($abstractAvailabilityData, static::KEY_QUANTITY)),
            $this->dataFormatter->formatPostgresArray(array_fill(0, count($abstractAvailabilityData), $storeTransfer->getIdStore())),
        ];
        $availabilityAbstractIds = $this->propelExecutor->execute($this->productStockSql->createAbstractAvailabilitySQL(), $abstractAvailabilityQueryParams);
        $this->collectAvailabilityAbstractIds($availabilityAbstractIds);
        $availabilityQueryParams = [
            $this->dataFormatter->formatPostgresArrayString(array_column($concreteAvailabilityData, static::KEY_SKU)),
            $this->dataFormatter->formatPostgresArray(array_column($concreteAvailabilityData, static::KEY_QUANTITY)),
            $this->dataFormatter->formatPostgresArrayBoolean(array_column($concreteAvailabilityData, static::KEY_IS_NEVER_OUT_OF_STOCK)),
            $this->dataFormatter->formatPostgresArray(array_fill(0, count($concreteAvailabilityData), $storeTransfer->getIdStore())),
        ];
        $this->propelExecutor->execute($this->productStockSql->createAvailabilitySQL(), $availabilityQueryParams);
    }

    /**
     * @param string[] $skus
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return array
     */
    protected function getStockProductBySkusAndStore(array $skus, StoreTransfer $storeTransfer): array
    {
        $stockProducts = SpyStockProductQuery::create()
            ->useSpyProductQuery()
            ->filterBySku_In($skus)
            ->endUse()
            ->leftJoinWithStock()
            ->select([
                SpyProductTableMap::COL_SKU,
                SpyStockProductTableMap::COL_QUANTITY,
                SpyStockProductTableMap::COL_IS_NEVER_OUT_OF_STOCK,
                SpyStockTableMap::COL_NAME,
            ])
            ->find()
            ->toArray();

        return $this->mapStockProducts($stockProducts, $storeTransfer);
    }

    /**
     * @param array $stockProducts
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return array
     */
    protected function mapStockProducts(array $stockProducts, StoreTransfer $storeTransfer): array
    {
        $stocks = $this->stockFacade->getStoreToWarehouseMapping();
        $result = [];
        foreach ($stockProducts as $stockProduct) {
            $sku = $stockProduct[SpyProductTableMap::COL_SKU];
            $result[$sku][static::KEY_SKU] = $sku;
            $result[$sku][static::KEY_IS_NEVER_OUT_OF_STOCK] = (bool)$stockProduct[SpyStockProductTableMap::COL_IS_NEVER_OUT_OF_STOCK];
            $quantity = '0';
            if (in_array($stockProduct[SpyStockTableMap::COL_NAME], $stocks[$storeTransfer->getName()])) {
                $quantity = $stockProduct[SpyStockProductTableMap::COL_QUANTITY];
            }
            $result[$sku][static::KEY_QUANTITY] = $quantity;
        }

        return $result;
    }

    /**
     * @param array $skus
     *
     * @return \Spryker\DecimalObject\Decimal[]
     */
    protected function getReservationsBySkus(array $skus): array
    {
        $reservations = SpyOmsProductReservationQuery::create()
            ->filterBySku_In($skus)
            ->select([
                SpyOmsProductReservationTableMap::COL_SKU,
                SpyOmsProductReservationTableMap::COL_RESERVATION_QUANTITY,
            ])
            ->find()
            ->toArray();
        $result = [];
        foreach ($reservations as $reservation) {
            $result[$reservation[SpyOmsProductReservationTableMap::COL_SKU]] = (new Decimal($result[$reservation[SpyOmsProductReservationTableMap::COL_SKU]] ?? '0'))->add($reservation[SpyOmsProductReservationTableMap::COL_RESERVATION_QUANTITY]);
        }

        return $result;
    }

    /**
     * @param array $skus
     *
     * @return array
     */
    protected function mapConcreteSkuToAbstractSku(array $skus): array
    {
        $abstractProducts = SpyProductAbstractQuery::create()
            ->useSpyProductQuery()
            ->filterBySku_In($skus)
            ->endUse()
            ->select([SpyProductTableMap::COL_SKU, SpyProductAbstractTableMap::COL_SKU])
            ->find()
            ->toArray();

        return array_combine(
            array_column($abstractProducts, SpyProductTableMap::COL_SKU),
            array_column($abstractProducts, SpyProductAbstractTableMap::COL_SKU)
        );
    }

    /**
     * @param array $stockProducts
     * @param array $reservations
     *
     * @return \Spryker\DecimalObject\Decimal[]
     */
    protected function prepareConcreteAvailabilityData(array $stockProducts, array $reservations): array
    {
        foreach ($stockProducts as $stock) {
            $sku = $stock[static::KEY_SKU];
            $quantity = (new Decimal($stock[static::KEY_QUANTITY]))->subtract($reservations[$sku] ?? 0);
            $stockProducts[$sku][static::KEY_QUANTITY] = $quantity->greatherThanOrEquals(0) ? $quantity : new Decimal(0);
        }

        return $stockProducts;
    }

    /**
     * @param array $concreteAvailabilityData
     * @param array $concreteSkusToAbstractMap
     *
     * @return array
     */
    protected function prepareAbstractAvailabilityData(array $concreteAvailabilityData, array $concreteSkusToAbstractMap): array
    {
        $abstractAvailabilityData = [];
        foreach ($concreteAvailabilityData as $concreteAvailability) {
            $abstractSku = $concreteSkusToAbstractMap[$concreteAvailability[static::KEY_SKU]] ?? null;
            if (!$abstractSku) {
                continue;
            }
            $abstractAvailabilityData[$abstractSku][static::KEY_SKU] = $abstractSku;
            $abstractAvailabilityData[$abstractSku][static::KEY_QUANTITY] = (new Decimal($abstractAvailabilityData[$abstractSku][static::KEY_QUANTITY] ?? 0))->add($concreteAvailability[static::KEY_QUANTITY]);
        }

        return $abstractAvailabilityData;
    }

    /**
     * @return void
     */
    protected function updateBundleAvailability(): void
    {
        foreach (static::$stockProductCollection as $stockProduct) {
            if (!$stockProduct[ProductStockHydratorStep::KEY_IS_BUNDLE]) {
                continue;
            }
            $this->productBundleFacade->updateBundleAvailability($stockProduct[ProductStockHydratorStep::KEY_CONCRETE_SKU]);
            $this->productBundleFacade->updateAffectedBundlesAvailability($stockProduct[ProductStockHydratorStep::KEY_CONCRETE_SKU]);
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function collectStock(DataSetInterface $dataSet): void
    {
        static::$stockCollection[] = $dataSet[ProductStockHydratorStep::STOCK_ENTITY_TRANSFER]->modifiedToArray();
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function collectStockProduct(DataSetInterface $dataSet): void
    {
        $productStockArray = $dataSet[ProductStockHydratorStep::STOCK_PRODUCT_ENTITY_TRANSFER]->modifiedToArray();
        $productStockArray[ProductStockHydratorStep::KEY_IS_BUNDLE] = $dataSet[ProductStockHydratorStep::KEY_IS_BUNDLE];
        $productStockArray[ProductStockHydratorStep::KEY_CONCRETE_SKU] = $dataSet[ProductStockHydratorStep::KEY_CONCRETE_SKU];
        static::$stockProductCollection[] = $productStockArray;
    }

    /**
     * @return array
     */
    protected function getStoreToWarehouse(): array
    {
        if (empty(static::$storeToStock)) {
            $storeToWarehouse = [];
            $warehouseToStore = $this->stockFacade->getWarehouseToStoreMapping();
            foreach ($warehouseToStore as $warehouse => $stores) {
                foreach ($stores as $store) {
                    $storeToWarehouse[$store][$warehouse] = $warehouse;
                }
            }
            static::$storeToStock = $storeToWarehouse;
        }

        return static::$storeToStock;
    }

    /**
     * @param int[] $availabilityAbstractIds
     *
     * @return void
     */
    protected function collectAvailabilityAbstractIds(array $availabilityAbstractIds): void
    {
        $availabilityAbstractIds = array_merge(
            $this->availabilityAbstractIds,
            array_column($availabilityAbstractIds, SpyAvailabilityAbstractTableMap::COL_ID_AVAILABILITY_ABSTRACT)
        );
        $this->availabilityAbstractIds = array_unique($availabilityAbstractIds);
    }

    /**
     * @return void
     */
    protected function triggerAvailabilityPublishEvents(): void
    {
        foreach ($this->availabilityAbstractIds as $availabilityAbstractId) {
            DataImporterPublisher::addEvent(AvailabilityEvents::AVAILABILITY_ABSTRACT_PUBLISH, $availabilityAbstractId);
        }
    }
}
