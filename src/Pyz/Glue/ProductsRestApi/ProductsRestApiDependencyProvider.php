<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\ProductsRestApi;

use Spryker\Glue\ProductDiscontinuedRestApi\Plugin\ProductDiscontinuedConcreteProductsResourceExpanderPlugin;
use Spryker\Glue\ProductsRestApi\ProductsRestApiDependencyProvider as SprykerProductsRestApiDependencyProvider;

class ProductsRestApiDependencyProvider extends SprykerProductsRestApiDependencyProvider
{
    /**
     * @return \Spryker\Glue\ProductsRestApiExtension\Dependency\Plugin\ConcreteProductsResourceExpanderPluginInterface[]
     */
    protected function getConcreteProductsResourceExpanderPlugins(): array
    {
        return [
            new ProductDiscontinuedConcreteProductsResourceExpanderPlugin(),
        ];
    }
}
