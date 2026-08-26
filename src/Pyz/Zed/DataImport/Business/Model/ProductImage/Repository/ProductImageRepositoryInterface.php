<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model\ProductImage\Repository;

use Orm\Zed\ProductImage\Persistence\SpyProductImage;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSet;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSetToProductImage;

interface ProductImageRepositoryInterface
{
    public function getProductImageSetEntity(
        string $name,
        int $localeId,
        ?int $productAbstractId = null,
        ?int $productConcreteId = null,
        ?string $productImageSetKey = null,
    ): SpyProductImageSet;

    public function getProductImageEntity(string $productImageKey): SpyProductImage;

    public function getProductImageSetToProductImageRelationEntity(
        int $productImageSetId,
        int $productImageId,
    ): SpyProductImageSetToProductImage;
}
