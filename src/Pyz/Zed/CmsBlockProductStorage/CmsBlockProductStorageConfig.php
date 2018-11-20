<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsBlockProductStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\CmsBlockProductStorage\CmsBlockProductStorageConfig as SprykerCmsBlockProductStorageConfig;

class CmsBlockProductStorageConfig extends SprykerCmsBlockProductStorageConfig
{
    /**
     * @return string|null
     */
    public function getCmsBlockProductSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
