<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Router;

use Spryker\Zed\Router\Communication\Plugin\Router\RouterEnhancer\BackwardsCompatibleUrlRouterEnhancerPlugin;
use Spryker\Zed\Router\Communication\Plugin\Router\ZedDevelopmentRouterPlugin;
use Spryker\Zed\Router\Communication\Plugin\Router\ZedRouterPlugin;
use Spryker\Zed\Router\RouterDependencyProvider as SprykerRouterDependencyProvider;

class RouterDependencyProvider extends SprykerRouterDependencyProvider
{
    /**
     * @return \Spryker\Zed\RouterExtension\Dependency\Plugin\RouterPluginInterface[]
     */
    protected function getRouterPlugins(): array
    {
        return [
            new ZedRouterPlugin(),
            // This router will only be hit, when no other router was able to match/generate.
            new ZedDevelopmentRouterPlugin(),
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
