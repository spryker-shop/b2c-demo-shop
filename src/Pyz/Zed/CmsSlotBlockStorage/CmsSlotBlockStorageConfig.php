<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsSlotBlockStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\CmsSlotBlockStorage\CmsSlotBlockStorageConfig as SprykerCmsSlotBlockStorageConfig;

class CmsSlotBlockStorageConfig extends SprykerCmsSlotBlockStorageConfig
{
    /**
     * @return string|null
     */
    public function getCmsSlotBlockSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
