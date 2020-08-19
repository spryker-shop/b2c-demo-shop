<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsBlockStorage;

use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\CmsBlockStorage\CmsBlockStorageConfig as SprykerCmsBlockStorageConfig;

class CmsBlockStorageConfig extends SprykerCmsBlockStorageConfig
{
    /**
     * @return string|null
     */
    public function getEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
