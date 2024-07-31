<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailPageWidget\Persistence\Mapper;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductAbstractCollectionTransfer;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Propel\Runtime\Collection\Collection;

class ProductAbstractMapper implements ProductAbstractMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param \Orm\Zed\Product\Persistence\SpyProductAbstract $productAbstractEntity
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstract
     */
    public function mapProductAbstractTransferToEntity(
        ProductAbstractTransfer $productAbstractTransfer,
        SpyProductAbstract $productAbstractEntity
    ): SpyProductAbstract {
        $productAbstractEntity->fromArray(
            $productAbstractTransfer->modifiedToArray(false),
        );

        return $productAbstractEntity;
    }

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProductAbstract $productAbstractEntity
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function mapEntityToProductAbstractTransfer(
        SpyProductAbstract $productAbstractEntity,
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer {
        return $productAbstractTransfer->fromArray(
            $productAbstractEntity->toArray(),
            true,
        );
    }
}
