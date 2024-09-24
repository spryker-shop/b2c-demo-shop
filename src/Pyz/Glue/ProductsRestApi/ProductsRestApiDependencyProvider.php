<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\ProductsRestApi;

use Spryker\Glue\ProductAttributesRestApi\Plugin\ProductsRestApi\MultiSelectAttributeAbstractProductsResourceExpanderPlugin;
use Spryker\Glue\ProductAttributesRestApi\Plugin\ProductsRestApi\MultiSelectAttributeConcreteProductsResourceExpanderPlugin;
use Spryker\Glue\ProductConfigurationsRestApi\Plugin\ProductsRestApi\ProductConfigurationConcreteProductsResourceExpanderPlugin;
use Spryker\Glue\ProductDiscontinuedRestApi\Plugin\ProductDiscontinuedConcreteProductsResourceExpanderPlugin;
use Spryker\Glue\ProductReviewsRestApi\Plugin\ProductsRestApi\ProductReviewsAbstractProductsResourceExpanderPlugin;
use Spryker\Glue\ProductReviewsRestApi\Plugin\ProductsRestApi\ProductReviewsConcreteProductsResourceExpanderPlugin;
use Spryker\Glue\ProductsRestApi\ProductsRestApiDependencyProvider as SprykerProductsRestApiDependencyProvider;

class ProductsRestApiDependencyProvider extends SprykerProductsRestApiDependencyProvider
{
    /**
     * @return array<\Spryker\Glue\ProductsRestApiExtension\Dependency\Plugin\ConcreteProductsResourceExpanderPluginInterface>
     */
    protected function getConcreteProductsResourceExpanderPlugins(): array
    {
        return [
            new ProductDiscontinuedConcreteProductsResourceExpanderPlugin(),
            new ProductReviewsConcreteProductsResourceExpanderPlugin(),
            new ProductConfigurationConcreteProductsResourceExpanderPlugin(),
            new MultiSelectAttributeConcreteProductsResourceExpanderPlugin(), // remove if the project is accept product attribute values as array of strings
        ];
    }

    /**
     * @return array<\Spryker\Glue\ProductsRestApiExtension\Dependency\Plugin\AbstractProductsResourceExpanderPluginInterface>
     */
    protected function getAbstractProductsResourceExpanderPlugins(): array
    {
        return [
            new ProductReviewsAbstractProductsResourceExpanderPlugin(),
            new MultiSelectAttributeAbstractProductsResourceExpanderPlugin(), // remove if the project is accept product attribute values as array of strings
        ];
    }
}
