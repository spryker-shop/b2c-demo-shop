<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductRelationStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\ProductRelationStorage\ProductRelationStorageConfig as SprykerProductRelationStorageConfig;

class ProductRelationStorageConfig extends SprykerProductRelationStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductAbstractRelationSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    /**
     * @return string|null
     */
    public function getProductRelationEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
