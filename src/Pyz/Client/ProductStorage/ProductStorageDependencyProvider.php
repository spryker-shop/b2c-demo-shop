<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductStorage;

use Pyz\Client\ProductStorage\Plugin\BundleProductsExpanderPlugin;
use Spryker\Client\AvailabilityStorage\Plugin\ProductViewAvailabilityStorageExpanderPlugin;
use Spryker\Client\PriceProductStorage\Plugin\ProductViewPriceExpanderPlugin;
use Spryker\Client\ProductDiscontinuedStorage\Plugin\ProductStorage\ProductDiscontinuedProductAvailabilityExpanderPlugin;
use Spryker\Client\ProductDiscontinuedStorage\Plugin\ProductStorage\ProductViewDiscontinuedOptionsExpanderPlugin;
use Spryker\Client\ProductImageStorage\Plugin\ProductViewImageExpanderPlugin;
use Spryker\Client\ProductStorage\Plugin\ProductViewVariantExpanderPlugin;
use Spryker\Client\ProductStorage\ProductStorageDependencyProvider as SprykerProductStorageDependencyProvider;

class ProductStorageDependencyProvider extends SprykerProductStorageDependencyProvider
{
    /**
     * @return \Spryker\Client\ProductStorage\Dependency\Plugin\ProductViewExpanderPluginInterface[]
     */
    protected function getProductViewExpanderPlugins()
    {
        /** @var \Spryker\Client\ProductStorage\Dependency\Plugin\ProductViewExpanderPluginInterface[] $plugins */
        $plugins = [
            new ProductViewDiscontinuedOptionsExpanderPlugin(),
            new ProductViewVariantExpanderPlugin(),
            new ProductViewPriceExpanderPlugin(),
            new ProductViewAvailabilityStorageExpanderPlugin(),
            new ProductViewImageExpanderPlugin(),
            new ProductDiscontinuedProductAvailabilityExpanderPlugin(),
            new BundleProductsExpanderPlugin(),
        ];

        return $plugins;
    }
}
