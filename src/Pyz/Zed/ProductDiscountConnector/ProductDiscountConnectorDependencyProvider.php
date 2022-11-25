<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductDiscountConnector;

use Spryker\Zed\ProductBundleDiscountConnector\Communication\Plugin\ProductDiscountConnector\ProductBundleProductAttributeCollectorExpanderPlugin;
use Spryker\Zed\ProductBundleDiscountConnector\Communication\Plugin\ProductDiscountConnector\ProductBundleProductAttributeDecisionRuleExpanderPlugin;
use Spryker\Zed\ProductDiscountConnector\ProductDiscountConnectorDependencyProvider as SprykerProductDiscountConnectorDependencyProvider;

class ProductDiscountConnectorDependencyProvider extends SprykerProductDiscountConnectorDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\ProductDiscountConnectorExtension\Dependency\Plugin\ProductAttributeCollectorExpanderPluginInterface>
     */
    protected function getProductAttributeCollectorExpanderPlugins(): array
    {
        return [
            new ProductBundleProductAttributeCollectorExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\ProductDiscountConnectorExtension\Dependency\Plugin\ProductAttributeDecisionRuleExpanderPluginInterface>
     */
    protected function getProductAttributeDecisionRuleExpanderPlugins(): array
    {
        return [
            new ProductBundleProductAttributeDecisionRuleExpanderPlugin(),
        ];
    }
}
