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
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
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
