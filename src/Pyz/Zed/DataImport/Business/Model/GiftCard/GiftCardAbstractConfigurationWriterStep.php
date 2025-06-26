<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model\GiftCard;

use Orm\Zed\GiftCard\Persistence\SpyGiftCardProductAbstractConfigurationLinkQuery;
use Orm\Zed\GiftCard\Persistence\SpyGiftCardProductAbstractConfigurationQuery;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class GiftCardAbstractConfigurationWriterStep implements DataImportStepInterface
{
    /**
     * @var int
     */
    public const BULK_SIZE = 100;

    /**
     * @var string
     */
    public const COL_PATTERN = 'pattern';

    /**
     * @var string
     */
    public const COL_ABSTRACT_SKU = 'abstract_sku';

    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
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
        $pattern = $dataSet[static::COL_PATTERN];
        $abstractSku = $dataSet[static::COL_ABSTRACT_SKU];
        $typeEntity = SpyGiftCardProductAbstractConfigurationQuery::create()
            ->filterByCodePattern($pattern)
            ->findOneOrCreate();
        $typeEntity->save();
        $linkEntity = SpyGiftCardProductAbstractConfigurationLinkQuery::create()
            ->filterByFkGiftCardProductAbstractConfiguration($typeEntity->getIdGiftCardProductAbstractConfiguration())
            ->filterByFkProductAbstract($this->productRepository->getIdProductAbstractByAbstractSku($abstractSku))
            ->findOneOrCreate();
        $linkEntity->save();
    }
}
