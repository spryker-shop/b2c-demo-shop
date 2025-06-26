<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\PaymentApp;

use Spryker\Zed\PaymentApp\PaymentAppDependencyProvider as SprykerPaymentAppDependencyProvider;
use Spryker\Zed\PaymentAppShipment\Communication\Plugin\PaymentApp\ShipmentExpressCheckoutPaymentRequestProcessorPlugin;

class PaymentAppDependencyProvider extends SprykerPaymentAppDependencyProvider
{
    /**
     * @return list<\Spryker\Zed\PaymentAppExtension\Dependency\Plugin\ExpressCheckoutPaymentRequestProcessorPluginInterface>
     */
    protected function getExpressCheckoutPaymentRequestProcessorPlugins(): array
    {
        return [
            new ShipmentExpressCheckoutPaymentRequestProcessorPlugin(),
        ];
    }
}
