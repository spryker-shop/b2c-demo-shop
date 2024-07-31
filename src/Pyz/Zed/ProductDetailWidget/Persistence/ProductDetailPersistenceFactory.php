<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailPageWidget\Persistence;

use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Pyz\Zed\ProductDetailPageWidget\Persistence\Mapper\ProductAbstractMapper;
use Pyz\Zed\ProductDetailPageWidget\Persistence\Mapper\ProductAbstractMapperInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\ProductDetailPageWidget\ProductDetailWidgetConfig getConfig()
 * @method \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailRepositoryInterface getRepository()
 */
class ProductDetailPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function createProductAbstractQuery(): SpyProductAbstractQuery
    {
        return SpyProductAbstractQuery::create();
    }

    /**
     * @return \Pyz\Zed\ProductDetailPageWidget\Persistence\Mapper\ProductAbstractMapperInterface
     */
    public function createProductAbstractMapper(): ProductAbstractMapperInterface
    {
        return new ProductAbstractMapper();
    }
}
