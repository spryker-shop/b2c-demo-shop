<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Console;

use Pyz\Shared\Console\ConsoleConstants;
use Spryker\Zed\Console\ConsoleConfig as SprykerConsoleConfig;

class ConsoleConfig extends SprykerConsoleConfig
{
    /**
     * @return bool
     */
    public function isDevelopmentConsoleCommandsEnabled(): bool
    {
        return $this->get(ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS, false);
    }
}
