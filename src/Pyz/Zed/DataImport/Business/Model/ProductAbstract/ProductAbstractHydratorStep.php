<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductAbstract;

use Generated\Shared\Transfer\SpyProductAbstractEntityTransfer;
use Generated\Shared\Transfer\SpyProductAbstractLocalizedAttributesEntityTransfer;
use Generated\Shared\Transfer\SpyProductCategoryEntityTransfer;
use Generated\Shared\Transfer\SpyUrlEntityTransfer;
use Pyz\Zed\DataImport\Business\Model\Product\ProductLocalizedAttributesExtractorStep;
use Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class ProductAbstractHydratorStep implements DataImportStepInterface
{
    public const BULK_SIZE = 5000;

    public const COLUMN_ABSTRACT_SKU = 'abstract_sku';

    public const COLUMN_CATEGORY_KEY = 'category_key';
    public const COLUMN_CATEGORY_PRODUCT_ORDER = 'category_product_order';
    public const COLUMN_NAME = 'name';
    public const COLUMN_URL = 'url';
    public const COLUMN_COLOR_CODE = 'color_code';
    public const COLUMN_DESCRIPTION = 'description';
    public const COLUMN_TAX_SET_NAME = 'tax_set_name';
    public const COLUMN_META_TITLE = 'meta_title';
    public const COLUMN_META_KEYWORDS = 'meta_keywords';
    public const COLUMN_META_DESCRIPTION = 'meta_description';
    public const COLUMN_NEW_FROM = 'new_from';
    public const COLUMN_NEW_TO = 'new_to';

    public const DATA_PRODUCT_ABSTRACT_TRANSFER = 'DATA_PRODUCT_ABSTRACT_TRANSFER';
    public const DATA_PRODUCT_ABSTRACT_LOCALIZED_TRANSFER = 'DATA_PRODUCT_ABSTRACT_LOCALIZED_TRANSFER';
    public const DATA_PRODUCT_CATEGORY_TRANSFER = 'DATA_PRODUCT_CATEGORY_TRANSFER';
    public const DATA_PRODUCT_URL_TRANSFER = 'DATA_PRODUCT_URL_TRANSFER';
    public const KEY_PRODUCT_CATEGORY_TRANSFER = 'productCategoryTransfer';
    public const KEY_PRODUCT_ABSTRACT_LOCALIZED_TRANSFER = 'localizedAttributeTransfer';
    public const KEY_PRODUCT_URL_TRASNFER = 'urlTransfer';
    public const KEY_SKU = 'sku';
    public const KEY_ATTRIBUTES = 'attributes';
    public const KEY_ID_TAX_SET = 'idTaxSet';
    public const KEY_FK_TAX_SET = 'fk_tax_set';
    public const COLUMN_CATEGORY_KEYS = 'categoryKeys';
    public const KEY_FK_CATEGORY = 'fk_category';
    public const KEY_PRODUCT_ORDER = 'product_order';
    public const KEY_LOCALES = 'locales';
    public const KEY_FK_LOCALE = 'fk_locale';
    public const KEY_ID_URL = 'id_url';
    public const KEY_ID_PRODUCT_ABSTRACT = 'id_product_abstract';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $this->importProductAbstract($dataSet);
        $this->importProductAbstractLocalizedAttributes($dataSet);
        $this->importProductCategories($dataSet);
        $this->importProductUrls($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importProductAbstract(DataSetInterface $dataSet): void
    {
        $productAbstractEntityTransfer = new SpyProductAbstractEntityTransfer();
        $productAbstractEntityTransfer->setSku($dataSet[static::COLUMN_ABSTRACT_SKU]);

        $productAbstractEntityTransfer
            ->setColorCode($dataSet[static::COLUMN_COLOR_CODE])
            ->setFkTaxSet($dataSet[static::KEY_ID_TAX_SET])
            ->setAttributes(json_encode($dataSet[static::KEY_ATTRIBUTES]))
            ->setNewFrom($dataSet[static::COLUMN_NEW_FROM])
            ->setNewTo($dataSet[static::COLUMN_NEW_TO]);

        $dataSet[static::DATA_PRODUCT_ABSTRACT_TRANSFER] = $productAbstractEntityTransfer;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importProductAbstractLocalizedAttributes(DataSetInterface $dataSet): void
    {
        $localizedAttributeTransfer = [];

        foreach ($dataSet[ProductLocalizedAttributesExtractorStep::KEY_LOCALIZED_ATTRIBUTES] as $idLocale => $localizedAttributes) {
            $productAbstractLocalizedAttributesEntityTransfer = new SpyProductAbstractLocalizedAttributesEntityTransfer();
            $productAbstractLocalizedAttributesEntityTransfer
                ->setName($localizedAttributes[static::COLUMN_NAME])
                ->setDescription($localizedAttributes[static::COLUMN_DESCRIPTION])
                ->setMetaTitle($localizedAttributes[static::COLUMN_META_TITLE])
                ->setMetaDescription($localizedAttributes[static::COLUMN_META_DESCRIPTION])
                ->setMetaKeywords($localizedAttributes[static::COLUMN_META_KEYWORDS])
                ->setFkLocale($idLocale)
                ->setAttributes(json_encode($localizedAttributes[static::KEY_ATTRIBUTES]));

            $localizedAttributeTransfer[] = [
                static::COLUMN_ABSTRACT_SKU => $dataSet[static::COLUMN_ABSTRACT_SKU],
                static::KEY_PRODUCT_ABSTRACT_LOCALIZED_TRANSFER => $productAbstractLocalizedAttributesEntityTransfer,
            ];
        }

        $dataSet[static::DATA_PRODUCT_ABSTRACT_LOCALIZED_TRANSFER] = $localizedAttributeTransfer;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException
     *
     * @return void
     */
    protected function importProductCategories(DataSetInterface $dataSet): void
    {
        $productCategoryTransfers = [];
        $categoryKeys = $this->getCategoryKeys($dataSet[static::COLUMN_CATEGORY_KEY]);
        $categoryProductOrder = $this->getCategoryProductOrder($dataSet[static::COLUMN_CATEGORY_PRODUCT_ORDER]);

        foreach ($categoryKeys as $index => $categoryKey) {
            if (!isset($dataSet[static::COLUMN_CATEGORY_KEYS][$categoryKey])) {
                throw new DataKeyNotFoundInDataSetException(sprintf(
                    'The category with key "%s" was not found in categoryKeys. Maybe there is a typo. Given Categories: "%s"',
                    $categoryKey,
                    implode(array_values($dataSet[static::COLUMN_CATEGORY_KEYS]))
                ));
            }

            $productOrder = 0;

            if (count($categoryProductOrder) && isset($categoryProductOrder[$index])) {
                $productOrder = (int)$categoryProductOrder[$index];
            }

            $productCategoryEntityTransfer = new SpyProductCategoryEntityTransfer();
            $productCategoryEntityTransfer
                ->setFkCategory($dataSet[static::COLUMN_CATEGORY_KEYS][$categoryKey])
                ->setProductOrder($productOrder);

            $productCategoryTransfers[] = [
                static::COLUMN_ABSTRACT_SKU => $dataSet[static::COLUMN_ABSTRACT_SKU],
                static::KEY_PRODUCT_CATEGORY_TRANSFER => $productCategoryEntityTransfer,
            ];
        }

        $dataSet[static::DATA_PRODUCT_CATEGORY_TRANSFER] = $productCategoryTransfers;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importProductUrls(DataSetInterface $dataSet): void
    {
        $urlsTransfer = [];

        foreach ($dataSet[ProductLocalizedAttributesExtractorStep::KEY_LOCALIZED_ATTRIBUTES] as $idLocale => $localizedAttributes) {
            $abstractProductUrl = $localizedAttributes[static::COLUMN_URL];

            $urlEntityTransfer = new SpyUrlEntityTransfer();

            $urlEntityTransfer
                ->setFkLocale($idLocale)
                ->setUrl($abstractProductUrl);

            $urlsTransfer[] = [
                static::COLUMN_ABSTRACT_SKU => $dataSet[static::COLUMN_ABSTRACT_SKU],
                static::KEY_PRODUCT_URL_TRASNFER => $urlEntityTransfer,
            ];
        }

        $dataSet[static::DATA_PRODUCT_URL_TRANSFER] = $urlsTransfer;
    }

    /**
     * @param string $categoryKeys
     *
     * @return array
     */
    protected function getCategoryKeys($categoryKeys): array
    {
        $categoryKeys = explode(',', $categoryKeys);

        return array_map('trim', $categoryKeys);
    }

    /**
     * @param string $categoryProductOrder
     *
     * @return array
     */
    protected function getCategoryProductOrder($categoryProductOrder): array
    {
        $categoryProductOrder = explode(',', $categoryProductOrder);

        return array_map('trim', $categoryProductOrder);
    }
}
