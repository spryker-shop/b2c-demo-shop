<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductStorage\Business\Storage;

use Generated\Shared\Transfer\ProductConcreteStorageTransfer;
use Spryker\Zed\ProductStorage\Business\Storage\ProductConcreteStorageWriter as SprykerProductConcreteStorageWriter;

/**
 * @property \Pyz\Zed\ProductStorage\Persistence\ProductStorageQueryContainerInterface $queryContainer
 */
class ProductConcreteStorageWriter extends SprykerProductConcreteStorageWriter
{
    /**
     * @param array $productConcreteLocalizedEntity
     *
     * @return \Generated\Shared\Transfer\ProductConcreteStorageTransfer
     */
    protected function mapToProductConcreteStorageTransfer(array $productConcreteLocalizedEntity)
    {
        $attributes = $this->getConcreteAttributes($productConcreteLocalizedEntity);

        $spyProductConcreteEntityArray = $productConcreteLocalizedEntity['SpyProduct'];
        unset($productConcreteLocalizedEntity['attributes']);
        unset($spyProductConcreteEntityArray['attributes']);

        $bundledProductIds = $this->getBundledProductIdsByProductConcreteId($spyProductConcreteEntityArray['id_product']);

        $productStorageTransfer = (new ProductConcreteStorageTransfer())
            ->fromArray($productConcreteLocalizedEntity, true)
            ->fromArray($spyProductConcreteEntityArray, true)
            ->setBundledProductIds($bundledProductIds)
            ->setIdProductConcrete($productConcreteLocalizedEntity[static::COL_FK_PRODUCT])
            ->setIdProductAbstract($spyProductConcreteEntityArray[static::COL_FK_PRODUCT_ABSTRACT])
            ->setDescription($this->getDescription($productConcreteLocalizedEntity))
            ->setAttributes($attributes)
            ->setSuperAttributesDefinition($this->getSuperAttributeKeys($attributes));

        return $productStorageTransfer;
    }

    /**
     * @param int $idProductConcrete
     *
     * @return array
     */
    protected function getBundledProductIdsByProductConcreteId($idProductConcrete)
    {
        $result = [];
        $bundleProducts = $this->queryContainer->queryBundledProductIdsByProductConcreteId($idProductConcrete)->find()->toArray();
        foreach ($bundleProducts as $bundleProduct) {
            $result[$bundleProduct['FkBundledProduct']] = $bundleProduct['Quantity'];
        }

        return $result;
    }
}
