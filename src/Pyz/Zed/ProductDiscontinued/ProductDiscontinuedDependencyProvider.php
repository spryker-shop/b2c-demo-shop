<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductDiscontinued;

use Spryker\Zed\ProductDiscontinued\ProductDiscontinuedDependencyProvider as SprykerProductDiscontinuedDependencyProvider;
use Spryker\Zed\ProductDiscontinuedProductBundleConnector\Communication\Plugin\DiscontinueBundlePostProductDiscontinuePlugin;
use Spryker\Zed\ProductDiscontinuedProductBundleConnector\Communication\Plugin\ProductDiscontinued\BundledProductsProductDiscontinuedPreDeleteCheckPlugin;
use Spryker\Zed\ProductDiscontinuedProductLabelConnector\Communication\Plugin\PostProductDiscontinuedPlugin;
use Spryker\Zed\ProductDiscontinuedProductLabelConnector\Communication\Plugin\ProductLabelRelationPostDeleteBulkProductDiscontinuedPlugin;

class ProductDiscontinuedDependencyProvider extends SprykerProductDiscontinuedDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\ProductDiscontinuedExtension\Dependency\Plugin\PostProductDiscontinuePluginInterface>
     */
    protected function getPostProductDiscontinuePlugins(): array
    {
        return [
            new DiscontinueBundlePostProductDiscontinuePlugin(),
            new PostProductDiscontinuedPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\ProductDiscontinuedExtension\Dependency\Plugin\PostDeleteBulkProductDiscontinuedPluginInterface>
     */
    protected function getPostDeleteBulkProductDiscontinuedPlugins(): array
    {
        return [
            new ProductLabelRelationPostDeleteBulkProductDiscontinuedPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\ProductDiscontinuedExtension\Dependency\Plugin\ProductDiscontinuedPreDeleteCheckPluginInterface>
     */
    protected function getProductDiscontinuedPreDeleteCheckPlugins(): array
    {
        return [
            new BundledProductsProductDiscontinuedPreDeleteCheckPlugin(),
        ];
    }
}
