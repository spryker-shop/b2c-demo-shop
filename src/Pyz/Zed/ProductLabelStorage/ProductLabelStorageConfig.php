<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductLabelStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\ProductLabelStorage\ProductLabelStorageConfig as SprykerProductLabelStorageConfig;

class ProductLabelStorageConfig extends SprykerProductLabelStorageConfig
{
    public function getProductAbstractLabelSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    public function getProductLabelDictionarySynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    public function getProductAbstractLabelEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }

    public function getProductLabelDictionaryEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
