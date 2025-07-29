<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\AvailabilityStorage;

use Spryker\Client\AvailabilityStorage\AvailabilityStorageDependencyProvider as SprykerAvailabilityStorageDependencyProvider;
use Spryker\Client\ProductConfigurationStorage\Plugin\AvailabilityStorage\ProductConfigurationAvailabilityStorageStrategyPlugin;

class AvailabilityStorageDependencyProvider extends SprykerAvailabilityStorageDependencyProvider
{
    /**
     * @return array<\Spryker\Client\AvailabilityStorageExtension\Dependency\Plugin\AvailabilityStorageStrategyPluginInterface>
     */
    public function getAvailabilityStorageStrategyPlugins(): array
    {
        return [
            new ProductConfigurationAvailabilityStorageStrategyPlugin(),
        ];
    }
}
