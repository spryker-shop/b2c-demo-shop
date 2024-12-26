<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ExampleProductSalePage\Persistence;

use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\ProductLabel\Persistence\Map\SpyProductLabelProductAbstractTableMap;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabelQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Criterion\BasicModelCriterion;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePagePersistenceFactory getFactory()
 */
class ExampleProductSalePageQueryContainer extends AbstractQueryContainer implements ExampleProductSalePageQueryContainerInterface
{
    /**
     * @var string
     */
    protected const PRICE_TYPE_ORIGINAL = 'ORIGINAL';

    /**
     * @uses \Spryker\Shared\PriceProduct\PriceProductConfig::PRICE_TYPE_DEFAULT
     *
     * @var string
     */
    protected const PRICE_TYPE_DEFAULT = 'DEFAULT';

    /**
     * @uses \Spryker\Shared\Price\PriceConfig::PRICE_MODE_NET
     *
     * @var string
     */
    protected const PRICE_MODE_NET = 'NET_MODE';

    /**
     * @uses \Spryker\Shared\Price\PriceConfig::PRICE_MODE_GROSS
     *
     * @var string
     */
    protected const PRICE_MODE_GROSS = 'GROSS_MODE';

    /**
     * @api
     *
     * @param string $labelName
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabelQuery
     */
    public function queryProductLabelByName(string $labelName): SpyProductLabelQuery
    {
        return $this->getFactory()
            ->getProductLabelQueryContainer()
            ->queryProductLabelByName($labelName);
    }

