<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBundleStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\ProductBundleStorage\ProductBundleStorageConfig as SprykerProductBundleStorageConfig;

class ProductBundleStorageConfig extends SprykerProductBundleStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductBundleSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
