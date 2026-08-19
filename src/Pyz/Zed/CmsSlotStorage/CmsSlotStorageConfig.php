<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\CmsSlotStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\CmsSlotStorage\CmsSlotStorageConfig as SprykerCmsSlotStorageConfig;

class CmsSlotStorageConfig extends SprykerCmsSlotStorageConfig
{
    public function getCmsSlotStorageSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    public function getEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
