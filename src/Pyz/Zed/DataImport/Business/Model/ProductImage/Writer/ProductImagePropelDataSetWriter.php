<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductImage\Writer;

use Generated\Shared\Transfer\SpyProductImageEntityTransfer;
use Generated\Shared\Transfer\SpyProductImageSetEntityTransfer;
use Generated\Shared\Transfer\SpyProductImageSetToProductImageEntityTransfer;
use Orm\Zed\ProductImage\Persistence\SpyProductImage;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSet;
use Pyz\Zed\DataImport\Business\Model\ProductImage\ProductImageHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductImage\Repository\ProductImageRepositoryInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\Product\Dependency\ProductEvents;
use Spryker\Zed\ProductImage\Dependency\ProductImageEvents;

class ProductImagePropelDataSetWriter implements DataSetWriterInterface
{
    /**
     * @var \Pyz\Zed\DataImport\Business\Model\ProductImage\Repository\ProductImageRepositoryInterface
     */
    protected $productImageRepository;

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\ProductImage\Repository\ProductImageRepositoryInterface $productImageRepository
     */
    public function __construct(ProductImageRepositoryInterface $productImageRepository)
    {
        $this->productImageRepository = $productImageRepository;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $productImageSetEntity = $this->createOrUpdateProductImageSet($dataSet);
        $productImageEntity = $this->createOrUpdateProductImage($dataSet, $productImageSetEntity);
        $this->createOrUpdateImageToImageSetRelation($productImageSetEntity, $productImageEntity, $dataSet);
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
     * @return \Orm\Zed\ProductImage\Persistence\SpyProductImageSet
     */
    protected function createOrUpdateProductImageSet(DataSetInterface $dataSet): SpyProductImageSet
    {
        $productImageSetEntityTransfer = $this->getProductImageSetTransfer($dataSet);
        $productImageSetEntity = $this->productImageRepository->getProductImageSetEntity(
            $productImageSetEntityTransfer->getName(),
            $productImageSetEntityTransfer->getFkLocale(),
            (int)$productImageSetEntityTransfer->getFkProductAbstract(),
            (int)$productImageSetEntityTransfer->getFkProduct(),
            $productImageSetEntityTransfer->getProductImageSetKey()
        );

        if ($productImageSetEntity->isNew() || $productImageSetEntity->isModified()) {
            $productImageSetEntity->save();

            $this->addImagePublishEvents($productImageSetEntity);
        }

        return $productImageSetEntity;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param \Orm\Zed\ProductImage\Persistence\SpyProductImageSet $productImageSetEntity
     *
     * @return \Orm\Zed\ProductImage\Persistence\SpyProductImage
     */
    protected function createOrUpdateProductImage(
        DataSetInterface $dataSet,
        SpyProductImageSet $productImageSetEntity
    ): SpyProductImage {
        $productImageEntityTransfer = $this->getProductImageTransfer($dataSet);
        $productImageEntity = $this->findOrCreateProductImageEntityByProductImageKey(
            $productImageEntityTransfer->getProductImageKey()
        );

        $productImageEntity->setExternalUrlLarge($productImageEntityTransfer->getExternalUrlLarge());
        $productImageEntity->setExternalUrlSmall($productImageEntityTransfer->getExternalUrlSmall());
        $productImageEntity->setProductImageKey($productImageEntityTransfer->getProductImageKey());

        if ($productImageEntity->isNew() || $productImageEntity->isModified()) {
            $productImageEntity->save();

            $this->addImagePublishEvents($productImageSetEntity);
        }

        return $productImageEntity;
    }

    /**
     * @param \Orm\Zed\ProductImage\Persistence\SpyProductImageSet $productImageSetEntity
     * @param \Orm\Zed\ProductImage\Persistence\SpyProductImage $productImageEntity
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function createOrUpdateImageToImageSetRelation(
        SpyProductImageSet $productImageSetEntity,
        SpyProductImage $productImageEntity,
        DataSetInterface $dataSet
    ): void {
        $productImageSetToProductImageEntity = $this->productImageRepository->getProductImageSetToProductImageRelationEntity(
            $productImageSetEntity->getIdProductImageSet(),
            $productImageEntity->getIdProductImage()
        );

        $productImageToImageSetRelationTransfer = $this->getProductImageToImageSetRelationTransfer($dataSet);
        $productImageSetToProductImageEntity->setSortOrder($productImageToImageSetRelationTransfer->getSortOrder());

        if ($productImageSetToProductImageEntity->isNew() || $productImageSetToProductImageEntity->isModified()) {
            $productImageSetToProductImageEntity->save();

            $this->addImagePublishEvents($productImageSetEntity);
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Generated\Shared\Transfer\SpyProductImageEntityTransfer
     */
    protected function getProductImageTransfer(DataSetInterface $dataSet): SpyProductImageEntityTransfer
    {
        return $dataSet[ProductImageHydratorStep::DATA_PRODUCT_IMAGE_TRANSFER];
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Generated\Shared\Transfer\SpyProductImageSetEntityTransfer
     */
    protected function getProductImageSetTransfer(DataSetInterface $dataSet): SpyProductImageSetEntityTransfer
    {
        return $dataSet[ProductImageHydratorStep::DATA_PRODUCT_IMAGE_SET_TRANSFER];
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Generated\Shared\Transfer\SpyProductImageSetToProductImageEntityTransfer
     */
    protected function getProductImageToImageSetRelationTransfer(
        DataSetInterface $dataSet
    ): SpyProductImageSetToProductImageEntityTransfer {
        return $dataSet[ProductImageHydratorStep::DATA_PRODUCT_IMAGE_TO_IMAGE_SET_RELATION_TRANSFER];
    }

    /**
     * @param \Orm\Zed\ProductImage\Persistence\SpyProductImageSet $productImageSetEntity
     *
     * @return void
     */
    protected function addImagePublishEvents(SpyProductImageSet $productImageSetEntity): void
    {
        if ($productImageSetEntity->getFkProductAbstract()) {
            DataImporterPublisher::addEvent(
                ProductImageEvents::PRODUCT_IMAGE_PRODUCT_ABSTRACT_PUBLISH,
                $productImageSetEntity->getFkProductAbstract()
            );
            DataImporterPublisher::addEvent(
                ProductEvents::PRODUCT_ABSTRACT_PUBLISH,
                $productImageSetEntity->getFkProductAbstract()
            );
        } elseif ($productImageSetEntity->getFkProduct()) {
            DataImporterPublisher::addEvent(
                ProductImageEvents::PRODUCT_IMAGE_PRODUCT_CONCRETE_PUBLISH,
                $productImageSetEntity->getFkProduct()
            );
        }
    }

    /**
     * @param string $productImageKey
     *
     * @return \Orm\Zed\ProductImage\Persistence\SpyProductImage
     */
    protected function findOrCreateProductImageEntityByProductImageKey(string $productImageKey): SpyProductImage
    {
        return $this->productImageRepository->getProductImageEntity($productImageKey);
    }
}
