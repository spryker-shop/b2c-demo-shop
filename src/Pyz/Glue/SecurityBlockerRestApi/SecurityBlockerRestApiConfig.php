<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Glue\SecurityBlockerRestApi;

use Spryker\Glue\SecurityBlockerRestApi\SecurityBlockerRestApiConfig as SprykerSecurityBlockerRestApiConfig;

class SecurityBlockerRestApiConfig extends SprykerSecurityBlockerRestApiConfig
{
    protected const string LOGIN_PROTECTION_STRATEGY = self::LOGIN_PROTECTION_STRATEGY_IP_AND_ACCOUNT;
}
