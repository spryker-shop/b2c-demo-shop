<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductAbstract;

use Pyz\Zed\DataImport\Business\Exception\InvalidSkuProductException;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class ProductAbstractCheckExistenceStep implements DataImportStepInterface
{
    public const KEY_ABSTRACT_SKU = 'abstract_sku';

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var string[] Keys are concrete product sku values.
     */
    protected $skuProductConcreteList = [];

    /**
     * @var bool[] Keys are abstract product sku values. Values are set to "true" when abstract product added.
     */
    protected $resolved = [];

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;

        $this->skuProductConcreteList = array_flip($productRepository->getSkuProductConcreteList());
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $this->checkSkuProductAlreadyExists($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\InvalidSkuProductException
     *
     * @return void
     */
    protected function checkSkuProductAlreadyExists(DataSetInterface $dataSet): void
    {
        $sku = $dataSet[static::KEY_ABSTRACT_SKU];

        if (isset($this->skuProductConcreteList[$sku])) {
            throw new InvalidSkuProductException(sprintf('Concrete product with SKU "%s" already exists.', $sku));
        }

        if (isset($this->resolved[$sku])) {
            throw new InvalidSkuProductException(sprintf('Abstract product with SKU "%s" has been already imported.', $sku));
        }

        $this->resolved[$sku] = true;
    }
}
