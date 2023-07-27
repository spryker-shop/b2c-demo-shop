<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer;

use Generated\Shared\Transfer\EventEntityTransfer;
use Generated\Shared\Transfer\SpyProductEntityTransfer;
use Generated\Shared\Transfer\SpyProductSearchEntityTransfer;
use Orm\Zed\Product\Persistence\SpyProduct;
use Orm\Zed\Product\Persistence\SpyProductLocalizedAttributesQuery;
use Orm\Zed\Product\Persistence\SpyProductQuery;
use Orm\Zed\ProductBundle\Persistence\SpyProductBundleQuery;
use Orm\Zed\ProductSearch\Persistence\Map\SpyProductSearchTableMap;
use Orm\Zed\ProductSearch\Persistence\SpyProductSearch;
use Orm\Zed\ProductSearch\Persistence\SpyProductSearchQuery;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteHydratorStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\Product\Dependency\ProductEvents;
use Spryker\Zed\ProductSearch\Dependency\ProductSearchEvents;

class ProductConcretePropelDataSetWriter implements DataSetWriterInterface
{
    /**
     * @uses \Spryker\Shared\ProductBundleStorage\ProductBundleStorageConfig::PRODUCT_BUNDLE_PUBLISH
     *
     * @var string
     */
    protected const PRODUCT_BUNDLE_PUBLISH = 'ProductBundle.product_bundle.publish.write';

    protected const COLUMN_ABSTRACT_SKU = ProductConcreteHydratorStep::COLUMN_ABSTRACT_SKU;

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $productConcreteEntity = $this->createOrUpdateProductConcrete($dataSet);

        $this->productRepository->addProductConcrete(
            $productConcreteEntity,
            $dataSet[static::COLUMN_ABSTRACT_SKU],
        );

