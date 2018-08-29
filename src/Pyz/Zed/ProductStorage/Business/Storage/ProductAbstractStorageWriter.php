<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductStorage\Business\Storage;

use Generated\Shared\Transfer\ProductAbstractStorageTransfer;
use Orm\Zed\ProductStorage\Persistence\SpyProductAbstractStorage;
use Spryker\Zed\ProductStorage\Business\Storage\ProductAbstractStorageWriter as SprykerProductAbstractStorageWriter;

class ProductAbstractStorageWriter extends SprykerProductAbstractStorageWriter
{
     const COL_FK_PRODUCT_SET = 'fk_product_set';

    /**
     * @var \Pyz\Zed\ProductStorage\Persistence\ProductStorageQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @param array $productAbstractLocalizedEntity
     * @param \Generated\Shared\Transfer\ProductAbstractStorageTransfer $productAbstractStorageTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractStorageTransfer
     */
    protected function mapToProductAbstractStorageTransfer(
        array $productAbstractLocalizedEntity,
        ProductAbstractStorageTransfer $productAbstractStorageTransfer
    ) {
        $productAbstractStorageTransfer = parent::mapToProductAbstractStorageTransfer($productAbstractLocalizedEntity, $productAbstractStorageTransfer);

        $productAbstractStorageTransfer->setProductSetIds([]);

        if (isset($productAbstractLocalizedEntity['SpyProductAbstract']['SpyProductAbstractSets'])) {
            $productSetIds = [];
            foreach ($productAbstractLocalizedEntity['SpyProductAbstract']['SpyProductAbstractSets'] as $productAbstractSet) {
                if (isset($productAbstractSet[static::COL_FK_PRODUCT_SET])) {
                    $productSetIds[] = $productAbstractSet[static::COL_FK_PRODUCT_SET];
                }
            }

            $productAbstractStorageTransfer->setProductSetIds($productSetIds);
        }

        return $productAbstractStorageTransfer;
    }

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

    /**
     * @param int $idProductConcrete
     * @return array
     */
    protected function getBundledProductIdsByProductConcreteId($idProductConcrete)
    {
        return $this->queryContainer->queryBundledProductIdsByProductConcreteId($idProductConcrete)->find()->getArrayCopy();
    }
}
