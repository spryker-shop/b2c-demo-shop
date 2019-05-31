<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\EventDispatcher;

use Spryker\Yves\EventDispatcher\EventDispatcherDependencyProvider as SprykerEventDispatcherDependencyProvider;
use Spryker\Yves\Locale\Plugin\EventDispatcher\LocaleEventDispatcherPlugin;
use Spryker\Yves\Router\Plugin\EventDispatcher\RouterLocaleEventDispatcherPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\EventDispatcher\ShopApplicationEventDispatcherPlugin;

class EventDispatcherDependencyProvider extends SprykerEventDispatcherDependencyProvider
{
    /**
     * @return \Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface[]
     */
    protected function getEventDispatcherPlugins(): array
    {
        return [
            new ShopApplicationEventDispatcherPlugin(),
            new LocaleEventDispatcherPlugin(),
            new RouterLocaleEventDispatcherPlugin(),
        ];
    }
}
