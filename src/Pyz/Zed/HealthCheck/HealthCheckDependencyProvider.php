<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HealthCheck;

use Spryker\Zed\HealthCheck\HealthCheckDependencyProvider as SprykerHealthCheckDependencyProvider;
use Spryker\Zed\Propel\Communication\Plugin\HealthCheck\DatabaseHealthCheckPlugin;
use Spryker\Zed\PublishAndSynchronizeHealthCheck\Communication\Plugin\HealthCheck\PublishAndSynchronizeWriteHealthCheckPlugin;
use Spryker\Zed\PublishAndSynchronizeHealthCheckSearch\Communication\Plugin\HealthCheck\PublishAndSynchronizeHealthCheckSearchPlugin;
use Spryker\Zed\PublishAndSynchronizeHealthCheckStorage\Communication\Plugin\HealthCheck\PublishAndSynchronizeHealthCheckStoragePlugin;
use Spryker\Zed\Search\Communication\Plugin\HealthCheck\SearchHealthCheckPlugin;
use Spryker\Zed\Session\Communication\Plugin\HealthCheck\SessionHealthCheckPlugin;
use Spryker\Zed\Storage\Communication\Plugin\HealthCheck\KeyValueStoreHealthCheckPlugin;

class HealthCheckDependencyProvider extends SprykerHealthCheckDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\HealthCheckExtension\Dependency\Plugin\HealthCheckPluginInterface>
     */
    protected function getHealthCheckPlugins(): array
    {
        return [
            new PublishAndSynchronizeWriteHealthCheckPlugin(),
            new PublishAndSynchronizeHealthCheckSearchPlugin(),
            new PublishAndSynchronizeHealthCheckStoragePlugin(),
            new SessionHealthCheckPlugin(),
            new KeyValueStoreHealthCheckPlugin(),
            new SearchHealthCheckPlugin(),
            new DatabaseHealthCheckPlugin(),
        ];
    }
}
