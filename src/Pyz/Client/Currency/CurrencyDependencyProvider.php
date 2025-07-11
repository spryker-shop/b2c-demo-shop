<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\Currency;

use Spryker\Client\CartCurrencyConnector\CurrencyChange\CartUpdateCurrencyOnCurrencyChangePlugin;
use Spryker\Client\Currency\CurrencyDependencyProvider as SprykerCurrencyDependencyProvider;
use Spryker\Client\SalesOrderAmendment\Plugin\Currency\SalesOrderAmendmentCurrentCurrencyIsoCodePreCheckPlugin;

class CurrencyDependencyProvider extends SprykerCurrencyDependencyProvider
{
    /**
     * @return list<\Spryker\Client\CurrencyExtension\Dependency\CurrencyPostChangePluginInterface>
     */
    protected function getCurrencyPostChangePlugins(): array
    {
        return [
            new CartUpdateCurrencyOnCurrencyChangePlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Client\CurrencyExtension\Dependency\Plugin\CurrentCurrencyIsoCodePreCheckPluginInterface>
     */
    protected function getCurrentCurrencyIsoCodePreCheckPlugins(): array
    {
        return [
            new SalesOrderAmendmentCurrentCurrencyIsoCodePreCheckPlugin(),
        ];
    }
}
