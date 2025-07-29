<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\SalesReturnSearch;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\SalesReturnSearch\SalesReturnSearchConfig as SprykerSalesReturnSearchConfig;

class SalesReturnSearchConfig extends SprykerSalesReturnSearchConfig
{
    /**
     * @return string|null
     */
    public function getReturnReasonSearchSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
