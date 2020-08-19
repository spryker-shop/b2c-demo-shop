<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
