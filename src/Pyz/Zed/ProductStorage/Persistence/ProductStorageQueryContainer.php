<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductStorage\Persistence;

use Orm\Zed\Product\Persistence\Map\SpyProductAbstractLocalizedAttributesTableMap;
use Orm\Zed\Url\Persistence\Map\SpyUrlTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\ProductStorage\Persistence\ProductStorageQueryContainer as SprykerProductStorageQueryContainer;

/**
 * @method \Pyz\Zed\ProductStorage\Persistence\ProductStoragePersistenceFactory getFactory()
 */
class ProductStorageQueryContainer extends SprykerProductStorageQueryContainer
{
    /**
     * @api
     *
     * @param array $productAbstractIds
     *
     * @return \Orm\Zed\Availability\Persistence\SpyAvailabilityAbstractQuery|\Orm\Zed\Availability\Persistence\SpyAvailabilityQuery|\Orm\Zed\AvailabilityNotification\Persistence\SpyAvailabilityNotificationSubscriptionQuery|\Orm\Zed\Cms\Persistence\SpyCmsPageStoreQuery|\Orm\Zed\CmsBlock\Persistence\SpyCmsBlockStoreQuery|\Orm\Zed\CmsBlockProductConnector\Persistence\SpyCmsBlockProductConnectorQuery|\Orm\Zed\Discount\Persistence\SpyDiscountQuery|\Orm\Zed\Discount\Persistence\SpyDiscountStoreQuery|\Orm\Zed\GiftCard\Persistence\SpyGiftCardProductAbstractConfigurationLinkQuery|\Orm\Zed\Oms\Persistence\SpyOmsProductReservationQuery|\Orm\Zed\PriceProduct\Persistence\SpyPriceProductQuery|\Orm\Zed\PriceProduct\Persistence\SpyPriceProductStoreQuery|\Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductScheduleQuery|\Orm\Zed\Product\Persistence\SpyProductAbstractLocalizedAttributesQuery|\Orm\Zed\Product\Persistence\SpyProductAbstractStoreQuery|\Orm\Zed\Product\Persistence\SpyProductQuery|\Orm\Zed\ProductAlternative\Persistence\SpyProductAlternativeQuery|\Orm\Zed\ProductCategory\Persistence\SpyProductCategoryQuery|\Orm\Zed\ProductGroup\Persistence\SpyProductAbstractGroupQuery|\Orm\Zed\ProductImage\Persistence\SpyProductImageSetQuery|\Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery|\Orm\Zed\ProductOption\Persistence\SpyProductAbstractProductOptionGroupQuery|\Orm\Zed\ProductOption\Persistence\SpyProductOptionValuePriceQuery|\Orm\Zed\ProductRelation\Persistence\SpyProductRelationProductAbstractQuery|\Orm\Zed\ProductRelation\Persistence\SpyProductRelationQuery|\Orm\Zed\ProductReview\Persistence\SpyProductReviewQuery|\Orm\Zed\ProductSet\Persistence\SpyProductAbstractSetQuery|\Orm\Zed\Quote\Persistence\SpyQuoteQuery|\Orm\Zed\SalesOrderThreshold\Persistence\SpySalesOrderThresholdQuery|\Orm\Zed\Shipment\Persistence\SpyShipmentMethodPriceQuery|\Orm\Zed\Tax\Persistence\SpyTaxSetQuery|\Orm\Zed\Touch\Persistence\SpyTouchSearchQuery|\Orm\Zed\Touch\Persistence\SpyTouchStorageQuery|\Orm\Zed\Url\Persistence\SpyUrlQuery|\Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function queryProductAbstractByIds(array $productAbstractIds)
    {
        $query = $this->getFactory()->getProductQueryContainer()
            ->queryAllProductAbstractLocalizedAttributes()
            ->joinWithLocale()
            ->joinWithSpyProductAbstract()
                ->useSpyProductAbstractQuery()
                    ->leftJoinWithSpyProductAbstractSet()
                    ->joinWithSpyProduct()
                    ->joinWithSpyProductAbstractStore()
                    ->useSpyProductAbstractStoreQuery()
                    ->joinWithSpyStore()
                ->endUse()
            ->endUse()
            ->filterByFkProductAbstract_In($productAbstractIds)
            ->setFormatter(ModelCriteria::FORMAT_ARRAY);

        $query
            ->join('SpyProductAbstract.SpyUrl')
            ->addJoinCondition('SpyUrl', 'spy_url.fk_locale = ' . SpyProductAbstractLocalizedAttributesTableMap::COL_FK_LOCALE)
            ->withColumn(SpyUrlTableMap::COL_URL, 'url');

        return $query;
    }

    /**
     * @api
     *
     * @param int $idProductConcrete
     *
     * @return \Orm\Zed\ProductBundle\Persistence\SpyProductBundleQuery
     */
    public function queryBundledProductIdsByProductConcreteId($idProductConcrete)
    {
        return $this->getFactory()
            ->createProductBundleQuery()
            ->filterByFkProduct($idProductConcrete);
    }
}
