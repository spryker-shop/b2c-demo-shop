<?php

declare(strict_types = 1);

namespace Pyz\Client\CartReorder;

use Spryker\Client\CartReorder\CartReorderDependencyProvider as SprykerCartReorderDependencyProvider;
use Spryker\Client\Quote\Plugin\CartReorder\SessionCartReorderQuoteProviderStrategyPlugin;

class CartReorderDependencyProvider extends SprykerCartReorderDependencyProvider
{
    /**
     * @return list<\Spryker\Client\CartReorderExtension\Dependency\Plugin\CartReorderQuoteProviderStrategyPluginInterface>
     */
    protected function getCartReorderQuoteProviderStrategyPlugins(): array
    {
        return [
            new SessionCartReorderQuoteProviderStrategyPlugin(),
        ];
    }
}
