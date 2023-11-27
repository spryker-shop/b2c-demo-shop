<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductConcrete;

use Generated\Shared\Transfer\PaginationTransfer;
use Propel\Runtime\Collection\ArrayCollection;
use Pyz\Zed\DataImport\Business\Exception\InvalidDataException;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Pyz\Zed\DataImport\DataImportConfig;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Dependency\Service\DataImportToUtilEncodingServiceInterface;

class ProductConcreteAttributesUniqueCheckStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    protected const KEY_CONCRETE_SKU = 'concrete_sku';

    /**
     * @var string
     */
    protected const KEY_ABSTRACT_SKU = 'abstract_sku';

    /**
     * @var string
     */
    protected const KEY_ATTRIBUTES = 'attributes';

    /**
     * @uses \Orm\Zed\Product\Persistence\Map\SpyProductTableMap::COL_ATTRIBUTES
     *
     * @var string
     */
    protected const PRODUCT_COL_ATTRIBUTES = 'spy_product.attributes';

    /**
     * @uses \Orm\Zed\Product\Persistence\Map\SpyProductTableMap::COL_SKU
     *
     * @var string
     */
    protected const PRODUCT_COL_SKU = 'spy_product.sku';

    /**
     * @uses \Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap::COL_SKU
     *
     * @var string
     */
    protected const PRODUCT_ABSTRACT_COL_SKU = 'spy_product_abstract.sku';

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;

    /**
     * @var \Spryker\Zed\DataImport\Dependency\Service\DataImportToUtilEncodingServiceInterface
     */
    protected DataImportToUtilEncodingServiceInterface $utilEncodingService;

    /**
     * @var \Pyz\Zed\DataImport\DataImportConfig
     */
    protected DataImportConfig $dataImportConfig;

    /**
     * @var array<string, array<string, array<string, mixed>>>
     */
    protected static array $productConcreteAttributesMap = [];

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface $productRepository
     * @param \Spryker\Zed\DataImport\Dependency\Service\DataImportToUtilEncodingServiceInterface $utilEncodingService
     * @param \Pyz\Zed\DataImport\DataImportConfig $dataImportConfig
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        DataImportToUtilEncodingServiceInterface $utilEncodingService,
        DataImportConfig $dataImportConfig,
    ) {
        $this->productRepository = $productRepository;
        $this->utilEncodingService = $utilEncodingService;
        $this->dataImportConfig = $dataImportConfig;

        $this->prepareProductConcreteAttributesMap();
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        /** @var string $dataSetProductConcreteSku */
        $dataSetProductConcreteSku = $dataSet[static::KEY_CONCRETE_SKU];
        /** @var string $dataSetProductAbstractSku */
        $dataSetProductAbstractSku = $dataSet[static::KEY_ABSTRACT_SKU];
        $dataSetProductConcreteAttributes = $dataSet[static::KEY_ATTRIBUTES];
        ksort($dataSetProductConcreteAttributes);

        $this->checkProductConcreteAttributesUnique($dataSetProductAbstractSku, $dataSetProductConcreteSku, $dataSetProductConcreteAttributes);

        static::$productConcreteAttributesMap[$dataSetProductAbstractSku][$dataSetProductConcreteSku] = $dataSetProductConcreteAttributes;
    }

    /**
     * @param string $dataSetProductAbstractSku
     * @param string $dataSetProductConcreteSku
     * @param array<string, mixed> $dataSetProductConcreteAttributes
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\InvalidDataException
     *
     * @return void
     */
    protected function checkProductConcreteAttributesUnique(
        string $dataSetProductAbstractSku,
        string $dataSetProductConcreteSku,
        array $dataSetProductConcreteAttributes,
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
                    $productConcreteSku,
                ));
            }
        }
    }

    /**
     * @return void
     */
    protected function prepareProductConcreteAttributesMap(): void
    {
        $readCollectionBatchSize = $this->dataImportConfig->getReadCollectionBatchSize();
        $paginationTransfer = (new PaginationTransfer())->setOffset(0)->setLimit($readCollectionBatchSize);

        do {
            $productConcreteCollection = $this->productRepository->getProductConcreteAttributesCollection($paginationTransfer);
            if (!count($productConcreteCollection)) {
                break;
            }

            $this->processProductConcreteAttributesMap($productConcreteCollection);

            $paginationTransfer->setOffset($paginationTransfer->getOffset() + $readCollectionBatchSize);
        } while (count($productConcreteCollection));
    }

    /**
     * @param \Propel\Runtime\Collection\ArrayCollection $productConcreteCollection
     *
     * @return void
     */
    protected function processProductConcreteAttributesMap(ArrayCollection $productConcreteCollection): void
    {
        foreach ($productConcreteCollection as $productConcrete) {
            /** @var string $productConcreteSku */
            $productConcreteSku = $productConcrete[static::PRODUCT_COL_SKU];
            /** @var string $productAbstractSku */
            $productAbstractSku = $productConcrete[static::PRODUCT_ABSTRACT_COL_SKU];

            if (isset(static::$productConcreteAttributesMap[$productAbstractSku][$productConcreteSku])) {
                continue;
            }

            $productConcreteAttributes = $this->utilEncodingService->decodeJson($productConcrete[static::PRODUCT_COL_ATTRIBUTES], true);
            if ($productConcreteAttributes) {
                ksort($productConcreteAttributes);
            }

            static::$productConcreteAttributesMap[$productAbstractSku][$productConcreteSku] = $productConcreteAttributes;
        }
    }
}
