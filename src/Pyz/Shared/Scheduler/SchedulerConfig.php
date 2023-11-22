<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Shared\Scheduler;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class SchedulerConfig extends AbstractSharedConfig
{
    /**
     * @var string
     */
    public const SCHEDULER_JENKINS = 'jenkins';
}
