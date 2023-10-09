<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductConfigurationStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\ProductConfigurationStorage\ProductConfigurationStorageConfig as SprykerProductConfigurationStorageConfig;

class ProductConfigurationStorageConfig extends SprykerProductConfigurationStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductConfigurationSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
