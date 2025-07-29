<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Service\PriceProduct;

use Spryker\Service\PriceProduct\PriceProductDependencyProvider as SprykerPriceProductDependencyProvider;
use Spryker\Service\PriceProductVolume\Plugin\PriceProductExtension\PriceProductVolumeFilterPlugin;
use Spryker\Service\ProductConfiguration\Plugin\PriceProduct\ProductConfigurationPriceProductFilterPlugin;
use Spryker\Service\ProductConfiguration\Plugin\PriceProduct\ProductConfigurationVolumePriceProductFilterPlugin;

class PriceProductDependencyProvider extends SprykerPriceProductDependencyProvider
{
    /**
     * {@inheritDoc}
     *
     * @return array<\Spryker\Service\PriceProductExtension\Dependency\Plugin\PriceProductFilterPluginInterface>
     */
    protected function getPriceProductDecisionPlugins(): array
    {
        return array_merge([
            new ProductConfigurationPriceProductFilterPlugin(),
            new ProductConfigurationVolumePriceProductFilterPlugin(),
            new PriceProductVolumeFilterPlugin(),
        ], parent::getPriceProductDecisionPlugins());
    }
}
