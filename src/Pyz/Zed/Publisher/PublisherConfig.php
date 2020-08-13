<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Publisher;

use Spryker\Shared\Publisher\PublisherConfig as SharedPublisherConfig;
use Spryker\Zed\Publisher\PublisherConfig as SprykerPublisherConfig;

class PublisherConfig extends SprykerPublisherConfig
{
    /**
     * @return string|null
     */
    public function getPublishQueueName(): ?string
    {
        return SharedPublisherConfig::PUBLISH_QUEUE;
    }
}
