<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Router;

use Spryker\Zed\Api\Communication\Plugin\Router\ApiRouterPlugin;
use Spryker\Zed\Router\Communication\Plugin\Router\BackendGatewayRouterPlugin;
use Spryker\Zed\Router\Communication\Plugin\Router\BackofficeRouterPlugin;
use Spryker\Zed\Router\RouterDependencyProvider as SprykerRouterDependencyProvider;

class RouterDependencyProvider extends SprykerRouterDependencyProvider
{
    /**
     * @return \Spryker\Zed\RouterExtension\Dependency\Plugin\RouterPluginInterface[]
     */
    protected function getBackofficeRouterPlugins(): array
    {
        return [
            new BackofficeRouterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\RouterExtension\Dependency\Plugin\RouterPluginInterface[]
     */
    protected function getBackendGatewayRouterPlugins(): array
    {
        return [
            new BackendGatewayRouterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\RouterExtension\Dependency\Plugin\RouterPluginInterface[]
     */
    protected function getBackendApiRouterPlugins(): array
    {
        return [
            new ApiRouterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\RouterExtension\Dependency\Plugin\RouterEnhancerPluginInterface[]
     */
    protected function getRouterEnhancerPlugins(): array
    {
        return [
            new BackwardsCompatibleUrlRouterEnhancerPlugin(),
        ];
    }
}
