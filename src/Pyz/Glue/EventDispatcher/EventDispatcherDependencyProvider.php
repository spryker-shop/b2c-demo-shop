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
use Spryker\Shared\Http\Plugin\EventDispatcher\ResponseListenerEventDispatcherPlugin;
use Spryker\Yves\Monitoring\Plugin\EventDispatcher\MonitoringRequestTransactionEventDispatcherPlugin;
use Spryker\Zed\Monitoring\Communication\Plugin\EventDispatcher\GatewayMonitoringRequestTransactionEventDispatcherPlugin;
use Spryker\Zed\ZedRequest\Communication\Plugin\EventDispatcher\GatewayControllerEventDispatcherPlugin;

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
            new ResponseListenerEventDispatcherPlugin(),
        ];
    }

    /**
     * @return \Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface[]
     */
    protected function getBackendGatewayEventDispatcherPlugins(): array
    {
        return [
            new GatewayMonitoringRequestTransactionEventDispatcherPlugin(),
            new GatewayControllerEventDispatcherPlugin(),
            new RouterListenerEventDispatcherPlugin(),
            new ResponseListenerEventDispatcherPlugin(),
            new AutoloaderCacheEventDispatcherPlugin(),
        ];
    }

    /**
     * @return \Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface[]
     */
    protected function getBackendApiEventDispatcherPlugins(): array
    {
        return [
            new MonitoringRequestTransactionEventDispatcherPlugin(),
            new RouterListenerEventDispatcherPlugin(),
            new ResponseListenerEventDispatcherPlugin(),
            new AutoloaderCacheEventDispatcherPlugin(),
        ];
    }
}
