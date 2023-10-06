<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\Price;

use Spryker\Client\PersistentCart\Plugin\UpdatePersistentCartPriceModePlugin;
use Spryker\Client\Price\PriceDependencyProvider as SprykerPriceDependencyProvider;

class PriceDependencyProvider extends SprykerPriceDependencyProvider
{
    /**
     * @return array<\Spryker\Client\PriceExtension\Dependency\Plugin\PriceModePostUpdatePluginInterface>
     */
    protected function getPriceModePostUpdatePlugins(): array
    {
        return [
            new UpdatePersistentCartPriceModePlugin(),
        ];
    }
}
