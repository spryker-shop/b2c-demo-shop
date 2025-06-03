<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\Console;

use Spryker\Yves\Console\ConsoleDependencyProvider as SprykerConsoleDependencyProvider;
use Spryker\Yves\Form\Plugin\Application\FormApplicationPlugin;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Locale\Plugin\Application\ConsoleLocaleApplicationPlugin;
use Spryker\Yves\Monitoring\Plugin\Console\MonitoringConsolePlugin;
use Spryker\Yves\Router\Plugin\Application\RouterApplicationPlugin;
use Spryker\Yves\Router\Plugin\Console\RouterCacheWarmUpConsole;
use Spryker\Yves\Router\Plugin\Console\RouterDebugYvesConsole;
use Spryker\Yves\Security\Plugin\Application\ConsoleSecurityApplicationPlugin;
use Spryker\Yves\Session\Plugin\Application\ConsoleSessionApplicationPlugin;
use Spryker\Yves\Twig\Plugin\Application\TwigApplicationPlugin;
use Spryker\Yves\Twig\Plugin\Console\TwigTemplateWarmerConsole;
use Spryker\Yves\Twig\Plugin\Console\TwigTemplateWarmingModeEventSubscriberPlugin;

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
            new TwigTemplateWarmerConsole(),
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
            new ConsoleLocaleApplicationPlugin(),
            new ConsoleSessionApplicationPlugin(),
            new ConsoleSecurityApplicationPlugin(),
            new RouterApplicationPlugin(),
            new TwigApplicationPlugin(),
            new FormApplicationPlugin(),
        ];
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return array<\Symfony\Component\EventDispatcher\EventSubscriberInterface>
     */
    protected function getEventSubscriber(Container $container): array // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        return [
            new MonitoringConsolePlugin(),
            new TwigTemplateWarmingModeEventSubscriberPlugin(),
        ];
    }
}
