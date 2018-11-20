<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Application\Communication;

use Spryker\Shared\Auth\AuthConstants;
use Spryker\Shared\Config\Config;
use Spryker\Zed\Application\Communication\ZedBootstrap as SprykerZedBootstrap;

class ZedBootstrap extends SprykerZedBootstrap
{
    /**
     * @return bool
     */
    protected function isAuthenticationEnabled()
    {
        return Config::get(AuthConstants::AUTH_ZED_ENABLED, true);
    }
}
