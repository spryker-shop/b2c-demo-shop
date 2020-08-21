<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
