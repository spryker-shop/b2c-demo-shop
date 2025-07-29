<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductStorage\Persistence;

use Orm\Zed\ProductBundle\Persistence\SpyProductBundleQuery;
use Spryker\Zed\ProductStorage\Persistence\ProductStoragePersistenceFactory as SprykerProductStoragePersistenceFactory;

/**
 * @method \Pyz\Zed\ProductStorage\ProductStorageConfig getConfig()
 * @method \Pyz\Zed\ProductStorage\Persistence\ProductStorageQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\ProductStorage\Persistence\ProductStorageRepositoryInterface getRepository()
 */
class ProductStoragePersistenceFactory extends SprykerProductStoragePersistenceFactory
{
    /**
     * @return \Orm\Zed\ProductBundle\Persistence\SpyProductBundleQuery
     */
    public function getProductBundleQuery(): SpyProductBundleQuery
    {
        return SpyProductBundleQuery::create();
    }
}
