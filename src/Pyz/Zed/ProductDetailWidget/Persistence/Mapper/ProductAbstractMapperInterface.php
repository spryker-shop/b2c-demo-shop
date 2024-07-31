<?php

namespace Pyz\Zed\ProductDetailPageWidget\Persistence\Mapper;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductAbstractCollectionTransfer;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Propel\Runtime\Collection\Collection;

interface ProductAbstractMapperInterface
{
    /**
     * Maps a ProductAbstractTransfer to a SpyProductAbstract entity.
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param \Orm\Zed\Product\Persistence\SpyProductAbstract $productAbstractEntity
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstract
     */
    public function mapProductAbstractTransferToEntity(
        ProductAbstractTransfer $productAbstractTransfer,
        SpyProductAbstract $productAbstractEntity
    ): SpyProductAbstract;

    /**
     * Maps a SpyProductAbstract entity to a ProductAbstractTransfer.
     *
     * @param \Orm\Zed\Product\Persistence\SpyProductAbstract $productAbstractEntity
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function mapEntityToProductAbstractTransfer(
        SpyProductAbstract $productAbstractEntity,
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer;
}
