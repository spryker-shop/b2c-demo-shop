<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
