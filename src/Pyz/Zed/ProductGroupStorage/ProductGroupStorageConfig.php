<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductGroupStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\ProductGroupStorage\ProductGroupStorageConfig as SprykerProductGroupStorageConfig;

class ProductGroupStorageConfig extends SprykerProductGroupStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductGroupSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
