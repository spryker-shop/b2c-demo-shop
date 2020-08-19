<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\FileManagerStorage;

use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Zed\FileManagerStorage\FileManagerStorageConfig as SprykerFileManagerStorageConfig;

class FileManagerStorageConfig extends SprykerFileManagerStorageConfig
{
    /**
     * @return string|null
     */
    public function getEventQueueName(): ?string
    {
        return PublisherConfig::PUBLISH_QUEUE;
    }
}