    /**
     * @api
     *
     * @param int $idProductLabel
     * @param string $priceMode
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery
     */
    public function queryRelationsBecomingInactive(int $idProductLabel, string $priceMode): SpyProductLabelProductAbstractQuery
    {
        /** @var \Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery $productLabelProductAbstractQuery */
        $productLabelProductAbstractQuery = $this->getFactory()
            ->getProductLabelQueryContainer()
            ->queryProductAbstractRelationsByIdProductLabel($idProductLabel)
            ->distinct()
            ->useSpyProductAbstractQuery(null, Criteria::LEFT_JOIN)
                ->usePriceProductQuery('priceProductOrigin', Criteria::LEFT_JOIN)
                    ->joinPriceType('priceTypeOrigin', Criteria::INNER_JOIN)
                    ->addJoinCondition(
                        'priceTypeOrigin',
                        'priceTypeOrigin.name = ?',
                        static::PRICE_TYPE_ORIGINAL,
                    )
                    ->usePriceProductStoreQuery('priceProductStoreOrigin', Criteria::LEFT_JOIN)
                        ->usePriceProductDefaultQuery('priceProductDefaultOriginal', Criteria::LEFT_JOIN)
                        ->endUse()
                    ->endUse()
                ->endUse()
                ->usePriceProductQuery('priceProductDefault', Criteria::LEFT_JOIN)
                    ->joinPriceType('priceTypeDefault', Criteria::INNER_JOIN)
                    ->addJoinCondition(
                        'priceTypeDefault',
                        'priceTypeDefault.name = ?',
                        static::PRICE_TYPE_DEFAULT,
                    )
                    ->usePriceProductStoreQuery('priceProductStoreDefault', Criteria::LEFT_JOIN)
                        ->usePriceProductDefaultQuery('priceProductDefaultDefault', Criteria::LEFT_JOIN)
                        ->endUse()
                    ->endUse()
                ->endUse()
            ->endUse()
            ->addAnd('priceProductDefaultOriginal.id_price_product_default', null, Criteria::ISNOTNULL)
            ->addAnd('priceProductDefaultDefault.id_price_product_default', null, Criteria::ISNOTNULL)
            ->addJoinCondition('priceProductStoreDefault', 'priceProductStoreOrigin.fk_store = priceProductStoreDefault.fk_store')
            ->addJoinCondition('priceProductStoreDefault', 'priceProductStoreOrigin.fk_currency = priceProductStoreDefault.fk_currency');

        if ($priceMode === static::PRICE_MODE_GROSS) {
            $productLabelProductAbstractQuery->addAnd(
                $this->getBasicModelCriterion(
                    $productLabelProductAbstractQuery,
                    'priceProductStoreOrigin.gross_price < priceProductStoreDefault.gross_price',
                    'priceProductStoreOrigin.gross_price',
                ),
            )
                ->addOr(
                    $this->getBasicModelCriterion(
                        $productLabelProductAbstractQuery,
                        'priceProductStoreOrigin.gross_price = priceProductStoreDefault.gross_price',
                        'priceProductStoreOrigin.gross_price',
                    ),
                )
                ->addOr($productLabelProductAbstractQuery->getNewCriterion('priceProductStoreOrigin.gross_price', null, Criteria::ISNULL)
                    ->addOr($productLabelProductAbstractQuery->getNewCriterion('priceProductStoreDefault.gross_price', null, Criteria::ISNULL)));
        }

        if ($priceMode === static::PRICE_MODE_NET) {
            $productLabelProductAbstractQuery->addAnd(
                $this->getBasicModelCriterion(
                    $productLabelProductAbstractQuery,
                    'priceProductStoreOrigin.net_price < priceProductStoreDefault.net_price',
                    'priceProductStoreOrigin.net_price',
                ),
            )
                ->addOr(
                    $this->getBasicModelCriterion(
                        $productLabelProductAbstractQuery,
                        'priceProductStoreOrigin.net_price = priceProductStoreDefault.net_price',
                        'priceProductStoreOrigin.net_price',
                    ),
                )
                ->addOr($productLabelProductAbstractQuery->getNewCriterion('priceProductStoreOrigin.net_price', null, Criteria::ISNULL)
                    ->addAnd($productLabelProductAbstractQuery->getNewCriterion('priceProductStoreDefault.net_price', null, Criteria::ISNULL)));
        }

        return $productLabelProductAbstractQuery;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria $criteria
     * @param string $clause
     * @param \Propel\Runtime\Map\ColumnMap|string $column
     *
     * @return \Propel\Runtime\ActiveQuery\Criterion\BasicModelCriterion
     */
    protected function getBasicModelCriterion(Criteria $criteria, string $clause, $column): BasicModelCriterion
    {
        return new BasicModelCriterion($criteria, $clause, $column);
    }

    /**
     * @api
     *
     * @param int $idProductLabel
     * @param int $currentStoreId
     * @param int $currentCurrencyId
     * @param string $priceMode
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function queryRelationsBecomingActive(
        int $idProductLabel,
        int $currentStoreId,
        int $currentCurrencyId,
        string $priceMode,
    ): SpyProductAbstractQuery {
        /** @var \Orm\Zed\Product\Persistence\SpyProductAbstractQuery $productAbstractQuery */
        $productAbstractQuery = $this->getFactory()
            ->getProductQueryContainer()
            ->queryProductAbstract()
            ->distinct()
            ->usePriceProductQuery('priceProductOrigin', Criteria::LEFT_JOIN)
                ->joinPriceType('priceTypeOrigin', Criteria::INNER_JOIN)
                ->addJoinCondition(
                    'priceTypeOrigin',
                    'priceTypeOrigin.name = ?',
                    static::PRICE_TYPE_ORIGINAL,
                )
                ->usePriceProductStoreQuery('priceProductStoreOrigin', Criteria::LEFT_JOIN)
                    ->usePriceProductDefaultQuery('priceProductDefaultOriginal', Criteria::LEFT_JOIN)
                    ->endUse()
                ->endUse()
            ->endUse()
            ->usePriceProductQuery('priceProductDefault', Criteria::LEFT_JOIN)
                ->joinPriceType('priceTypeDefault', Criteria::INNER_JOIN)
                ->addJoinCondition(
                    'priceTypeDefault',
                    'priceTypeDefault.name = ?',
                    static::PRICE_TYPE_DEFAULT,
                )
                ->usePriceProductStoreQuery('priceProductStoreDefault', Criteria::LEFT_JOIN)
                    ->usePriceProductDefaultQuery('priceProductDefaultDefault', Criteria::LEFT_JOIN)
                    ->endUse()
                ->endUse()
            ->endUse()
            ->useSpyProductLabelProductAbstractQuery('rel', Criteria::LEFT_JOIN)
            ->endUse()
            ->addJoin(
                ['rel.fk_product_abstract', SpyProductLabelProductAbstractTableMap::COL_FK_PRODUCT_LABEL],
                [SpyProductLabelProductAbstractTableMap::COL_FK_PRODUCT_ABSTRACT, $idProductLabel],
                Criteria::LEFT_JOIN,
            )
            ->addJoinCondition('priceProductStoreDefault', 'priceProductDefault.id_price_product=priceProductStoreDefault.fk_price_product')
            ->addJoinCondition('priceProductStoreDefault', 'priceProductStoreOrigin.fk_store = priceProductStoreDefault.fk_store')
            ->addJoinCondition('priceProductStoreDefault', 'priceProductStoreOrigin.fk_currency = priceProductStoreDefault.fk_currency');

        $productAbstractQuery->addAnd(SpyProductLabelProductAbstractTableMap::COL_FK_PRODUCT_ABSTRACT, null, Criteria::ISNULL);
        $productAbstractQuery->addAnd('priceProductStoreOrigin.fk_store', $currentStoreId, Criteria::EQUAL);
        $productAbstractQuery->addAnd('priceProductStoreOrigin.fk_currency', $currentCurrencyId, Criteria::EQUAL);
        $productAbstractQuery->addAnd('priceProductStoreDefault.fk_store', $currentStoreId, Criteria::EQUAL);
        $productAbstractQuery->addAnd('priceProductStoreDefault.fk_currency', $currentCurrencyId, Criteria::EQUAL);

        if ($priceMode === static::PRICE_MODE_GROSS) {
            $productAbstractQuery->addAnd(
                $this->getBasicModelCriterion(
                    $productAbstractQuery,
                    'priceProductStoreOrigin.gross_price > priceProductStoreDefault.gross_price',
                    'priceProductStoreOrigin.gross_price',
                ),
            );
        }

        if ($priceMode === static::PRICE_MODE_NET) {
            $productAbstractQuery->addAnd(
                $this->getBasicModelCriterion(
                    $productAbstractQuery,
                    'priceProductStoreOrigin.net_price > priceProductStoreDefault.net_price',
                    'priceProductStoreOrigin.net_price',
                ),
            );
        }

        return $productAbstractQuery;
    }
}
