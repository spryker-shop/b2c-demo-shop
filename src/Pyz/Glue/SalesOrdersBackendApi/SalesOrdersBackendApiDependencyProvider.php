<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\SalesOrdersBackendApi;

use Spryker\Glue\CartNotesBackendApi\Plugin\SalesOrdersBackendApi\CartNoteOrdersBackendApiAttributesMapperPlugin;
use Spryker\Glue\SalesOrdersBackendApi\SalesOrdersBackendApiDependencyProvider as SprykerSalesOrdersBackendApiDependencyProvider;

class SalesOrdersBackendApiDependencyProvider extends SprykerSalesOrdersBackendApiDependencyProvider
{
    /**
     * @return list<\Spryker\Glue\SalesOrdersBackendApiExtension\Dependency\Plugin\OrdersBackendApiAttributesMapperPluginInterface>
     */
    protected function getOrdersBackendApiAttributesMapperPlugins(): array
    {
        return [
            new CartNoteOrdersBackendApiAttributesMapperPlugin(),
        ];
    }
}
