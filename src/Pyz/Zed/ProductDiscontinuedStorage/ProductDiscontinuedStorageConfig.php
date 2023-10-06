<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductDiscontinuedStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\ProductDiscontinuedStorage\ProductDiscontinuedStorageConfig as SprykerProductDiscontinuedStorageConfig;

class ProductDiscontinuedStorageConfig extends SprykerProductDiscontinuedStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductDiscontinuedSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    /**
     * @return string|null
     */
    public function getEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
