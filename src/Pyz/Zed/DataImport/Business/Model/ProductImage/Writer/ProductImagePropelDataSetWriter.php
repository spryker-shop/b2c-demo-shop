<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model\ProductImage\Writer;

use Generated\Shared\Transfer\SpyProductImageEntityTransfer;
use Generated\Shared\Transfer\SpyProductImageSetEntityTransfer;
use Generated\Shared\Transfer\SpyProductImageSetToProductImageEntityTransfer;
use Orm\Zed\Glossary\Persistence\SpyGlossaryKeyQuery;
use Orm\Zed\Glossary\Persistence\SpyGlossaryTranslationQuery;
use Orm\Zed\ProductImage\Persistence\SpyProductImage;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSet;
use Pyz\Zed\DataImport\Business\Model\ProductImage\ProductImageHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductImage\Repository\ProductImageRepositoryInterface;
use Spryker\Shared\GlossaryStorage\GlossaryStorageConfig;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\LocalizedAttributesExtractorStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\Product\Dependency\ProductEvents;
use Spryker\Zed\ProductImage\Dependency\ProductImageEvents;

class ProductImagePropelDataSetWriter implements DataSetWriterInterface
{
    /**
     * @var string
     */
    public const KEY_ALT_TEXT_SMALL = 'alt_text_small';

    /**
     * @var string
     */
    public const KEY_ALT_TEXT_LARGE = 'alt_text_large';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_PREFIX = 'product_image';

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\ProductImage\Repository\ProductImageRepositoryInterface
     */
    protected $productImageRepository;

    public function __construct(ProductImageRepositoryInterface $productImageRepository)
    {
        $this->productImageRepository = $productImageRepository;
    }

    public function write(DataSetInterface $dataSet): void
    {
        $productImageSetEntity = $this->createOrUpdateProductImageSet($dataSet);
        $productImageEntity = $this->createOrUpdateProductImage($dataSet, $productImageSetEntity);
        $this->createOrUpdateProductImageAltTexts($dataSet, $productImageEntity, $productImageSetEntity);
        $this->createOrUpdateImageToImageSetRelation($productImageSetEntity, $productImageEntity, $dataSet);
    }

    public function flush(): void
    {
        DataImporterPublisher::triggerEvents();
    }

    protected function createOrUpdateProductImageSet(DataSetInterface $dataSet): SpyProductImageSet
    {
        $productImageSetEntityTransfer = $this->getProductImageSetTransfer($dataSet);
        $productImageSetEntity = $this->productImageRepository->getProductImageSetEntity(
            $productImageSetEntityTransfer->getName(),
            $productImageSetEntityTransfer->getFkLocale(),
            (int)$productImageSetEntityTransfer->getFkProductAbstract(),
            (int)$productImageSetEntityTransfer->getFkProduct(),
            $productImageSetEntityTransfer->getProductImageSetKey(),
        );

        if ($productImageSetEntity->isNew() || $productImageSetEntity->isModified()) {
            $productImageSetEntity->save();

            $this->addImagePublishEvents($productImageSetEntity);
        }

        return $productImageSetEntity;
    }

