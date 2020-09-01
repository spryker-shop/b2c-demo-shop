<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CheckoutRestApi;

use Spryker\Glue\CheckoutRestApi\CheckoutRestApiDependencyProvider as SprykerCheckoutRestApiDependencyProvider;
use Spryker\Glue\CheckoutRestApi\Plugin\SinglePaymentCheckoutRequestAttributesValidatorPlugin;
use Spryker\Glue\PaymentsRestApi\Plugin\CheckoutRestApi\SelectedPaymentMethodCheckoutDataResponseMapperPlugin;
use Spryker\Glue\ShipmentsRestApi\Plugin\CheckoutRestApi\SelectedShipmentMethodCheckoutDataResponseMapperPlugin;

class CheckoutRestApiDependencyProvider extends SprykerCheckoutRestApiDependencyProvider
{
    /**
     * @return \Spryker\Glue\CheckoutRestApiExtension\Dependency\Plugin\CheckoutRequestAttributesValidatorPluginInterface[]
     */
    protected function getCheckoutRequestAttributesValidatorPlugins(): array
    {
        return [
            new SinglePaymentCheckoutRequestAttributesValidatorPlugin(),
        ];
    }

    /**
     * @return \Spryker\Glue\CheckoutRestApiExtension\Dependency\Plugin\CheckoutDataResponseMapperPluginInterface[]
     */
    protected function getCheckoutDataResponseMapperPlugins(): array
    {
        return [
            new SelectedPaymentMethodCheckoutDataResponseMapperPlugin(),
            new SelectedShipmentMethodCheckoutDataResponseMapperPlugin(),
        ];
    }
}
