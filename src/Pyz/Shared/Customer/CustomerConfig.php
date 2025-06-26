<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Shared\Customer;

use Spryker\Shared\Customer\CustomerConfig as SprykerCustomerConfig;

class CustomerConfig extends SprykerCustomerConfig
{
    /**
     * @api
     *
     * @return bool
     */
    public function isDoubleOptInEnabled(): bool
    {
        return true;
    }
}
