<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductImage;

use Pyz\Zed\DataImport\Business\Exception\InvalidDataException;
use Pyz\Zed\DataImport\Business\Model\ProductImage\ProductImageHydratorStep;
use Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CombinedProductImageHydratorStep extends ProductImageHydratorStep
{
    /**
     * @var int
     */
    public const BULK_SIZE = 5000;

    /**
     * @var string
     */
    public const COLUMN_ABSTRACT_SKU = 'abstract_sku';

    /**
     * @var string
     */
    public const COLUMN_CONCRETE_SKU = 'concrete_sku';

    /**
     * @var string
     */
    public const COLUMN_IMAGE_SET_NAME = 'product_image.image_set_name';

    /**
     * @var string
     */
    public const COLUMN_EXTERNAL_URL_LARGE = 'product_image.external_url_large';

    /**
     * @var string
     */
    public const COLUMN_EXTERNAL_URL_SMALL = 'product_image.external_url_small';

    /**
     * @var string
     */
    public const COLUMN_LOCALE = 'product_image.locale';

    /**
     * @var string
     */
    public const COLUMN_SORT_ORDER = 'product_image.sort_order';

    /**
     * @var string
     */
    public const COLUMN_PRODUCT_IMAGE_KEY = 'product_image.product_image_key';

    /**
     * @var string
     */
    public const COLUMN_PRODUCT_IMAGE_SET_KEY = 'product_image.product_image_set_key';

    /**
     * @var string
     */
    public const COLUMN_ASSIGNED_PRODUCT_TYPE = 'product_image.assigned_product_type';

    /**
     * @var string
     */
    protected const ASSIGNABLE_PRODUCT_TYPE_ABSTRACT = 'abstract';

    /**
     * @var string
     */
    protected const ASSIGNABLE_PRODUCT_TYPE_CONCRETE = 'concrete';

    /**
     * @var array<string>
     */
    protected const ASSIGNABLE_PRODUCT_TYPES = [
        self::ASSIGNABLE_PRODUCT_TYPE_ABSTRACT,
        self::ASSIGNABLE_PRODUCT_TYPE_CONCRETE,
    ];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $dataSet = $this->assignProductType($dataSet);

        parent::execute($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface
     */
    protected function assignProductType(DataSetInterface $dataSet): DataSetInterface
    {
        $this->assertAssignableProductTypeColumn($dataSet);

        if ($dataSet[static::COLUMN_ASSIGNED_PRODUCT_TYPE] == static::ASSIGNABLE_PRODUCT_TYPE_ABSTRACT) {
            $dataSet[static::COLUMN_CONCRETE_SKU] = $dataSet[ProductImageHydratorStep::KEY_IMAGE_SET_FK_PRODUCT] = null;
        }
        if ($dataSet[static::COLUMN_ASSIGNED_PRODUCT_TYPE] == static::ASSIGNABLE_PRODUCT_TYPE_CONCRETE) {
            $dataSet[static::COLUMN_ABSTRACT_SKU] = $dataSet[ProductImageHydratorStep::KEY_IMAGE_SET_FK_PRODUCT_ABSTRACT] = null;
        }

        return $dataSet;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException
     * @throws \Pyz\Zed\DataImport\Business\Exception\InvalidDataException
     *
     * @return void
     */
    protected function assertAssignableProductTypeColumn(DataSetInterface $dataSet): void
    {
        if (empty($dataSet[static::COLUMN_ASSIGNED_PRODUCT_TYPE])) {
            throw new DataKeyNotFoundInDataSetException(sprintf(
                '"%s" must be defined in the data set. Given: "%s"',
                static::COLUMN_ASSIGNED_PRODUCT_TYPE,
                implode(', ', array_keys($dataSet->getArrayCopy())),
            ));
        }

        if (!in_array($dataSet[static::COLUMN_ASSIGNED_PRODUCT_TYPE], static::ASSIGNABLE_PRODUCT_TYPES, true)) {
            throw new InvalidDataException(sprintf(
                '"%s" must have one of the following values: %s. Given: "%s"',
                static::COLUMN_ASSIGNED_PRODUCT_TYPE,
                implode(', ', static::ASSIGNABLE_PRODUCT_TYPES),
                $dataSet[static::COLUMN_ASSIGNED_PRODUCT_TYPE],
            ));
        }
    }
}
