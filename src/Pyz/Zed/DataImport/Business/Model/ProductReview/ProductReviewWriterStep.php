<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductReview;

use Orm\Zed\ProductReview\Persistence\Map\SpyProductReviewTableMap;
use Orm\Zed\ProductReview\Persistence\SpyProductReviewQuery;
use Pyz\Zed\DataImport\Business\Model\Locale\Repository\LocaleRepositoryInterface;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\ProductReview\Dependency\ProductReviewEvents;

class ProductReviewWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Locale\Repository\LocaleRepositoryInterface
     */
    protected $localeRepository;

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface $productRepository
     * @param \Pyz\Zed\DataImport\Business\Model\Locale\Repository\LocaleRepositoryInterface $localeRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository, LocaleRepositoryInterface $localeRepository)
    {
        $this->productRepository = $productRepository;
        $this->localeRepository = $localeRepository;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $productReviewEntity = SpyProductReviewQuery::create()
            ->filterByCustomerReference($dataSet['customer_reference'])
            ->filterByFkProductAbstract($this->getFkProductAbstract($dataSet))
            ->filterByFkLocale($this->getFkLocale($dataSet))
            ->filterByNickname($dataSet['nickname'])
            ->filterBySummary($dataSet['summary'])
            ->filterByDescription($dataSet['description'])
            ->filterByRating($dataSet['rating'])
            ->findOneOrCreate();

        $productReviewEntity->fromArray($dataSet->getArrayCopy());

        if ($productReviewEntity->isNew() || $productReviewEntity->isModified()) {
            $productReviewEntity->save();

            if ($productReviewEntity->getStatus() === SpyProductReviewTableMap::COL_STATUS_APPROVED) {
                $this->addPublishEvents(ProductReviewEvents::PRODUCT_REVIEW_PUBLISH, $productReviewEntity->getIdProductReview());
            }
            $this->addPublishEvents(ProductReviewEvents::PRODUCT_ABSTRACT_REVIEW_PUBLISH, $productReviewEntity->getFkProductAbstract());
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return int
     */
    protected function getFkProductAbstract(DataSetInterface $dataSet): int
    {
        return $this->productRepository->getIdProductAbstractByAbstractSku($dataSet['abstract_product_sku']);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return int
     */
    protected function getFkLocale(DataSetInterface $dataSet): int
    {
        return $this->localeRepository->getIdLocaleByLocale($dataSet['locale_name']);
    }
}
