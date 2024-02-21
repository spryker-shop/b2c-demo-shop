<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\SalesPayment;

use Spryker\Zed\GiftCard\Communication\Plugin\SalesPayment\GiftCardPaymentMapKeyBuilderStrategyPlugin;
use Spryker\Zed\SalesPayment\SalesPaymentDependencyProvider as SprykerSalesPaymentDependencyProvider;

class SalesPaymentDependencyProvider extends SprykerSalesPaymentDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\SalesPaymentExtension\Dependency\Plugin\PaymentMapKeyBuilderStrategyPluginInterface>
     */
    protected function getPaymentMapKeyBuilderStrategyPlugins(): array
    {
        return [
            new GiftCardPaymentMapKeyBuilderStrategyPlugin(),
        ];
    }
}
