<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\CartReorder;

use Spryker\Client\CartReorder\CartReorderDependencyProvider as SprykerCartReorderDependencyProvider;
use Spryker\Client\Quote\Plugin\CartReorder\ResetItemsSessionCartReorderQuoteProviderStrategyPlugin;

class CartReorderDependencyProvider extends SprykerCartReorderDependencyProvider
{
    /**
     * @return list<\Spryker\Client\CartReorderExtension\Dependency\Plugin\CartReorderQuoteProviderStrategyPluginInterface>
     */
    protected function getCartReorderQuoteProviderStrategyPlugins(): array
    {
        return [
            new ResetItemsSessionCartReorderQuoteProviderStrategyPlugin(),
        ];
    }
}
