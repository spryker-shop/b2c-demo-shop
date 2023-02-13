<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\HealthCheck;

use Spryker\Yves\HealthCheck\HealthCheckDependencyProvider as SprykerHealthCheckDependencyProvider;
use Spryker\Yves\Search\Plugin\HealthCheck\SearchHealthCheckPlugin;
use Spryker\Yves\Session\Plugin\HealthCheck\SessionHealthCheckPlugin;
use Spryker\Yves\Storage\Plugin\HealthCheck\KeyValueStoreHealthCheckPlugin;
use Spryker\Yves\ZedRequest\Plugin\HealthCheck\ZedRequestHealthCheckPlugin;

class HealthCheckDependencyProvider extends SprykerHealthCheckDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\HealthCheckExtension\Dependency\Plugin\HealthCheckPluginInterface>
     */
    protected function getHealthCheckPlugins(): array
    {
        return [
            new SessionHealthCheckPlugin(),
            new SearchHealthCheckPlugin(),
            new KeyValueStoreHealthCheckPlugin(),
            new ZedRequestHealthCheckPlugin(),
        ];
    }
}
