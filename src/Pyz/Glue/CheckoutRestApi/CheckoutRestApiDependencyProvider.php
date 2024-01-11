<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CheckoutRestApi;

use Spryker\Glue\CheckoutRestApi\CheckoutRestApiDependencyProvider as SprykerCheckoutRestApiDependencyProvider;
use Spryker\Glue\CheckoutRestApi\Plugin\SinglePaymentCheckoutRequestAttributesValidatorPlugin;
use Spryker\Glue\CustomersRestApi\Plugin\CheckoutRestApi\BillingAddressCheckoutRequestAttributesValidatorPlugin;
use Spryker\Glue\PaymentsRestApi\Plugin\CheckoutRestApi\SelectedPaymentMethodCheckoutDataResponseMapperPlugin;
use Spryker\Glue\ShipmentsRestApi\Plugin\CheckoutRestApi\AddressSourceCheckoutRequestValidatorPlugin;
use Spryker\Glue\ShipmentsRestApi\Plugin\CheckoutRestApi\ShipmentDataCheckoutRequestValidatorPlugin;

class CheckoutRestApiDependencyProvider extends SprykerCheckoutRestApiDependencyProvider
{
    /**
     * @return array<\Spryker\Glue\CheckoutRestApiExtension\Dependency\Plugin\CheckoutRequestAttributesValidatorPluginInterface>
     */
    protected function getCheckoutRequestAttributesValidatorPlugins(): array
    {
        return [
            new SinglePaymentCheckoutRequestAttributesValidatorPlugin(),
            new BillingAddressCheckoutRequestAttributesValidatorPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\CheckoutRestApiExtension\Dependency\Plugin\CheckoutRequestValidatorPluginInterface>
     */
    protected function getCheckoutRequestValidatorPlugins(): array
    {
        return [
            new ShipmentDataCheckoutRequestValidatorPlugin(),
            new AddressSourceCheckoutRequestValidatorPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\CheckoutRestApiExtension\Dependency\Plugin\CheckoutDataResponseMapperPluginInterface>
     */
    protected function getCheckoutDataResponseMapperPlugins(): array
    {
        return [
            new SelectedPaymentMethodCheckoutDataResponseMapperPlugin(),
        ];
    }
}
