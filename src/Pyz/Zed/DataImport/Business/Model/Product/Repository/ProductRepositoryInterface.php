<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\Product\Repository;

use Orm\Zed\Product\Persistence\SpyProduct;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Propel\Runtime\Collection\ArrayCollection;

interface ProductRepositoryInterface
{
    /**
     * @param string $sku
     *
     * @return int
     */
    public function getIdProductByConcreteSku($sku);

    /**
     * @param string $sku
     *
     * @return string
     */
    public function getAbstractSkuByConcreteSku($sku);

    /**
     * @param string $sku
     *
     * @return int
     */
    public function getIdProductAbstractByAbstractSku($sku);

    /**
     * @return string[]
     */
    public function getSkuProductAbstractList(): array;

    /**
     * @return string[]
     */
    public function getSkuProductConcreteList(): array;

    /**
     * @return \Propel\Runtime\Collection\ArrayCollection
     */
    public function getProductConcreteAttributesCollection(): ArrayCollection;

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProductAbstract $productAbstractEntity
     *
     * @return void
     */
    public function addProductAbstract(SpyProductAbstract $productAbstractEntity);

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProduct $productEntity
     * @param string|null $abstractSku
     *
     * @return void
     */
    public function addProductConcrete(SpyProduct $productEntity, $abstractSku = null);

    /**
     * @return void
     */
    public function flush(): void;
}
