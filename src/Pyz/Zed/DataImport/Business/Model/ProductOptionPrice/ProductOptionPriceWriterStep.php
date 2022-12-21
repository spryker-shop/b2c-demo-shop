<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductOptionPrice;

use Orm\Zed\Currency\Persistence\SpyCurrencyQuery;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\ProductOption\Persistence\SpyProductOptionValuePriceQuery;
use Orm\Zed\ProductOption\Persistence\SpyProductOptionValueQuery;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Pyz\Zed\DataImport\Business\Exception\InvalidDataException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\ProductOption\Dependency\ProductOptionEvents;

class ProductOptionPriceWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    /**
     * @var int
     */
    public const BULK_SIZE = 100;

    /**
     * @var string
     */
    public const KEY_PRODUCT_OPTION_SKU = 'product_option_sku';

    /**
     * @var string
     */
    public const KEY_STORE = 'store';

    /**
     * @var string
     */
    public const KEY_CURRENCY = 'currency';

    /**
     * @var string
     */
    public const KEY_NET_AMOUNT = 'value_net';

    /**
     * @var string
     */
    public const KEY_GROSS_AMOUNT = 'value_gross';

    /**
     * @var array<int> Keys are store names
     */
    protected static $idStoreBuffer = [];

    /**
     * @var array<int> Keys are currency codes.
     */
    protected static $idCurrencyBuffer = [];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\InvalidDataException
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $productOptionValueEntity = SpyProductOptionValueQuery::create()
            ->findOneBySku($dataSet[static::KEY_PRODUCT_OPTION_SKU]);

        if ($productOptionValueEntity === null) {
            throw new InvalidDataException(
                sprintf('Product option SKU (%s) not found in permanent storage.', $dataSet[static::KEY_PRODUCT_OPTION_SKU]),
            );
        }

        $priceEntity = SpyProductOptionValuePriceQuery::create()
            ->filterByFkStore($this->getIdStore($dataSet[static::KEY_STORE]))
            ->filterByFkCurrency($this->getIdCurrency($dataSet[static::KEY_CURRENCY]))
            ->filterByFkProductOptionValue($productOptionValueEntity->getIdProductOptionValue())
            ->findOneOrCreate();

        $priceEntity
            ->setGrossPrice($this->formatPrice($dataSet[static::KEY_GROSS_AMOUNT]))
            ->setNetPrice($this->formatPrice($dataSet[static::KEY_NET_AMOUNT]))
            ->save();

        $this->publishRelatedProductAbstracts($priceEntity->getFkProductOptionValue());
    }

    /**
     * @param int $idProductOptionValue
     *
     * @return void
     */
    protected function publishRelatedProductAbstracts($idProductOptionValue): void
    {
        $productAbstractCollection = SpyProductAbstractQuery::create()
            ->joinSpyProductAbstractProductOptionGroup()
            ->useSpyProductAbstractProductOptionGroupQuery()
                ->joinSpyProductOptionGroup()
                ->useSpyProductOptionGroupQuery()
                    ->joinSpyProductOptionValue()
                    ->useSpyProductOptionValueQuery()
                        ->filterByIdProductOptionValue($idProductOptionValue)
                    ->endUse()
                ->endUse()
            ->endUse()
            ->find();

        foreach ($productAbstractCollection as $productAbstractEntity) {
            $this->addPublishEvents(ProductOptionEvents::PRODUCT_ABSTRACT_PRODUCT_OPTION_PUBLISH, $productAbstractEntity->getIdProductAbstract());
        }
    }

    /**
     * @param string|null $storeName
     *
     * @return int|null
     */
    protected function getIdStore($storeName): ?int
    {
        if ($storeName === '' || $storeName === null) {
            return null;
        }

        if (!isset(static::$idStoreBuffer[$storeName])) {
            $storeEntity = SpyStoreQuery::create()->findOneByName($storeName);
            static::$idStoreBuffer[$storeName] = $storeEntity === null ? null : $storeEntity->getIdStore();
        }

        return static::$idStoreBuffer[$storeName];
    }

    /**
     * @param string $currencyIsoCode
     *
     * @return int
     */
    protected function getIdCurrency($currencyIsoCode): int
    {
        if (!isset(static::$idCurrencyBuffer[$currencyIsoCode])) {
            static::$idCurrencyBuffer[$currencyIsoCode] = SpyCurrencyQuery::create()
                ->findOneByCode($currencyIsoCode)
                ->getIdCurrency();
        }

        return static::$idCurrencyBuffer[$currencyIsoCode];
    }

    /**
     * @param string|int|null $price
     *
     * @return int|null
     */
    protected function formatPrice($price): ?int
    {
        if ($price === '' || $price === null) {
            return null;
        }

        return (int)$price;
    }
}
