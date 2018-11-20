<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductSetStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\ProductSetStorage\ProductSetStorageConfig as SprykerProductSetStorageConfig;

class ProductSetStorageConfig extends SprykerProductSetStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductSetSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
