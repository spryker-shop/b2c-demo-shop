<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\ProductPricesRestApi;

use Spryker\Glue\PriceProductVolumesRestApi\Plugin\ProductPriceRestApi\PriceProductVolumeRestProductPricesAttributesMapperPlugin;
use Spryker\Glue\ProductPricesRestApi\ProductPricesRestApiDependencyProvider as SprykerProductPricesRestApiDependencyProvider;

class ProductPricesRestApiDependencyProvider extends SprykerProductPricesRestApiDependencyProvider
{
    /**
     * @return array<\Spryker\Glue\ProductPricesRestApiExtension\Dependency\Plugin\RestProductPricesAttributesMapperPluginInterface>
     */
    protected function getRestProductPricesAttributesMapperPlugins(): array
    {
        return [
            new PriceProductVolumeRestProductPricesAttributesMapperPlugin(),
        ];
    }
}
