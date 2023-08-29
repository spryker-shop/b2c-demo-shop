<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\SecurityBlockerPage;

use SprykerShop\Yves\SecurityBlockerPage\SecurityBlockerPageConfig as SprykerSecurityBlockerPageConfig;

class SecurityBlockerPageConfig extends SprykerSecurityBlockerPageConfig
{
    /**
     * @var bool
     */
    protected const USE_EMAIL_CONTEXT_FOR_LOGIN_SECURITY_BLOCKER = false;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @deprecated Will be removed without replacement. If the future the locale-specific URL will be used.
     *
     * @return bool
     */
    public function isLocaleInCustomerLoginCheckPath(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @deprecated Will be removed without replacement. If the future the locale-specific URL will be used.
     *
     * @return bool
     */
    public function isLocaleInAgentLoginCheckPath(): bool
    {
        return true;
    }
}
