<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductConcrete;

use Pyz\Zed\DataImport\Business\Exception\InvalidDataException;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Dependency\Service\DataImportToUtilEncodingServiceInterface;

class ProductConcreteAttributesUniqueCheckStep implements DataImportStepInterface
{
    protected const KEY_CONCRETE_SKU = 'concrete_sku';
    protected const KEY_ABSTRACT_SKU = 'abstract_sku';
    protected const KEY_ATTRIBUTES = 'attributes';

    /**
     * @uses \Orm\Zed\Product\Persistence\Map\SpyProductTableMap::COL_ATTRIBUTES
     */
    protected const PRODUCT_COL_ATTRIBUTES = 'spy_product.attributes';
    /**
     * @uses \Orm\Zed\Product\Persistence\Map\SpyProductTableMap::COL_SKU
     */
    protected const PRODUCT_COL_SKU = 'spy_product.sku';
    /**
     * @uses \Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap::COL_SKU
     */
    protected const PRODUCT_ABSTRACT_COL_SKU = 'spy_product_abstract.sku';

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Spryker\Zed\DataImport\Dependency\Service\DataImportToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var array
     */
    protected static $productConcreteAttributesMap = [];

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface $productRepository
     * @param \Spryker\Zed\DataImport\Dependency\Service\DataImportToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        DataImportToUtilEncodingServiceInterface $utilEncodingService
    ) {
        $this->productRepository = $productRepository;
        $this->utilEncodingService = $utilEncodingService;

        $this->prepareProductConcreteAttributesMap();
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $dataSetProductConcreteSku = $dataSet[static::KEY_CONCRETE_SKU];
        $dataSetProductAbstractSku = $dataSet[static::KEY_ABSTRACT_SKU];
        $dataSetProductConcreteAttributes = $dataSet[static::KEY_ATTRIBUTES];
        ksort($dataSetProductConcreteAttributes);

        $this->checkProductConcreteAttributesUnique($dataSetProductAbstractSku, $dataSetProductConcreteSku, $dataSetProductConcreteAttributes);

        static::$productConcreteAttributesMap[$dataSetProductAbstractSku][$dataSetProductConcreteSku] = $dataSetProductConcreteAttributes;
    }

    /**
     * @param string $dataSetProductAbstractSku
     * @param string $dataSetProductConcreteSku
     * @param array $dataSetProductConcreteAttributes
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\InvalidDataException
     *
     * @return void
     */
    protected function checkProductConcreteAttributesUnique(
        string $dataSetProductAbstractSku,
        string $dataSetProductConcreteSku,
        array $dataSetProductConcreteAttributes
    ): void {
        if (!isset(static::$productConcreteAttributesMap[$dataSetProductAbstractSku])) {
            return;
        }

        foreach (static::$productConcreteAttributesMap[$dataSetProductAbstractSku] as $productConcreteSku => $productConcreteAttributes) {
            if ($dataSetProductConcreteSku == $productConcreteSku) {
                continue;
            }

            if ($dataSetProductConcreteAttributes === $productConcreteAttributes) {
                throw new InvalidDataException(sprintf(
                    'Product concrete must have unique attributes. Attributes "%s" of sku "%s" are equal to attributes "%s" of sku "%s".',
                    $this->utilEncodingService->encodeJson($dataSetProductConcreteAttributes),
                    $dataSetProductConcreteSku,
                    $this->utilEncodingService->encodeJson($productConcreteAttributes),
                    $productConcreteSku
                ));
            }
        }
    }

    /**
     * @return void
     */
    protected function prepareProductConcreteAttributesMap(): void
    {
        $productConcreteCollection = $this->productRepository->getProductConcreteAttributesCollection();

        foreach ($productConcreteCollection as $productConcrete) {
            $productConcreteAttributes = $this->utilEncodingService->decodeJson($productConcrete[static::PRODUCT_COL_ATTRIBUTES], true);
            if ($productConcreteAttributes) {
                ksort($productConcreteAttributes);
            }
            $productConcreteSku = $productConcrete[static::PRODUCT_COL_SKU];
            $productAbstractSku = $productConcrete[static::PRODUCT_ABSTRACT_COL_SKU];

            static::$productConcreteAttributesMap[$productAbstractSku][$productConcreteSku] = $productConcreteAttributes;
        }
    }
}
