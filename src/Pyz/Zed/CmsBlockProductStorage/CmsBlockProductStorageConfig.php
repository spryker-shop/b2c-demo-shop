<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\CmsBlockProductStorage;

use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\CmsBlockProductStorage\CmsBlockProductStorageConfig as SprykerCmsBlockProductStorageConfig;

class CmsBlockProductStorageConfig extends SprykerCmsBlockProductStorageConfig
{
    /**
     * @return string|null
     */
    public function getEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
