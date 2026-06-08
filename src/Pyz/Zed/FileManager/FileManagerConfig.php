<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\FileManager;

use Spryker\Zed\FileManager\FileManagerConfig as SprykerFileManagerConfig;

class FileManagerConfig extends SprykerFileManagerConfig
{
    public function isUuidEnabled(): bool
    {
        return true;
    }
}
