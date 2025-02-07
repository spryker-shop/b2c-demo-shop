<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Service\Synchronization;

use Spryker\Service\Synchronization\SynchronizationConfig as SprykerSynchronizationConfig;

class SynchronizationConfig extends SprykerSynchronizationConfig
{
    /**
     * Specification:
     *  - Used for backward compatibility to switch to the new single-key format.
     *  - Defaults to `false`, using the `key:` name format.
     *  - When set to `true`, the single-key format is `key`.
     *
     * @api
     *
     * @deprecated Will be removed in the next major without replacement. Will be switched to normalized format.
     *
     * @return bool
     */
    public function isSingleKeyFormatNormalized(): bool
    {
        return true;
    }
}
