<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsPageSearch;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\CmsPageSearch\CmsPageSearchConfig as SprykerCmsPageSearchConfig;

class CmsPageSearchConfig extends SprykerCmsPageSearchConfig
{
    /**
     * @return string|null
     */
    public function getCmsPageSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
