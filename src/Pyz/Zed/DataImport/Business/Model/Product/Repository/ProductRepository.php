<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\Product\Repository;

use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Orm\Zed\Product\Persistence\SpyProduct;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\Product\Persistence\SpyProductQuery;
use Propel\Runtime\Collection\ArrayCollection;
use Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException;

class ProductRepository implements ProductRepositoryInterface
{
    public const ID_PRODUCT = 'idProduct';
    public const ID_PRODUCT_ABSTRACT = 'idProductAbstract';
    public const ABSTRACT_SKU = 'abstractSku';

    /**
     * @var array
     */
    protected static $resolved = [];

    /**
     * @param string $sku
     *
     * @return int
     */
    public function getIdProductByConcreteSku($sku)
    {
        if (!isset(static::$resolved[$sku])) {
            $this->resolveProductByConcreteSku($sku);
        }

        return static::$resolved[$sku][static::ID_PRODUCT];
    }

    /**
     * @param string $sku
     *
     * @return string
     */
    public function getAbstractSkuByConcreteSku($sku)
    {
        if (!isset(static::$resolved[$sku])) {
            $this->resolveProductByConcreteSku($sku);
        }

        return static::$resolved[$sku][static::ABSTRACT_SKU];
    }

    /**
     * @param string $sku
     *
     * @return int
     */
    public function getIdProductAbstractByAbstractSku($sku)
    {
        if (!isset(static::$resolved[$sku])) {
            $this->resolveProductByAbstractSku($sku);
        }

        return static::$resolved[$sku][static::ID_PRODUCT_ABSTRACT];
    }

    /**
     * @return string[]
     */
    public function getSkuProductAbstractList(): array
    {
        return SpyProductAbstractQuery::create()
            ->select([SpyProductAbstractTableMap::COL_SKU])
            ->find()
            ->toArray();
    }

    /**
     * @return string[]
     */
    public function getSkuProductConcreteList(): array
    {
        return SpyProductQuery::create()
            ->select([SpyProductTableMap::COL_SKU])
            ->find()
            ->toArray();
    }

    /**
     * @return \Propel\Runtime\Collection\ArrayCollection
     */
    public function getProductConcreteAttributesCollection(): ArrayCollection
    {
        /** @var \Propel\Runtime\Collection\ArrayCollection $productData */
        $productData = SpyProductQuery::create()
            ->joinWithSpyProductAbstract()
            ->select([SpyProductTableMap::COL_ATTRIBUTES, SpyProductTableMap::COL_SKU, SpyProductAbstractTableMap::COL_SKU])
            ->find();

        return $productData;
    }

    /**
     * @param string $sku
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return void
     */
    private function resolveProductByConcreteSku($sku)
    {
        $productEntity = SpyProductQuery::create()
            ->joinWithSpyProductAbstract()
            ->findOneBySku($sku);

        if (!$productEntity) {
            throw new EntityNotFoundException(sprintf('Concrete product by sku "%s" not found.', $sku));
        }

        static::$resolved[$sku] = [
            static::ID_PRODUCT => $productEntity->getIdProduct(),
            static::ABSTRACT_SKU => $productEntity->getSpyProductAbstract()->getSku(),
        ];
    }

    /**
     * @param string $sku
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return void
     */
    private function resolveProductByAbstractSku($sku)
    {
        $productAbstractEntity = SpyProductAbstractQuery::create()
            ->findOneBySku($sku);

        if (!$productAbstractEntity) {
            throw new EntityNotFoundException(sprintf('Abstract product by sku "%s" not found.', $sku));
        }

        static::$resolved[$sku] = [
            static::ID_PRODUCT_ABSTRACT => $productAbstractEntity->getIdProductAbstract(),
        ];
    }

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProductAbstract $productAbstractEntity
     *
     * @return void
     */
    public function addProductAbstract(SpyProductAbstract $productAbstractEntity)
    {
        static::$resolved[$productAbstractEntity->getSku()] = [
            static::ID_PRODUCT_ABSTRACT => $productAbstractEntity->getIdProductAbstract(),
        ];
    }

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProduct $productEntity
     * @param string|null $abstractSku
     *
     * @return void
     */
    public function addProductConcrete(SpyProduct $productEntity, $abstractSku = null)
    {
        static::$resolved[$productEntity->getSku()] = [
            static::ID_PRODUCT => $productEntity->getIdProduct(),
            static::ABSTRACT_SKU => ($abstractSku) ? $abstractSku : $productEntity->getSpyProductAbstract()->getSku(),
        ];
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        static::$resolved = [];
    }
}
