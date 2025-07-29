<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\WarehouseAllocation;

use Spryker\Zed\ProductWarehouseAllocationExample\Communication\Plugin\WarehouseAllocation\ProductSalesOrderWarehouseAllocationPlugin;
use Spryker\Zed\WarehouseAllocation\WarehouseAllocationDependencyProvider as SprykerWarehouseAllocationDependencyProvider;

class WarehouseAllocationDependencyProvider extends SprykerWarehouseAllocationDependencyProvider
{
    /**
     * @return list<\Spryker\Zed\WarehouseAllocationExtension\Dependency\Plugin\SalesOrderWarehouseAllocationPluginInterface>
     */
    protected function getSalesOrderWarehouseAllocationPlugins(): array
    {
        return [
            new ProductSalesOrderWarehouseAllocationPlugin(),
        ];
    }
}
