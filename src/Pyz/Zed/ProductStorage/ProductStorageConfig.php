<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Shared\ProductStorage\ProductStorageConfig as SprykerSharedProductStorageConfig;
use Spryker\Zed\ProductStorage\ProductStorageConfig as SprykerProductStorageConfig;

class ProductStorageConfig extends SprykerProductStorageConfig
{
    public function getProductConcreteSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    public function getProductAbstractSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    public function getProductConcreteEventQueueName(): ?string
    {
        return SprykerSharedProductStorageConfig::PUBLISH_PRODUCT_CONCRETE;
    }

    public function getProductAbstractEventQueueName(): ?string
    {
        return SprykerSharedProductStorageConfig::PUBLISH_PRODUCT_ABSTRACT;
    }

    public function isProductAttributesWithSingleValueIncluded(): bool
    {
        return false;
    }

    public function isOptimizedAttributeVariantsMapEnabled(): bool
    {
        return true;
    }
}
