<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Persistence;

use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePagePersistenceFactory getFactory()
 */
class ExampleProductSalePageQueryContainer extends AbstractQueryContainer implements ExampleProductSalePageQueryContainerInterface
{
    protected const PRICE_TYPE_ORIGINAL = 'ORIGINAL';
    protected const PRICE_TYPE_DEFAULT = 'DEFAULT';

    /**
     * @param string $labelName
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabelQuery
     * @api
     *
     */
    public function queryProductLabelByName($labelName)
    {
        return $this->getFactory()
            ->getProductLabelQueryContainer()
            ->queryProductLabelByName($labelName);
    }

    /**
     * @param int $idProductLabel
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery
     * @api
     *
     */
    public function queryRelationsBecomingInactive($idProductLabel)
    {

        return $this->getFactory()
            ->getProductLabelQueryContainer()
            ->queryProductAbstractRelationsByIdProductLabel($idProductLabel)
            ->distinct()
            ->useSpyProductAbstractQuery(null, Criteria::LEFT_JOIN)
                ->usePriceProductQuery('priceProductOrigin', Criteria::LEFT_JOIN)
                    ->joinPriceType('priceTypeOrigin', Criteria::INNER_JOIN)
                    ->addJoinCondition(
                        'priceTypeOrigin',
                        'priceTypeOrigin.name = ?',
                        static::PRICE_TYPE_ORIGINAL
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
                        static::PRICE_TYPE_DEFAULT
                    )
                    ->usePriceProductStoreQuery('priceProductStoreDefault', Criteria::LEFT_JOIN)
                        ->usePriceProductDefaultQuery('priceProductDefaultDefault', Criteria::LEFT_JOIN)
                        ->endUse()
                    ->endUse()
                ->endUse()
            ->endUse()
            ->addAnd('priceProductDefaultOriginal.id_price_product_default', null, Criteria::ISNOTNULL)
            ->addAnd('priceProductDefaultDefault.id_price_product_default', null, Criteria::ISNOTNULL)
            ->condition('equalStore', 'priceProductStoreOrigin.fk_store = priceProductStoreDefault.fk_store')
            ->condition('equalCurrency', 'priceProductStoreOrigin.fk_currency = priceProductStoreDefault.fk_currency')
            ->condition('originGrossPriceLessThanDefaultPrice', 'priceProductStoreOrigin.gross_price < priceProductStoreDefault.gross_price')
            ->condition('isNullOriginGrossPrice', 'priceProductStoreOrigin.gross_price  ' . Criteria::ISNULL)
            ->condition('isNullOriginNetPrice', 'priceProductStoreOrigin.net_price  ' . Criteria::ISNULL)
            ->condition('originNetPriceLessThanDefaultPrice', 'priceProductStoreOrigin.net_price < priceProductStoreDefault.net_price')
            ->condition('isNullDefaultNetPrice', 'priceProductStoreDefault.net_price  ' . Criteria::ISNULL)
            ->condition('isNullDefaultGrossPrice', 'priceProductStoreDefault.gross_price  ' . Criteria::ISNULL)
            ->combine([
                'originGrossPriceLessThanDefaultPrice',
                'originNetPriceLessThanDefaultPrice',
                'isNullOriginGrossPrice',
                'isNullOriginNetPrice',
                'isNullDefaultNetPrice',
                'isNullDefaultGrossPrice',
            ], Criteria::LOGICAL_OR, 'condOr')
            ->combine(['equalStore', 'equalCurrency'], Criteria::LOGICAL_AND, 'condAnd')
            ->where(['condOr', 'condAnd'], Criteria::LOGICAL_AND);
    }

    /**
     * @param int $idProductLabel
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     * @api
     *
     */
    public function queryRelationsBecomingActive($idProductLabel)
    {

        return $this->getFactory()
            ->getProductQueryContainer()
            ->queryProductAbstract()
            ->distinct()
            ->usePriceProductQuery('priceProductOrigin', Criteria::LEFT_JOIN)
                ->joinPriceType('priceTypeOrigin', Criteria::INNER_JOIN)
                ->addJoinCondition(
                    'priceTypeOrigin',
                    'priceTypeOrigin.name = ?',
                    static::PRICE_TYPE_ORIGINAL
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
                    static::PRICE_TYPE_DEFAULT
                )
                ->usePriceProductStoreQuery('priceProductStoreDefault', Criteria::LEFT_JOIN)
                    ->usePriceProductDefaultQuery('priceProductDefaultDefault', Criteria::LEFT_JOIN)
                    ->endUse()
                ->endUse()
            ->endUse()
            ->useSpyProductLabelProductAbstractQuery('rel', Criteria::LEFT_JOIN)
                ->filterByFkProductLabel(null, Criteria::ISNULL)
            ->endUse()
            ->addJoinCondition('rel', sprintf('rel.fk_product_label = %d', $idProductLabel))
            ->addAnd('rel.fk_product_label', null, Criteria::ISNULL)
            ->addAnd('priceProductDefaultOriginal.id_price_product_default', null, Criteria::ISNOTNULL)
            ->addAnd('priceProductDefaultDefault.id_price_product_default', null, Criteria::ISNOTNULL)
            ->addAnd('priceProductStoreOrigin.gross_price', null, Criteria::ISNOTNULL)
            ->addAnd('priceProductStoreOrigin.net_price', null, Criteria::ISNOTNULL)
            ->condition('equalStore', 'priceProductStoreOrigin.fk_store = priceProductStoreDefault.fk_store')
            ->condition('equalCurrency', 'priceProductStoreOrigin.fk_currency = priceProductStoreDefault.fk_currency')
            ->condition('originGrossPriceMoreThanDefaultPrice', 'priceProductStoreOrigin.gross_price > priceProductStoreDefault.gross_price')
            ->condition('originNetPriceMoreThanDefaultPrice', 'priceProductStoreOrigin.net_price > priceProductStoreDefault.net_price')
            ->where([
                'equalStore',
                'equalCurrency',
                'originGrossPriceMoreThanDefaultPrice',
                'originNetPriceMoreThanDefaultPrice',
            ], Criteria::LOGICAL_AND);
    }
}
