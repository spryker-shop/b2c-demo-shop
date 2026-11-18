<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\SecurityBlocker;

use Spryker\Client\SecurityBlocker\SecurityBlockerConfig as SprykerSecurityBlockerConfig;

class SecurityBlockerConfig extends SprykerSecurityBlockerConfig
{
    protected const bool IS_SECURITY_AUDIT_LOG_ENABLED = true;
}
