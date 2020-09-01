<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CustomerPage;

use SprykerShop\Yves\CustomerPage\CustomerPageConfig as SprykerCustomerPageConfig;

class CustomerPageConfig extends SprykerCustomerPageConfig
{
    protected const LOGIN_FAILURE_REDIRECT_URL = '/login';

    /**
     * {@inheritDoc}
     *
     * @return string|null
     */
    public function loginFailureRedirectUrl(): ?string
    {
        return static::LOGIN_FAILURE_REDIRECT_URL;
    }

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
