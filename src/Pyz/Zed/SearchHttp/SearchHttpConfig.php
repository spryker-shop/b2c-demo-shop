<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\SearchHttp;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\SearchHttp\SearchHttpConfig as SprykerSearchHttpConfig;

class SearchHttpConfig extends SprykerSearchHttpConfig
{
    /**
     * @return string|null
     */
    public function getSearchHttpSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
