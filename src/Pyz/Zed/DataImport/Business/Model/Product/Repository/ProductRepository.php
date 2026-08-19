<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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

    public function getIdProductByConcreteSku(string $sku): int
    {
        if (!isset(static::$resolved[$sku])) {
            $this->resolveProductByConcreteSku($sku);
        }

        return static::$resolved[$sku][static::ID_PRODUCT];
    }

    public function getAbstractSkuByConcreteSku(string $sku): string
    {
        if (!isset(static::$resolved[$sku])) {
            $this->resolveProductByConcreteSku($sku);
        }

        return static::$resolved[$sku][static::ABSTRACT_SKU];
    }

    public function getIdProductAbstractByAbstractSku(string $sku): int
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
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     */
    private function resolveProductByConcreteSku(string $sku): void
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
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     */
    private function resolveProductByAbstractSku(string $sku): void
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

    public function addProductAbstract(SpyProductAbstract $productAbstractEntity): void
    {
        static::$resolved[$productAbstractEntity->getSku()] = [
            static::ID_PRODUCT_ABSTRACT => $productAbstractEntity->getIdProductAbstract(),
        ];
    }

    public function addProductConcrete(SpyProduct $productEntity, ?string $abstractSku = null): void
    {
        static::$resolved[$productEntity->getSku()] = [
            static::ID_PRODUCT => $productEntity->getIdProduct(),
            static::ABSTRACT_SKU => ($abstractSku) ? $abstractSku : $productEntity->getSpyProductAbstract()->getSku(),
        ];
    }

    public function flush(): void
    {
        static::$resolved = [];
    }

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