        $this->createOrUpdateProductConcreteLocalizedAttributesEntities($dataSet, $productConcreteEntity->getIdProduct());
        $this->createOrUpdateBundles($dataSet, $productConcreteEntity->getIdProduct());
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
     * @return \Orm\Zed\Product\Persistence\SpyProduct
     */
    protected function createOrUpdateProductConcrete(DataSetInterface $dataSet): SpyProduct
    {
        $idAbstract = $this
            ->productRepository
            ->getIdProductAbstractByAbstractSku($dataSet[static::COLUMN_ABSTRACT_SKU]);

        $productConcreteEntityTransfer = $this->getProductConcreteTransfer($dataSet);
        $productConcreteEntityTransfer->setFkProductAbstract($idAbstract);

        $productConcreteEntity = SpyProductQuery::create()
            ->filterBySku($productConcreteEntityTransfer->getSku())
            ->findOneOrCreate();

        $fkProductAbstract = $productConcreteEntity->getFkProductAbstract();

        $productConcreteEntity->fromArray($productConcreteEntityTransfer->modifiedToArray());

        if ($productConcreteEntity->isNew() || $productConcreteEntity->isModified()) {
            $productConcreteEntity->save();
            DataImporterPublisher::addEvent(ProductEvents::PRODUCT_CONCRETE_PUBLISH, $productConcreteEntity->getIdProduct());

            if ($fkProductAbstract !== $idAbstract) {
                DataImporterPublisher::addEvent(ProductEvents::PRODUCT_ABSTRACT_PUBLISH, $fkProductAbstract);
                DataImporterPublisher::addEvent(ProductEvents::PRODUCT_ABSTRACT_PUBLISH, $idAbstract);
            }
        }

        return $productConcreteEntity;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param int $idProduct
     *
     * @return void
     */
    protected function createOrUpdateBundles(DataSetInterface $dataSet, int $idProduct): void
    {
        $productBundleData = $this->getProductConcreteBundleData($dataSet);

        foreach ($productBundleData as $productBundle) {
            $bundledProductId = $this
                ->productRepository
                ->getIdProductByConcreteSku($productBundle[ProductConcreteHydratorStep::KEY_PRODUCT_BUNDLE_SKU]);

            $productBundleEntity = SpyProductBundleQuery::create()
                ->filterByFkProduct($idProduct)
                ->filterByFkBundledProduct($bundledProductId)
                ->findOneOrCreate();
            $productBundleEntity->fromArray($productBundle[ProductConcreteHydratorStep::KEY_PRODUCT_BUNDLE_TRANSFER]->modifiedToArray());

            if ($productBundleEntity->isNew() || $productBundleEntity->isModified()) {
                $productBundleEntity->save();
            }
        }

        if ($productBundleData) {
            DataImporterPublisher::addEvent(static::PRODUCT_BUNDLE_PUBLISH, $idProduct);
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param int $idProduct
     *
     * @return void
     */
    protected function createOrUpdateProductConcreteLocalizedAttributesEntities(
        DataSetInterface $dataSet,
        int $idProduct,
    ): void {
        $productConcreteLocalizedTransfers = $this->getProductConcreteLocalizedTransfers($dataSet);

        foreach ($productConcreteLocalizedTransfers as $productConcreteLocalizedArray) {
            $productConcreteLocalizedTransfer = $productConcreteLocalizedArray[ProductConcreteHydratorStep::KEY_PRODUCT_CONCRETE_LOCALIZED_TRANSFER];
            $productSearchEntityTransfer = $productConcreteLocalizedArray[ProductConcreteHydratorStep::KEY_PRODUCT_SEARCH_TRANSFER];

            $productConcreteLocalizedAttributesEntity = SpyProductLocalizedAttributesQuery::create()
                ->filterByFkProduct($idProduct)
                ->filterByFkLocale($productConcreteLocalizedTransfer->getFkLocale())
                ->findOneOrCreate();
            $productConcreteLocalizedAttributesEntity->fromArray($productConcreteLocalizedTransfer->modifiedToArray());

            if ($productConcreteLocalizedAttributesEntity->isNew() || $productConcreteLocalizedAttributesEntity->isModified()) {
                $productConcreteLocalizedAttributesEntity->save();
            }

            $this->createOrUpdateProductConcreteSearchEntities($idProduct, $productSearchEntityTransfer);
        }
    }

    /**
     * @param int $idProduct
     * @param \Generated\Shared\Transfer\SpyProductSearchEntityTransfer $productSearchEntityTransfer
     *
     * @return void
     */
    protected function createOrUpdateProductConcreteSearchEntities(
        int $idProduct,
        SpyProductSearchEntityTransfer $productSearchEntityTransfer,
    ): void {
        $productSearchEntity = SpyProductSearchQuery::create()
            ->filterByFkProduct($idProduct)
            ->filterByFkLocale($productSearchEntityTransfer->getFkLocale())
            ->findOneOrCreate();
        $productSearchEntity->fromArray($productSearchEntityTransfer->modifiedToArray());

        $isNewProductSearchEntity = $productSearchEntity->isNew();
        if ($isNewProductSearchEntity || $productSearchEntity->isModified()) {
            $productSearchEntity->save();
            $eventEntityTransfer = $this->mapProductSearchEntityToEventEntityTransfer(
                $productSearchEntity,
                $isNewProductSearchEntity,
                new EventEntityTransfer(),
            );
            DataImporterPublisher::addEvent($eventEntityTransfer->getEvent(), $eventEntityTransfer->getId(), $eventEntityTransfer);
        }
    }

    /**
     * @param \Orm\Zed\ProductSearch\Persistence\SpyProductSearch $productSearchEntity
     * @param bool $isNewProductSearchEntity
     * @param \Generated\Shared\Transfer\EventEntityTransfer $eventEntityTransfer
     *
     * @return \Generated\Shared\Transfer\EventEntityTransfer
     */
    protected function mapProductSearchEntityToEventEntityTransfer(
        SpyProductSearch $productSearchEntity,
        bool $isNewProductSearchEntity,
        EventEntityTransfer $eventEntityTransfer,
    ): EventEntityTransfer {
        return $eventEntityTransfer
            ->setId($productSearchEntity->getIdProductSearch())
            ->setEvent(
                $isNewProductSearchEntity
                    ? ProductSearchEvents::ENTITY_SPY_PRODUCT_SEARCH_CREATE
                    : ProductSearchEvents::ENTITY_SPY_PRODUCT_SEARCH_UPDATE,
            )
            ->setName(SpyProductSearchTableMap::TABLE_NAME)
            ->setForeignKeys([
                SpyProductSearchTableMap::COL_FK_PRODUCT => $productSearchEntity->getFkProduct(),
                SpyProductSearchTableMap::COL_FK_LOCALE => $productSearchEntity->getFkLocale(),
            ])
            ->setModifiedColumns([
                SpyProductSearchTableMap::COL_IS_SEARCHABLE,
            ]);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return array<string, mixed>
     */
    protected function getProductConcreteBundleData(DataSetInterface $dataSet): array
    {
        return $dataSet[ProductConcreteHydratorStep::DATA_PRODUCT_BUNDLE_TRANSFER] ?? [];
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return array<string, mixed>
     */
    protected function getProductConcreteLocalizedTransfers(DataSetInterface $dataSet): array
    {
        return $dataSet[ProductConcreteHydratorStep::DATA_PRODUCT_CONCRETE_LOCALIZED_TRANSFER] ?? [];
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Generated\Shared\Transfer\SpyProductEntityTransfer
     */
    protected function getProductConcreteTransfer(DataSetInterface $dataSet): SpyProductEntityTransfer
    {
        return $dataSet[ProductConcreteHydratorStep::DATA_PRODUCT_CONCRETE_TRANSFER];
    }
}
