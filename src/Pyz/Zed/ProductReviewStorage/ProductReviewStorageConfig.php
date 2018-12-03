<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductReviewStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\ProductReviewStorage\ProductReviewStorageConfig as SprykerProductReviewStorageConfig;

class ProductReviewStorageConfig extends SprykerProductReviewStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductAbstractReviewSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
