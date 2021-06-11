<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductConcrete;

use Generated\Shared\Transfer\SpyProductBundleEntityTransfer;
use Generated\Shared\Transfer\SpyProductEntityTransfer;
use Generated\Shared\Transfer\SpyProductLocalizedAttributesEntityTransfer;
use Generated\Shared\Transfer\SpyProductSearchEntityTransfer;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class ProductConcreteHydratorStep implements DataImportStepInterface
{
    public const BULK_SIZE = 100;

    public const COLUMN_ABSTRACT_SKU = 'abstract_sku';
    public const COLUMN_CONCRETE_SKU = 'concrete_sku';

    public const COLUMN_NAME = 'name';
    public const COLUMN_DESCRIPTION = 'description';
    public const COLUMN_IS_SEARCHABLE = 'is_searchable';
    public const COLUMN_BUNDLES = 'bundled';
    public const COLUMN_IS_QUANTITY_SPLITTABLE = 'is_quantity_splittable';

    public const KEY_ATTRIBUTES = 'attributes';
    public const KEY_DISCOUNT = 'discount';
    public const KEY_QUANTITY = 'quantity';
    public const KEY_WAREHOUSES = 'warehouses';
    public const KEY_SPY_PRODUCT = 'spy_product';
    public const KEY_ID_PRODUCT = 'id_product';
    public const KEY_FK_PRODUCT_ABSTRACT = 'fk_product_abstract';
    public const KEY_LOCALIZED_ATTRIBUTES = 'localizedAttributes';
    public const KEY_LOCALES = 'locales';
    public const KEY_FK_LOCALE = 'fk_locale';
    public const KEY_FK_PRODUCT = 'fk_product';
    public const KEY_FK_BUNDLED_PRODUCT = 'fk_bundled_product';
    public const KEY_SKU = 'sku';
    public const KEY_IS_ACTIVE = 'is_active';
    public const KEY_IS_COMPLETE = 'is_complete';
    public const KEY_PRODUCT_BUNDLE_TRANSFER = 'productBundleEntityTransfer';
    public const KEY_PRODUCT_CONCRETE_LOCALIZED_TRANSFER = 'localizedAttributeTransfer';
    public const KEY_PRODUCT_SEARCH_TRANSFER = 'productSearchEntityTransfer';
    public const KEY_PRODUCT_BUNDLE_SKU = 'bundledProductSku';
    public const DATA_PRODUCT_CONCRETE_TRANSFER = 'DATA_PRODUCT_CONCRETE_TRANSFER';
    public const DATA_PRODUCT_CONCRETE_LOCALIZED_TRANSFER = 'DATA_PRODUCT_CONCRETE_LOCALIZED_TRANSFER';
    public const DATA_PRODUCT_BUNDLE_TRANSFER = 'DATA_PRODUCT_BUNDLE_TRANSFER';

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository
     */
    protected $productRepository;

    /**
     * @var bool[] Keys are product column names
     */
    protected static $isProductColumnBuffer = [];

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $this->importProduct($dataSet);
        $this->importProductLocalizedAttributes($dataSet);
        $this->importBundles($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importProduct(DataSetInterface $dataSet): void
    {
        $productEntityTransfer = new SpyProductEntityTransfer();
        $productEntityTransfer->setSku($dataSet[static::COLUMN_CONCRETE_SKU]);
        $productEntityTransfer
            ->setIsActive($dataSet[static::KEY_IS_ACTIVE] ?? true)
            ->setAttributes(json_encode($dataSet[static::KEY_ATTRIBUTES]));

        if ($this->isProductColumn(static::COLUMN_IS_QUANTITY_SPLITTABLE)) {
            $isQuantitySplittable = (
                !isset($dataSet[static::COLUMN_IS_QUANTITY_SPLITTABLE]) ||
                $dataSet[static::COLUMN_IS_QUANTITY_SPLITTABLE] === ''
            ) ? true : $dataSet[static::COLUMN_IS_QUANTITY_SPLITTABLE];
            $productEntityTransfer->setIsQuantitySplittable($isQuantitySplittable);
        }

        $dataSet[static::DATA_PRODUCT_CONCRETE_TRANSFER] = $productEntityTransfer;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importProductLocalizedAttributes(DataSetInterface $dataSet): void
    {
        $localizedAttributeTransfer = [];

        foreach ($dataSet[static::KEY_LOCALIZED_ATTRIBUTES] as $idLocale => $localizedAttributes) {
            $productLocalizedAttributesEntityTransfer = new SpyProductLocalizedAttributesEntityTransfer();
            $productLocalizedAttributesEntityTransfer
                ->setName($localizedAttributes[static::COLUMN_NAME])
                ->setDescription($localizedAttributes[static::COLUMN_DESCRIPTION])
                ->setIsComplete($localizedAttributes[static::KEY_IS_COMPLETE] ?? true)
                ->setAttributes(json_encode($localizedAttributes[static::KEY_ATTRIBUTES]))
                ->setFkLocale($idLocale);

            $productSearchEntityTransfer = new SpyProductSearchEntityTransfer();
            $productSearchEntityTransfer
                ->setFkLocale($idLocale)
                ->setIsSearchable($localizedAttributes[static::COLUMN_IS_SEARCHABLE]);

            $localizedAttributeTransfer[] = [
                static::KEY_PRODUCT_CONCRETE_LOCALIZED_TRANSFER => $productLocalizedAttributesEntityTransfer,
                static::KEY_PRODUCT_SEARCH_TRANSFER => $productSearchEntityTransfer,
                static::KEY_SKU => $dataSet[static::COLUMN_CONCRETE_SKU],
            ];
        }

        $dataSet[static::DATA_PRODUCT_CONCRETE_LOCALIZED_TRANSFER] = $localizedAttributeTransfer;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function importBundles(DataSetInterface $dataSet): void
    {
        $productBundleTransfer = [];

        if (!empty($dataSet[static::COLUMN_BUNDLES])) {
            $bundleProducts = explode(',', $dataSet[static::COLUMN_BUNDLES]);

            foreach ($bundleProducts as $bundleProduct) {
                $bundleProduct = trim($bundleProduct);
                [$sku, $quantity] = explode('/', $bundleProduct);

                $productBundleEntityTransfer = new SpyProductBundleEntityTransfer();
                $productBundleEntityTransfer->setQuantity((int)$quantity);
                $productBundleTransfer[] = [
                    static::KEY_PRODUCT_BUNDLE_TRANSFER => $productBundleEntityTransfer,
                    static::KEY_SKU => $dataSet[static::COLUMN_CONCRETE_SKU],
                    static::KEY_PRODUCT_BUNDLE_SKU => $sku,
                ];
            }
        }
        $dataSet[static::DATA_PRODUCT_BUNDLE_TRANSFER] = $productBundleTransfer;
    }

    /**
     * @param string $columnName
     *
     * @return bool
     */
    protected function isProductColumn(string $columnName): bool
    {
        if (isset(static::$isProductColumnBuffer[$columnName])) {
            return static::$isProductColumnBuffer[$columnName];
        }
        $isColumnExists = SpyProductTableMap::getTableMap()->hasColumn($columnName);
        static::$isProductColumnBuffer[$columnName] = $isColumnExists;

        return $isColumnExists;
    }
}
