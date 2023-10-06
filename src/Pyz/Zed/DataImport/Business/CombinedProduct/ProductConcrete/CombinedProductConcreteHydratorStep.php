<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductConcrete;

use Pyz\Zed\DataImport\Business\Exception\InvalidDataException;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteHydratorStep;
use Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CombinedProductConcreteHydratorStep extends ProductConcreteHydratorStep
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
    public const COLUMN_IS_SEARCHABLE = 'product_concrete.is_searchable';

    /**
     * @var string
     */
    public const COLUMN_BUNDLES = 'product_concrete.bundled';

    /**
     * @var string
     */
    public const COLUMN_IS_QUANTITY_SPLITTABLE = 'product_concrete.is_quantity_splittable';

    /**
     * @var string
     */
    public const COLUMN_NAME = 'product.name';

    /**
     * @var string
     */
    public const COLUMN_DESCRIPTION = 'product.description';

    /**
     * @var string
     */
    public const COLUMN_ASSIGNED_PRODUCT_TYPE = 'product.assigned_product_type';

    /**
     * @var string
     */
    protected const ASSIGNABLE_PRODUCT_TYPE_CONCRETE = 'concrete';

    /**
     * @var string
     */
    protected const ASSIGNABLE_PRODUCT_TYPE_BOTH = 'both';

    /**
     * @var array<string>
     */
    protected const ASSIGNABLE_PRODUCT_TYPES = [
        self::ASSIGNABLE_PRODUCT_TYPE_CONCRETE,
        self::ASSIGNABLE_PRODUCT_TYPE_BOTH,
    ];

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct($productRepository);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $this->assertAssignableProductTypeColumn($dataSet);

        parent::execute($dataSet);
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
