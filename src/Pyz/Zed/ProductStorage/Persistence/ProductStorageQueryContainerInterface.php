<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductStorage\Persistence;

use Orm\Zed\ProductBundle\Persistence\SpyProductBundleQuery;
use Spryker\Zed\ProductStorage\Persistence\ProductStorageQueryContainerInterface as SprykerProductStorageQueryContainerInterface;

interface ProductStorageQueryContainerInterface extends SprykerProductStorageQueryContainerInterface
{
    /**
     * @api
     *
     * @param int $idProductConcrete
     *
     * @return \Orm\Zed\ProductBundle\Persistence\SpyProductBundleQuery
     */
    public function queryBundledProductIdsByProductConcreteId(int $idProductConcrete): SpyProductBundleQuery;

    /**
     * @api
     *
     * @param int $idProductConcrete
     *
     * @return \Orm\Zed\ProductBundle\Persistence\SpyProductBundleQuery
     */
    public function queryBundleProduct(int $idProductConcrete): SpyProductBundleQuery;
}
