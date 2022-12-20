<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\ProductConfigurationsRestApi;

use Spryker\Glue\ProductConfigurationsPriceProductVolumesRestApi\Plugin\ProductConfigurationsRestApi\ProductConfigurationVolumePriceProductConfigurationPriceMapperPlugin;
use Spryker\Glue\ProductConfigurationsPriceProductVolumesRestApi\Plugin\ProductConfigurationsRestApi\ProductConfigurationVolumePriceRestProductConfigurationPriceMapperPlugin;
use Spryker\Glue\ProductConfigurationsRestApi\ProductConfigurationsRestApiDependencyProvider as SprykerProductConfigurationsRestApiDependencyProvider;

class ProductConfigurationsRestApiDependencyProvider extends SprykerProductConfigurationsRestApiDependencyProvider
{
    /**
     * @return array<\Spryker\Glue\ProductConfigurationsRestApiExtension\Dependency\Plugin\ProductConfigurationPriceMapperPluginInterface>
     */
    protected function getProductConfigurationPriceMapperPlugins(): array
    {
        return [
            new ProductConfigurationVolumePriceProductConfigurationPriceMapperPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\ProductConfigurationsRestApiExtension\Dependency\Plugin\RestProductConfigurationPriceMapperPluginInterface>
     */
    protected function getRestProductConfigurationPriceMapperPlugins(): array
    {
        return [
            new ProductConfigurationVolumePriceRestProductConfigurationPriceMapperPlugin(),
        ];
    }
}
