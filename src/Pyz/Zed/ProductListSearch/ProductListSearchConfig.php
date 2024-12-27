<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductListSearch;

use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\ProductListSearch\ProductListSearchConfig as SprykerProductListSearchConfig;

class ProductListSearchConfig extends SprykerProductListSearchConfig
{
    /**
     * @return string|null
     */
    public function getEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
