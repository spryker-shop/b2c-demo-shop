<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\PriceProduct;

use Spryker\Service\PriceProduct\PriceProductDependencyProvider as SprykerPriceProductDependencyProvider;
use Spryker\Service\PriceProductVolume\Plugin\PriceProductExtension\PriceProductVolumeFilterPlugin;

class PriceProductDependencyProvider extends SprykerPriceProductDependencyProvider
{
    /**
     * {@inheritDoc}
     *
     * @return \Spryker\Service\PriceProductExtension\Dependency\Plugin\PriceProductFilterPluginInterface[]
     */
    protected function getPriceProductDecisionPlugins(): array
    {
        return array_merge([
            new PriceProductVolumeFilterPlugin(),
        ], parent::getPriceProductDecisionPlugins());
    }
}
