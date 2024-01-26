<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class CustomerTaskConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const CUSTOMER_TASK_STATUS_NEW = 'New';

    /**
     * @var string
     */
    public const CUSTOMER_TASK_STATUS_TO_DO = 'To Do';

    /**
     * @var string
     */
    public const CUSTOMER_TASK_STATUS_IN_PROGRESS = 'In Progress';

    /**
     * @var string
     */
    public const CUSTOMER_TASK_STATUS_COMPLETED = 'Completed';

    /**
     * @var string
     */
    public const CUSTOMER_TASK_STATUS_OVERDUE = 'Overdue';
}
