<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class CustomerTasksRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_CUSTOMER_TASKS = 'customer-tasks';

    /**
     * @var string
     */
    public const RESOURCE_CUSTOMER_TASK_ASSIGN = 'customer-task-assign';

    /**
     * @var string
     */
    public const RESOURCE_CUSTOMER_TASK_TAGS = 'customer-task-tags';

    /**
     * @uses \Spryker\Glue\AuthRestApi\AuthRestApiConfig::RESPONSE_DETAIL_INVALID_ACCESS_TOKEN
     *
     * @var string
     */
    public const RESPONSE_DETAIL_INVALID_ACCESS_TOKEN = 'Invalid access token.';

    /**
     * @var string
     */
    public const RESPONSE_UNKNOWN_ERROR = 'Unknown error.';

    /**
     * @uses \Spryker\Glue\AuthRestApi\AuthRestApiConfig::RESPONSE_CODE_ACCESS_CODE_INVALID
     *
     * @var string
     */
    public const RESPONSE_CODE_ACCESS_CODE_INVALID = '001';
}
