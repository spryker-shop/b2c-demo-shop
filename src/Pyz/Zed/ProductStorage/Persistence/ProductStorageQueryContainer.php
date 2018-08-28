<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductStorage\Persistence;

use Spryker\Zed\ProductStorage\Persistence\ProductStorageQueryContainer as SprykerProductStorageQueryContainer;

/**
 * @method \Pyz\Zed\ProductStorage\Persistence\ProductStoragePersistenceFactory getFactory()
 */
class ProductStorageQueryContainer extends SprykerProductStorageQueryContainer implements ProductStorageQueryContainerInterface
{

    /**
     * @api
     *
     * @param int $idProductConcrete
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractLocalizedAttributesQuery
     */
    public function queryBundledProductIdsByProductConcreteId($idProductConcrete)
    {
        return $this->queryBundleProduct($idProductConcrete)
            ->joinWithSpyProductRelatedByFkBundledProduct();
    }

    /**
     * @api
     *
     * @param int $idProductConcrete
     *
     * @return \Orm\Zed\ProductBundle\Persistence\SpyProductBundleQuery
     */
    public function queryBundleProduct($idProductConcrete)
    {
        return $this->getFactory()
            ->createProductBundleQuery()
            ->filterByFkProduct($idProductConcrete);
    }
}
