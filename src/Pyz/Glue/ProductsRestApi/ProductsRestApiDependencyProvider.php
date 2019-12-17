<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\ProductsRestApi;

use Spryker\Glue\ProductDiscontinuedRestApi\Plugin\ProductDiscontinuedConcreteProductsResourceExpanderPlugin;
use Spryker\Glue\ProductReviewsRestApi\Plugin\ProductsRestApi\ProductReviewsAbstractProductsResourceExpanderPlugin;
use Spryker\Glue\ProductReviewsRestApi\Plugin\ProductsRestApi\ProductReviewsConcreteProductsResourceExpanderPlugin;
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
            new ProductReviewsConcreteProductsResourceExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Glue\ProductsRestApiExtension\Dependency\Plugin\AbstractProductsResourceExpanderPluginInterface[]
     */
    protected function getAbstractProductsResourceExpanderPlugins(): array
    {
        return [
            new ProductReviewsAbstractProductsResourceExpanderPlugin(),
        ];
    }
}
