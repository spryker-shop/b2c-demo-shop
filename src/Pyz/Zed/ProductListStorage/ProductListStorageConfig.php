<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
