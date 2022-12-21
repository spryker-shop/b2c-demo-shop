<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CartsRestApi;

use Spryker\Glue\CartsRestApi\CartsRestApiDependencyProvider as SprykerCartsRestApiDependencyProvider;
use Spryker\Glue\ConfigurableBundleCartsRestApi\Plugin\CartsRestApi\ConfiguredBundleItemsAttributesMapperPlugin;
use Spryker\Glue\DiscountPromotionsRestApi\Plugin\CartsRestApi\DiscountPromotionCartItemExpanderPlugin;
use Spryker\Glue\ProductBundleCartsRestApi\Plugin\CartsRestApi\ProductBundleCartItemFilterPlugin;
use Spryker\Glue\ProductConfigurationsRestApi\Plugin\CartsRestApi\ProductConfigurationCartItemExpanderPlugin;
use Spryker\Glue\ProductConfigurationsRestApi\Plugin\CartsRestApi\ProductConfigurationRestCartItemsAttributesMapperPlugin;
use Spryker\Glue\ProductOptionsRestApi\Plugin\CartsRestApi\ProductOptionCartItemExpanderPlugin;
use Spryker\Glue\ProductOptionsRestApi\Plugin\CartsRestApi\ProductOptionRestCartItemsAttributesMapperPlugin;
use Spryker\Glue\SalesOrderThresholdsRestApi\Plugin\CartsRestApi\SalesOrderThresholdRestCartAttributesMapperPlugin;

class CartsRestApiDependencyProvider extends SprykerCartsRestApiDependencyProvider
{
    /**
     * @return array<\Spryker\Glue\CartsRestApiExtension\Dependency\Plugin\RestCartItemsAttributesMapperPluginInterface>
     */
    protected function getRestCartItemsAttributesMapperPlugins(): array
    {
        return [
            new ProductOptionRestCartItemsAttributesMapperPlugin(),
            new ConfiguredBundleItemsAttributesMapperPlugin(),
            new ProductConfigurationRestCartItemsAttributesMapperPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\CartsRestApiExtension\Dependency\Plugin\CartItemExpanderPluginInterface>
     */
    protected function getCartItemExpanderPlugins(): array
    {
        return [
            new ProductOptionCartItemExpanderPlugin(),
            new DiscountPromotionCartItemExpanderPlugin(),
            new ProductConfigurationCartItemExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\CartsRestApiExtension\Dependency\Plugin\CartItemFilterPluginInterface>
     */
    protected function getCartItemFilterPlugins(): array
    {
        return [
            new ProductBundleCartItemFilterPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\CartsRestApiExtension\Dependency\Plugin\RestCartAttributesMapperPluginInterface>
     */
    protected function getRestCartAttributesMapperPlugins(): array
    {
        return [
            new SalesOrderThresholdRestCartAttributesMapperPlugin(),
        ];
    }
}
