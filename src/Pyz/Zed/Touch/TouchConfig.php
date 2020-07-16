<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Touch;

use Spryker\Zed\Touch\TouchConfig as SprykerTouchConfig;

class TouchConfig extends SprykerTouchConfig
{
    /**
     * @return bool
     */
    public function isTouchEnabled(): bool
    {
        return false;
    }
}