    protected function createOrUpdateProductImage(
        DataSetInterface $dataSet,
        SpyProductImageSet $productImageSetEntity,
    ): SpyProductImage {
        $productImageEntityTransfer = $this->getProductImageTransfer($dataSet);
        $productImageEntity = $this->findOrCreateProductImageEntityByProductImageKey(
            $productImageEntityTransfer->getProductImageKey(),
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

    protected function createOrUpdateImageToImageSetRelation(
        SpyProductImageSet $productImageSetEntity,
        SpyProductImage $productImageEntity,
        DataSetInterface $dataSet,
    ): void {
        $productImageSetToProductImageEntity = $this->productImageRepository->getProductImageSetToProductImageRelationEntity(
            $productImageSetEntity->getIdProductImageSet(),
            $productImageEntity->getIdProductImage(),
        );

        $productImageToImageSetRelationTransfer = $this->getProductImageToImageSetRelationTransfer($dataSet);
        $productImageSetToProductImageEntity->setSortOrder($productImageToImageSetRelationTransfer->getSortOrder());

        if (!$productImageSetToProductImageEntity->isNew() && !$productImageSetToProductImageEntity->isModified()) {
            return;
        }

        $productImageSetToProductImageEntity->save();

        $this->addImagePublishEvents($productImageSetEntity);
    }

    protected function saveProductImageAltTextGlossaryKeys(SpyProductImage $productImageEntity): SpyProductImage
    {
        $altTextLargeGlossaryKey = sprintf(
            '%s.%s.%s',
            static::GLOSSARY_KEY_PREFIX,
            $productImageEntity->getIdProductImage(),
            static::KEY_ALT_TEXT_LARGE,
        );
        $altTextSmallGlossaryKey = sprintf(
            '%s.%s.%s',
            static::GLOSSARY_KEY_PREFIX,
            $productImageEntity->getIdProductImage(),
            static::KEY_ALT_TEXT_SMALL,
        );
        $productImageEntity->setAltTextLarge($altTextLargeGlossaryKey)
            ->setAltTextSmall($altTextSmallGlossaryKey)
            ->save();

        return $productImageEntity;
    }

    protected function createOrUpdateProductImageAltTexts(
        DataSetInterface $dataSet,
        SpyProductImage $productImageEntity,
        SpyProductImageSet $productImageSetEntity,
    ): void {
        if (!$productImageEntity->getAltTextLarge() || !$productImageEntity->getAltTextSmall()) {
            $productImageEntity = $this->saveProductImageAltTextGlossaryKeys($productImageEntity);
            $this->addImagePublishEvents($productImageSetEntity);
        }

        foreach ($dataSet[LocalizedAttributesExtractorStep::KEY_LOCALIZED_ATTRIBUTES] as $idLocale => $localizedAttributes) {
            if ($productImageSetEntity->getFkLocale() && $productImageSetEntity->getFkLocale() !== $idLocale) {
                continue;
            }

            $this->createOrUpdateGlossaryKey(
                $productImageEntity->getAltTextSmall(),
                $idLocale,
                $localizedAttributes[static::KEY_ALT_TEXT_SMALL],
            );
            $this->createOrUpdateGlossaryKey(
                $productImageEntity->getAltTextLarge(),
                $idLocale,
                $localizedAttributes[static::KEY_ALT_TEXT_LARGE],
            );
        }
    }

    protected function createOrUpdateGlossaryKey(
        string $glossaryKey,
        int $idLocale,
        string $value,
    ): void {
        $glossaryKeyEntity = SpyGlossaryKeyQuery::create()
            ->filterByKey($glossaryKey)
            ->findOneOrCreate();
        $glossaryKeyEntity->save();
        $glossaryTranslationEntity = SpyGlossaryTranslationQuery::create()
            ->filterByGlossaryKey($glossaryKeyEntity)
            ->filterByFkLocale($idLocale)
            ->findOneOrCreate();
        $glossaryTranslationEntity->setValue($value);

        if (!$glossaryTranslationEntity->isNew() && !$glossaryTranslationEntity->isModified()) {
            return;
        }

        $glossaryTranslationEntity->save();
        DataImporterPublisher::addEvent(
            GlossaryStorageConfig::GLOSSARY_KEY_PUBLISH_WRITE,
            $glossaryTranslationEntity->getFkGlossaryKey(),
        );
        DataImporterPublisher::addEvent(
            GlossaryStorageConfig::PUBLISH_TRANSLATION,
            $glossaryTranslationEntity->getIdGlossaryTranslation(),
        );
    }

    protected function getProductImageTransfer(DataSetInterface $dataSet): SpyProductImageEntityTransfer
    {
        return $dataSet[ProductImageHydratorStep::DATA_PRODUCT_IMAGE_TRANSFER];
    }

    protected function getProductImageSetTransfer(DataSetInterface $dataSet): SpyProductImageSetEntityTransfer
    {
        return $dataSet[ProductImageHydratorStep::DATA_PRODUCT_IMAGE_SET_TRANSFER];
    }

    protected function getProductImageToImageSetRelationTransfer(
        DataSetInterface $dataSet,
    ): SpyProductImageSetToProductImageEntityTransfer {
        return $dataSet[ProductImageHydratorStep::DATA_PRODUCT_IMAGE_TO_IMAGE_SET_RELATION_TRANSFER];
    }

    protected function addImagePublishEvents(SpyProductImageSet $productImageSetEntity): void
    {
        if ($productImageSetEntity->getFkProductAbstract()) {
            DataImporterPublisher::addEvent(
                ProductImageEvents::PRODUCT_IMAGE_PRODUCT_ABSTRACT_PUBLISH,
                $productImageSetEntity->getFkProductAbstract(),
            );
            DataImporterPublisher::addEvent(
                ProductEvents::PRODUCT_ABSTRACT_PUBLISH,
                $productImageSetEntity->getFkProductAbstract(),
            );
        } elseif ($productImageSetEntity->getFkProduct()) {
            DataImporterPublisher::addEvent(
                ProductImageEvents::PRODUCT_IMAGE_PRODUCT_CONCRETE_PUBLISH,
                $productImageSetEntity->getFkProduct(),
            );
        }
    }

    protected function findOrCreateProductImageEntityByProductImageKey(string $productImageKey): SpyProductImage
    {
        return $this->productImageRepository->getProductImageEntity($productImageKey);
    }
}
