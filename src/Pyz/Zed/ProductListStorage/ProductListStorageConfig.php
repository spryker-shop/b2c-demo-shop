<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductListStorage;

use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\ProductListStorage\ProductListStorageConfig as SprykerProductListStorageConfig;

class ProductListStorageConfig extends SprykerProductListStorageConfig
{
    /**
     * @return string|null
     */
    public function getProductAbstractProductListEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }

    /**
     * @return string|null
     */
    public function getProductConcreteProductListEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
