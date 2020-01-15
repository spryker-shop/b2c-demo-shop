<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\EventDispatcher;

use Spryker\Glue\EventDispatcher\EventDispatcherDependencyProvider as SprykerEventDispatcherDependencyProvider;
use Spryker\Glue\GlueApplication\Plugin\EventDispatcher\GlueRestControllerListenerEventDispatcherPlugin;
use Spryker\Glue\Kernel\Plugin\EventDispatcher\AutoloaderCacheEventDispatcherPlugin;
use Spryker\Glue\Router\Plugin\EventDispatcher\RouterListenerEventDispatcherPlugin;
use Spryker\Glue\Storage\Plugin\EventDispatcher\StorageKeyCacheEventDispatcherPlugin;

class EventDispatcherDependencyProvider extends SprykerEventDispatcherDependencyProvider
{
    /**
     * @return \Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface[]
     */
    protected function getEventDispatcherPlugins(): array
    {
        return [
            new GlueRestControllerListenerEventDispatcherPlugin(),
            new StorageKeyCacheEventDispatcherPlugin(),
            new AutoloaderCacheEventDispatcherPlugin(),
            new RouterListenerEventDispatcherPlugin(),
        ];
    }
}
