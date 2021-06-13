<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AvailabilityStorage;

use Spryker\Shared\AvailabilityStorage\AvailabilityStorageConfig as SprykerSharedAvailabilityStorageConfig;
use Spryker\Zed\AvailabilityStorage\AvailabilityStorageConfig as SprykerAvailabilityStorageConfig;

class AvailabilityStorageConfig extends SprykerAvailabilityStorageConfig
{
    /**
     * @return string|null
     */
    public function getEventQueueName(): ?string
    {
        return SprykerSharedAvailabilityStorageConfig::PUBLISH_AVAILABILITY;
    }
}
