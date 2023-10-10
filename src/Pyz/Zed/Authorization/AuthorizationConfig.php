<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Authorization;

use Spryker\Zed\Authorization\AuthorizationConfig as SprykerAuthorizationConfig;

class AuthorizationConfig extends SprykerAuthorizationConfig
{
    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function isMultistrategyAuthorizationAllowed(): bool
    {
        return true;
    }
}
