<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailWidget\Persistence;

use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Pyz\Zed\ProductDetailWidget\Persistence\Mapper\ProductAbstractMapper;
use Pyz\Zed\ProductDetailWidget\Persistence\Mapper\ProductAbstractMapperInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\ProductDetailWidget\ProductDetailWidgetConfig getConfig()
 * @method \Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailRepositoryInterface getRepository()
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
     * @return \Pyz\Zed\ProductDetailWidget\Persistence\Mapper\ProductAbstractMapperInterface
     */
    public function createProductAbstractMapper(): ProductAbstractMapperInterface
    {
        return new ProductAbstractMapper();
    }
}
