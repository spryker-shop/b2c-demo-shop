<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Event;

use Spryker\Zed\Event\EventConfig as SprykerEventConfig;

class EventConfig extends SprykerEventConfig
{
    /**
     * @return int
     */
    public function getEventQueueMessageChunkSize()
    {
        return 5000;
    }
}
