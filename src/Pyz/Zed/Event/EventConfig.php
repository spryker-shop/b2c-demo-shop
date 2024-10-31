<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Event;

use Monolog\Logger;
use Spryker\Zed\Event\EventConfig as SprykerEventConfig;

class EventConfig extends SprykerEventConfig
{
    /**
     * @var string|int
     */
    protected const DEFAULT_EVENT_LOGGER_MIN_LEVEL = Logger::WARNING;
}
