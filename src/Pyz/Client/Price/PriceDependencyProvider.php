<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\Price;

use Spryker\Client\PersistentCart\Plugin\UpdatePersistentCartPriceModePlugin;
use Spryker\Client\Price\PriceDependencyProvider as SprykerPriceDependencyProvider;
use Spryker\Client\SalesOrderAmendment\Plugin\Price\SalesOrderAmendmentCurrentPriceModePreCheckPlugin;

class PriceDependencyProvider extends SprykerPriceDependencyProvider
{
    /**
     * @return list<\Spryker\Client\PriceExtension\Dependency\Plugin\CurrentPriceModePreCheckPluginInterface>
     */
    protected function getCurrentPriceModePreCheckPlugins(): array
    {
        return [
            new SalesOrderAmendmentCurrentPriceModePreCheckPlugin(),
        ];
    }

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
