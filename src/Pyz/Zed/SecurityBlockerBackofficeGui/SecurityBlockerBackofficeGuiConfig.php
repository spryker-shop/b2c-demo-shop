<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\SecurityBlockerBackofficeGui;

use Spryker\Zed\SecurityBlockerBackofficeGui\SecurityBlockerBackofficeGuiConfig as SprykerSecurityBlockerBackofficeGuiConfig;

class SecurityBlockerBackofficeGuiConfig extends SprykerSecurityBlockerBackofficeGuiConfig
{
    protected const string LOGIN_PROTECTION_STRATEGY = self::LOGIN_PROTECTION_STRATEGY_IP_AND_ACCOUNT;

    protected const string IP_COUNTER_KEY_STRATEGY = self::IP_COUNTER_KEY_STRATEGY_IP_AND_USERNAME;
}
