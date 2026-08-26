<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model\Product\Repository;

use Generated\Shared\Transfer\PaginationTransfer;
use Orm\Zed\Product\Persistence\SpyProduct;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Propel\Runtime\Collection\ArrayCollection;

interface ProductRepositoryInterface
{
    public function getIdProductByConcreteSku(string $sku): int;

    public function getAbstractSkuByConcreteSku(string $sku): string;

    public function getIdProductAbstractByAbstractSku(string $sku): int;

    /**
     * @return array<string>
     */
    public function getSkuProductAbstractList(): array;

    /**
     * @return array<string>
     */
    public function getSkuProductConcreteList(): array;

    public function getProductConcreteAttributesCollection(PaginationTransfer $paginationTransfer): ArrayCollection;

    public function addProductAbstract(SpyProductAbstract $productAbstractEntity): void;

    public function addProductConcrete(SpyProduct $productEntity, ?string $abstractSku = null): void;

    public function flush(): void;
}
