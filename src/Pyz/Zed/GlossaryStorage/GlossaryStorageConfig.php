<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\GlossaryStorage;

use Pyz\Zed\Synchronization\SynchronizationConfig;
use Spryker\Zed\GlossaryStorage\GlossaryStorageConfig as SprykerGlossaryStorageConfig;

class GlossaryStorageConfig extends SprykerGlossaryStorageConfig
{
    /**
     * @return string|null
     */
    public function getGlossarySynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
