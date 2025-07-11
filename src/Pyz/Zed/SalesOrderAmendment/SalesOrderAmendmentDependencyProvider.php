<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\SalesOrderAmendment;

use Spryker\Zed\CartNote\Communication\Plugin\SalesOrderAmendment\CartNoteSalesOrderItemCollectorPlugin;
use Spryker\Zed\ConfigurableBundleNote\Communication\Plugin\SalesOrderAmendment\ConfigurableBundleNoteSalesOrderItemCollectorPlugin;
use Spryker\Zed\SalesOrderAmendment\SalesOrderAmendmentDependencyProvider as SprykerSalesOrderAmendmentDependencyProvider;
use Spryker\Zed\SalesOrderAmendmentOms\Communication\Plugin\SalesOrderAmendment\OrderSalesOrderAmendmentValidatorRulePlugin;
use Spryker\Zed\SalesProductConfiguration\Communication\Plugin\SalesOrderAmendment\SalesProductConfigurationSalesOrderItemCollectorPlugin;
use Spryker\Zed\Shipment\Communication\Plugin\SalesOrderAmendment\ShipmentSalesOrderItemCollectorPlugin;

class SalesOrderAmendmentDependencyProvider extends SprykerSalesOrderAmendmentDependencyProvider
{
    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentValidatorRulePluginInterface>
     */
    protected function getSalesOrderAmendmentCreateValidationRulePlugins(): array
    {
        return [
            new OrderSalesOrderAmendmentValidatorRulePlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderItemCollectorPluginInterface>
     */
    protected function getSalesOrderItemCollectorPlugins(): array
    {
        return [
            new CartNoteSalesOrderItemCollectorPlugin(),
            new ShipmentSalesOrderItemCollectorPlugin(),
            new ConfigurableBundleNoteSalesOrderItemCollectorPlugin(),
            new SalesProductConfigurationSalesOrderItemCollectorPlugin(),
        ];
    }
}
