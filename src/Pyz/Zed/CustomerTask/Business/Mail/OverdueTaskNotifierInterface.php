<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business\Mail;

interface OverdueTaskNotifierInterface
{
    /**
     * @return void
     */
    public function notify(): void;
}
