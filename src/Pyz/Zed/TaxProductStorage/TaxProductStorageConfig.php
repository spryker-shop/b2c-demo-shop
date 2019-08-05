<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\TaxProductStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\TaxProductStorage\TaxProductStorageConfig as SprykerTaxProductStorageConfig;

class TaxProductStorageConfig extends SprykerTaxProductStorageConfig
{
    /**
     * @return string|null
     */
    public function getTaxProductSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
