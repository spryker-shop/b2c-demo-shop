<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Shared\Console;

interface ConsoleConstants
{
    /**
     * Specification:
     * - Enables commands from modules included by require-dev composer section.
     * - Must be set to false for environments where composer install --no-dev is performed.
     *
     * @api
     */
    public const ENABLE_DEVELOPMENT_CONSOLE_COMMANDS = 'CONSOLE:ENABLE_DEVELOPMENT_CONSOLE_COMMANDS';
}
