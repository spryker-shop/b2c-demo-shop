<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\OrdersRestApi;

use Spryker\Glue\OrdersRestApi\OrdersRestApiDependencyProvider as SprykerOrdersRestApiDependencyProvider;
use Spryker\Glue\ProductOptionsRestApi\Plugin\OrdersRestApi\ProductOptionRestOrderItemsAttributesMapperPlugin;

class OrdersRestApiDependencyProvider extends SprykerOrdersRestApiDependencyProvider
{
    /**
     * @return \Spryker\Glue\OrdersRestApiExtension\Dependency\Plugin\RestOrderItemsAttributesMapperPluginInterface[]
     */
    protected function getRestOrderItemsAttributesMapperPlugins(): array
    {
        return [
            new ProductOptionRestOrderItemsAttributesMapperPlugin(),
        ];
    }
}
