<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductLabelStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\ProductLabelStorage\ProductLabelStorageConfig as SprykerProductLabelStorageConfig;

class ProductLabelStorageConfig extends SprykerProductLabelStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductAbstractLabelSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    /**
     * @return string|null
     */
    public function getProductLabelDictionarySynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    /**
     * @return string|null
     */
    public function getProductAbstractLabelEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }

    /**
     * @return string|null
     */
    public function getProductLabelDictionaryEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
