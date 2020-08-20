<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsBlockCategoryStorage;

use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\CmsBlockCategoryStorage\CmsBlockCategoryStorageConfig as SprykerCmsBlockCategoryStorageConfig;

class CmsBlockCategoryStorageConfig extends SprykerCmsBlockCategoryStorageConfig
{
    /**
     * @return string|null
     */
    public function getEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
