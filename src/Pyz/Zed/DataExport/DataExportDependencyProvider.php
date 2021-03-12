<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataExport;

use Spryker\Zed\DataExport\DataExportDependencyProvider as SprykerDataExportDependencyProvider;
use Spryker\Zed\SalesDataExport\Communication\Plugin\DataExport\OrderDataEntityExporterPlugin;
use Spryker\Zed\SalesDataExport\Communication\Plugin\DataExport\OrderExpenseDataEntityExporterPlugin;
use Spryker\Zed\SalesDataExport\Communication\Plugin\DataExport\OrderItemDataEntityExporterPlugin;

class DataExportDependencyProvider extends SprykerDataExportDependencyProvider
{
    /**
     * @return \Spryker\Zed\DataExportExtension\Dependency\Plugin\DataEntityExporterPluginInterface[]
     */
    protected function getDataEntityExporterPlugins(): array
    {
        return [
            new OrderDataEntityExporterPlugin(),
            new OrderItemDataEntityExporterPlugin(),
            new OrderExpenseDataEntityExporterPlugin(),
        ];
    }
}
