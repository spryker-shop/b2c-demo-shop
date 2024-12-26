<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\Console;

use Spryker\Yves\Console\ConsoleDependencyProvider as SprykerConsoleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Monitoring\Plugin\Console\MonitoringConsolePlugin;
use Spryker\Yves\Router\Plugin\Application\RouterApplicationPlugin;
use Spryker\Yves\Router\Plugin\Console\RouterCacheWarmUpConsole;
use Spryker\Yves\Router\Plugin\Console\RouterDebugYvesConsole;

class ConsoleDependencyProvider extends SprykerConsoleDependencyProvider
{
    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return array<\Symfony\Component\Console\Command\Command>
     */
    protected function getConsoleCommands(Container $container): array // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        return [
            new RouterDebugYvesConsole(),
            new RouterCacheWarmUpConsole(),
        ];
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return array<\Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface>
     */
    protected function getApplicationPlugins(Container $container): array // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        return [
            new RouterApplicationPlugin(),
        ];
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return array<\Spryker\Yves\Monitoring\Plugin\Console\MonitoringConsolePlugin>
     */
    protected function getEventSubscriber(Container $container): array // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        return [
            new MonitoringConsolePlugin(),
        ];
    }
}
