<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductReviewSearch;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\ProductReviewSearch\ProductReviewSearchConfig as SprykerProductReviewSearchConfig;

class ProductReviewSearchConfig extends SprykerProductReviewSearchConfig
{
    /**
     * @return string|null
     */
    public function getProductReviewSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
