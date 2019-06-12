<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\EventDispatcher;

use Spryker\Zed\EventDispatcher\EventDispatcherDependencyProvider as SprykerEventDispatcherDependencyProvider;
use Spryker\Zed\Locale\Communication\Plugin\EventDispatcher\LocaleEventDispatcherPlugin;
use Spryker\Zed\Router\Communication\Plugin\EventDispatcher\RouterLocaleEventDispatcherPlugin;
use Spryker\Zed\Twig\Communication\Plugin\EventDispatcher\TwigEventDispatcherPlugin;

class EventDispatcherDependencyProvider extends SprykerEventDispatcherDependencyProvider
{
    /**
     * @return \Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface[]
     */
    protected function getEventDispatcherPlugins(): array
    {
        return [
            new TwigEventDispatcherPlugin(),
            new LocaleEventDispatcherPlugin(),
            new RouterLocaleEventDispatcherPlugin(),
        ];
    }
}
