<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Shipment;

use Spryker\Zed\GiftCard\Communication\Plugin\Shipment\GiftCardShipmentGroupMethodFilterPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Shipment\ShipmentDependencyProvider as SprykerShipmentDependencyProvider;

class ShipmentDependencyProvider extends SprykerShipmentDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Shipment\Communication\Plugin\ShipmentMethodAvailabilityPluginInterface>|array<\Spryker\Zed\ShipmentExtension\Dependency\Plugin\ShipmentMethodAvailabilityPluginInterface>
     */
    protected function getAvailabilityPlugins(Container $container): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Shipment\Communication\Plugin\ShipmentMethodPricePluginInterface>|array<\Spryker\Zed\ShipmentExtension\Dependency\Plugin\ShipmentMethodPricePluginInterface>
     */
    protected function getPricePlugins(Container $container): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Shipment\Communication\Plugin\ShipmentMethodDeliveryTimePluginInterface>|array<\Spryker\Zed\ShipmentExtension\Dependency\Plugin\ShipmentMethodDeliveryTimePluginInterface>
     */
    protected function getDeliveryTimePlugins(Container $container): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\ShipmentExtension\Dependency\Plugin\ShipmentMethodFilterPluginInterface>
     */
    protected function getMethodFilterPlugins(Container $container): array
    {
        return [
            new GiftCardShipmentGroupMethodFilterPlugin(),
        ];
    }
}
