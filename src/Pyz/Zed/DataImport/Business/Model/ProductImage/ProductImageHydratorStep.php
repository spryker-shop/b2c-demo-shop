<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductImage;

use Generated\Shared\Transfer\SpyLocaleEntityTransfer;
use Generated\Shared\Transfer\SpyProductImageEntityTransfer;
use Generated\Shared\Transfer\SpyProductImageSetEntityTransfer;
use Generated\Shared\Transfer\SpyProductImageSetToProductImageEntityTransfer;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class ProductImageHydratorStep extends PublishAwareStep implements DataImportStepInterface
{
    public const BULK_SIZE = 5000;

    public const COLUMN_ABSTRACT_SKU = 'abstract_sku';
    public const COLUMN_CONCRETE_SKU = 'concrete_sku';
    public const COLUMN_IMAGE_SET_NAME = 'image_set_name';
    public const COLUMN_EXTERNAL_URL_LARGE = 'external_url_large';
    public const COLUMN_EXTERNAL_URL_SMALL = 'external_url_small';
    public const COLUMN_LOCALE = 'locale';
    public const COLUMN_SORT_ORDER = 'sort_order';
    public const COLUMN_PRODUCT_IMAGE_KEY = 'product_image_key';
    public const COLUMN_PRODUCT_IMAGE_SET_KEY = 'product_image_set_key';

    public const KEY_IMAGE_SET_FK_PRODUCT = 'fk_product';
    public const KEY_IMAGE_SET_FK_PRODUCT_ABSTRACT = 'fk_product_abstract';

    public const KEY_ID_LOCALE = 'id_locale';
    public const KEY_SPY_LOCALE = 'spy_locale';
    public const KEY_LOCALE_NAME = 'locale_name';
    public const KEY_IMAGE_SET_DB_NAME_COLUMN = 'name';
    public const KEY_IMAGE_SET_RELATION_ID_PRODUCT_IMAGE_SET = 'id_product_image_set';
    public const KEY_IMAGE_SET_RELATION_ID_PRODUCT_IMAGE = 'id_product_image';
    public const KEY_IMAGE_SET_FK_RESOURCE_PRODUCT_SET = 'fk_resource_product_set';
    public const KEY_IMAGE_SET_FK_LOCALE = 'fk_locale';
    public const KEY_ID_PRODUCT = 'id_product';
    public const KEY_FK_PRODUCT = 'fk_product';
    public const KEY_ID_PRODUCT_ABSTRACT = 'id_product_abstract';
    public const KEY_FK_PRODUCT_ABSTRACT = 'fk_product_abstract';
    public const IMAGE_TO_IMAGE_SET_RELATION_ORDER = 0;
    public const DATA_PRODUCT_IMAGE_SET_TRANSFER = 'DATA_PRODUCT_IMAGE_SET_TRANSFER';
    public const DATA_PRODUCT_IMAGE_TRANSFER = 'DATA_PRODUCT_IMAGE_TRANSFER';
    public const DATA_PRODUCT_IMAGE_TO_IMAGE_SET_RELATION_TRANSFER = 'DATA_PRODUCT_IMAGE_TO_IMAGE_SET_RELATION_TRANSFER';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $this->importImageSet($dataSet);
        $this->importImage($dataSet);
        $this->importImageToImageSetRelation($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importImageSet(DataSetInterface $dataSet): void
    {
        $imageSetEntityTransfer = new SpyProductImageSetEntityTransfer();
        $imageSetEntityTransfer->setName($dataSet[static::COLUMN_IMAGE_SET_NAME]);

        if (!empty($dataSet[static::KEY_IMAGE_SET_FK_PRODUCT_ABSTRACT])) {
            $imageSetEntityTransfer->setFkProductAbstract($dataSet[static::KEY_IMAGE_SET_FK_PRODUCT_ABSTRACT]);
            $imageSetEntityTransfer->setFkProduct(null);
        }

        if (!empty($dataSet[static::KEY_IMAGE_SET_FK_PRODUCT])) {
            $imageSetEntityTransfer->setFkProduct($dataSet[static::KEY_IMAGE_SET_FK_PRODUCT]);
            $imageSetEntityTransfer->setFkProductAbstract(null);
        }

        if (!empty($dataSet[static::COLUMN_PRODUCT_IMAGE_SET_KEY])) {
            $imageSetEntityTransfer->setProductImageSetKey($dataSet[static::COLUMN_PRODUCT_IMAGE_SET_KEY]);
        }

        if (isset($dataSet[static::KEY_IMAGE_SET_FK_LOCALE])) {
            $imageSetEntityTransfer->setFkLocale($dataSet[static::KEY_IMAGE_SET_FK_LOCALE]);
            $dataSet[static::DATA_PRODUCT_IMAGE_SET_TRANSFER] = $imageSetEntityTransfer;

            return;
        }

        $localeEntityTransfer = (new SpyLocaleEntityTransfer())
            ->setLocaleName($dataSet[static::COLUMN_LOCALE]);

        $imageSetEntityTransfer->setSpyLocale($localeEntityTransfer);

        $dataSet[static::DATA_PRODUCT_IMAGE_SET_TRANSFER] = $imageSetEntityTransfer;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importImage(DataSetInterface $dataSet): void
    {
        $imageEntityTransfer = new SpyProductImageEntityTransfer();
        $imageEntityTransfer->setExternalUrlLarge($dataSet[static::COLUMN_EXTERNAL_URL_LARGE]);
        $imageEntityTransfer->setExternalUrlSmall($dataSet[static::COLUMN_EXTERNAL_URL_SMALL]);
        $imageEntityTransfer->setProductImageKey($dataSet[static::COLUMN_PRODUCT_IMAGE_KEY]);

        $dataSet[static::DATA_PRODUCT_IMAGE_TRANSFER] = $imageEntityTransfer;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importImageToImageSetRelation(DataSetInterface $dataSet): void
    {
        $imageToImageSetRelationEntityTransfer = new SpyProductImageSetToProductImageEntityTransfer();
        $imageToImageSetRelationEntityTransfer->setSortOrder($this->getSortOrder($dataSet));

        $dataSet[static::DATA_PRODUCT_IMAGE_TO_IMAGE_SET_RELATION_TRANSFER] = $imageToImageSetRelationEntityTransfer;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return int
     */
    protected function getSortOrder(DataSetInterface $dataSet): int
    {
        if (isset($dataSet[static::COLUMN_SORT_ORDER]) && $dataSet[static::COLUMN_SORT_ORDER] >= 0) {
            return (int)$dataSet[static::COLUMN_SORT_ORDER];
        }

        return static::IMAGE_TO_IMAGE_SET_RELATION_ORDER;
    }
}
