<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Shared\Agent;

use Spryker\Shared\Agent\AgentConfig as SprykerAgentConfig;

class AgentConfig extends SprykerAgentConfig
{
    public function isSalesOrderAgentEnabled(): bool
    {
        return true;
    }
}
