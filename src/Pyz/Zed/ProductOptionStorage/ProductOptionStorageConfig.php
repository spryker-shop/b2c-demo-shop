<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductOptionStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\ProductOptionStorage\ProductOptionStorageConfig as SprykerProductOptionStorageConfig;

class ProductOptionStorageConfig extends SprykerProductOptionStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductAbstractOptionSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
