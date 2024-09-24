<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\SynchronizationBehavior;

use Spryker\Zed\SynchronizationBehavior\SynchronizationBehaviorConfig as SprykerSynchronizationBehaviorConfig;

class SynchronizationBehaviorConfig extends SprykerSynchronizationBehaviorConfig
{
    /**
     * @return bool
     */
    public function isDirectSynchronizationEnabled(): bool
    {
        return false;
    }
}
