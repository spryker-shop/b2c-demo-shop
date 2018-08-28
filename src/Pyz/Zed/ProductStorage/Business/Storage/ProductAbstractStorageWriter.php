<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductStorage\Business\Storage;

use Generated\Shared\Transfer\ProductAbstractStorageTransfer;
use Orm\Zed\ProductBundle\Persistence\Map\SpyProductBundleTableMap;
use Orm\Zed\ProductStorage\Persistence\SpyProductAbstractStorage;
use Spryker\Zed\ProductStorage\Business\Storage\ProductAbstractStorageWriter as SprykerProductAbstractStorageWriter;

class ProductAbstractStorageWriter extends SprykerProductAbstractStorageWriter implements ProductAbstractStorageWriterInterface
{
    /**
     * @var \Pyz\Zed\ProductStorage\Persistence\ProductStorageQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @param array $productAbstractLocalizedEntity
     * @param \Orm\Zed\ProductStorage\Persistence\SpyProductAbstractStorage $spyProductStorageEntity
     * @param string $storeName
     * @param string $localeName
     *
     * @return void
     */
    protected function storeProductAbstractStorageEntity(
        array $productAbstractLocalizedEntity,
        SpyProductAbstractStorage $spyProductStorageEntity,
        $storeName,
        $localeName
    ) {
        $productAbstractStorageTransfer = $this->mapToProductAbstractStorageTransfer(
            $productAbstractLocalizedEntity,
            new ProductAbstractStorageTransfer()
        );

        $bundledProductIds = $this->getBundledProductIdsByProductConcreteId(array_shift($productAbstractStorageTransfer->getAttributeMap()->getProductConcreteIds()));

        $productAbstractStorageTransfer->setBundledProductIds($bundledProductIds);

        $spyProductStorageEntity
            ->setFkProductAbstract($productAbstractLocalizedEntity['SpyProductAbstract'][static::COL_ID_PRODUCT_ABSTRACT])
            ->setData($productAbstractStorageTransfer->toArray())
            ->setStore($storeName)
            ->setLocale($localeName)
            ->setIsSendingToQueue($this->isSendingToQueue)
            ->save();
    }

    protected function getBundledProductIdsByProductConcreteId($idProductConcrete)
    {
        return $this->queryContainer->queryBundledProductIdsByProductConcreteId($idProductConcrete)->find()->getArrayCopy();
    }
}
