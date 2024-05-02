<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\Product\Repository;

use Generated\Shared\Transfer\PaginationTransfer;
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
    /**
     * @var string
     */
    public const ID_PRODUCT = 'idProduct';

    /**
     * @var string
     */
    public const ID_PRODUCT_ABSTRACT = 'idProductAbstract';

    /**
     * @var string
     */
    public const ABSTRACT_SKU = 'abstractSku';

    /**
     * @var array<string, array<string, mixed>>
     */
    protected static $resolved = [];

    /**
     * @param string $sku
     *
     * @return int
     */
    public function getIdProductByConcreteSku($sku): int
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
    public function getAbstractSkuByConcreteSku($sku): string
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
    public function getIdProductAbstractByAbstractSku($sku): int
    {
        if (!isset(static::$resolved[$sku])) {
            $this->resolveProductByAbstractSku($sku);
        }

        return static::$resolved[$sku][static::ID_PRODUCT_ABSTRACT];
    }

    /**
     * @return array<string>
     */
    public function getSkuProductAbstractList(): array
    {
        /** @var \Propel\Runtime\Collection\ArrayCollection $productAbstractEntities */
        $productAbstractEntities = SpyProductAbstractQuery::create()
            ->select([SpyProductAbstractTableMap::COL_SKU])
            ->find();

        return $productAbstractEntities->toArray();
    }

    /**
     * @return array<string>
     */
    public function getSkuProductConcreteList(): array
    {
        /** @var \Propel\Runtime\Collection\ArrayCollection $productEntities */
        $productEntities = SpyProductQuery::create()
            ->select([SpyProductTableMap::COL_SKU])
            ->find();

        return $productEntities->toArray();
    }

    /**
     * @param \Generated\Shared\Transfer\PaginationTransfer $paginationTransfer
     *
     * @return \Propel\Runtime\Collection\ArrayCollection
     */
    public function getProductConcreteAttributesCollection(PaginationTransfer $paginationTransfer): ArrayCollection
    {
        $productQuery = SpyProductQuery::create()
            ->joinWithSpyProductAbstract()
            ->select([SpyProductTableMap::COL_ATTRIBUTES, SpyProductTableMap::COL_SKU, SpyProductAbstractTableMap::COL_SKU]);

        $productQuery = $this->applyPagination($productQuery, $paginationTransfer);

        /** @phpstan-var \Propel\Runtime\Collection\ArrayCollection */
        return $productQuery->find();
    }

    /**
     * @param string $sku
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return void
     */
    private function resolveProductByConcreteSku($sku): void
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
    private function resolveProductByAbstractSku($sku): void
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
    public function addProductAbstract(SpyProductAbstract $productAbstractEntity): void
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
    public function addProductConcrete(SpyProduct $productEntity, $abstractSku = null): void
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

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProductQuery $productQuery
     * @param \Generated\Shared\Transfer\PaginationTransfer $paginationTransfer
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductQuery
     */
    protected function applyPagination(SpyProductQuery $productQuery, PaginationTransfer $paginationTransfer): SpyProductQuery
    {
        if ($paginationTransfer->getOffset() === null || $paginationTransfer->getLimit() === null) {
            return $productQuery;
        }

        return $productQuery
            ->offset($paginationTransfer->getOffsetOrFail())
            ->setLimit($paginationTransfer->getLimitOrFail());
    }
}
