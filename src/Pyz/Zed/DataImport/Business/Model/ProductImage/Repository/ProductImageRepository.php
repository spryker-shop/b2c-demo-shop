<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model\ProductImage\Repository;

use Orm\Zed\ProductImage\Persistence\SpyProductImage;
use Orm\Zed\ProductImage\Persistence\SpyProductImageQuery;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSet;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSetQuery;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSetToProductImage;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSetToProductImageQuery;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    /**
     * @var array<\Orm\Zed\ProductImage\Persistence\SpyProductImageSet>
     */
    protected $resolvedProductImageSets = [];

    /**
     * @var array<\Orm\Zed\ProductImage\Persistence\SpyProductImage>
     */
    protected $resolvedProductImages = [];

    /**
     * @var array<\Orm\Zed\ProductImage\Persistence\SpyProductImageSetToProductImage>
     */
    protected $resolvedProductImageSetToProductImageRelations = [];

    public function getProductImageSetEntity(
        string $name,
        int $localeId,
        ?int $productAbstractId = null,
        ?int $productConcreteId = null,
        ?string $productImageSetKey = null,
    ): SpyProductImageSet {
        $key = $this->buildProductImageSetKey($name, $localeId, $productAbstractId, $productConcreteId, $productImageSetKey);

        if (!isset($this->resolvedProductImageSets[$key])) {
            $this->resolvedProductImageSets[$key] = $this->getProductImageSet($name, $localeId, $productAbstractId, $productConcreteId, $productImageSetKey);
        }

        return $this->resolvedProductImageSets[$key];
    }

    public function getProductImageEntity(string $productImageKey): SpyProductImage
    {
        if (!isset($this->resolvedProductImages[$productImageKey])) {
            $this->resolvedProductImages[$productImageKey] = $this->getProductImage($productImageKey);
        }

        return $this->resolvedProductImages[$productImageKey];
    }

    public function getProductImageSetToProductImageRelationEntity(
        int $productImageSetId,
        int $productImageId,
    ): SpyProductImageSetToProductImage {
        $key = $this->buildProductImageSetToProductImageRelationKey($productImageSetId, $productImageId);

        if (!isset($this->resolvedProductImageSetToProductImageRelations[$key])) {
            $this->resolvedProductImageSetToProductImageRelations[$key] = $this->getProductImageSetToProductImageRelation($productImageSetId, $productImageId);
        }

        return $this->resolvedProductImageSetToProductImageRelations[$key];
    }

    protected function getProductImage(string $productImageKey): SpyProductImage
    {
        $productImageEntity = SpyProductImageQuery::create()
            ->filterByProductImageKey($productImageKey)
            ->findOne();

        if ($productImageEntity) {
            return $productImageEntity;
        }

        return new SpyProductImage();
    }

    protected function buildProductImageSetToProductImageRelationKey(
        int $productImageSetId,
        int $productImageId,
    ): string {
        return sprintf('%d:%d', $productImageSetId, $productImageId);
    }

    protected function getProductImageSetToProductImageRelation(
        int $productImageSetId,
        int $productImageId,
    ): SpyProductImageSetToProductImage {
        return SpyProductImageSetToProductImageQuery::create()
            ->filterByFkProductImageSet($productImageSetId)
            ->filterByFkProductImage($productImageId)
            ->findOneOrCreate();
    }

    protected function buildProductImageSetKey(
        string $name,
        int $localeId,
        ?int $productAbstractId = null,
        ?int $productConcreteId = null,
        ?string $productImageSetKey = null,
    ): string {
        return $productImageSetKey ?? sprintf(
            '%s:%d:%d:%d',
            $name,
            $localeId,
            $productAbstractId ?? 0,
            $productConcreteId ?? 0,
        );
    }

    protected function getProductImageSet(
        string $name,
        int $localeId,
        ?int $productAbstractId = null,
        ?int $productConcreteId = null,
        ?string $productImageSetKey = null,
    ): SpyProductImageSet {
        $query = SpyProductImageSetQuery::create()
            ->filterByName($name)
            ->filterByFkLocale($localeId);

        if ($productAbstractId) {
            $query->filterByFkProductAbstract($productAbstractId);
        }

        if ($productConcreteId) {
            $query->filterByFkProduct($productConcreteId);
        }

        if ($productImageSetKey) {
            $query->filterByProductImageSetKey($productImageSetKey);
        }

        return $query->findOneOrCreate();
    }
}
