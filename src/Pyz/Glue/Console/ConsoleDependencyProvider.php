<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\Console;

use Spryker\Glue\Console\ConsoleDependencyProvider as SprykerConsoleDependencyProvider;
use Spryker\Glue\GlueApplication\Plugin\Console\RouterCacheWarmUpConsole;

class ConsoleDependencyProvider extends SprykerConsoleDependencyProvider
{
    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return array<\Symfony\Component\Console\Command\Command>
     */
    protected function getConsoleCommands(\Spryker\Glue\Kernel\Container $container) : array
    {
        return [
            new RouterCacheWarmUpConsole(),
        ];
    }
}