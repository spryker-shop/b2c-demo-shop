<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Refund\Business;

use Spryker\Zed\Refund\Business\RefundBusinessFactory as SprykerRefundBusinessFactory;
use Spryker\Zed\Refund\RefundDependencyProvider;

/**
 * @method \Spryker\Zed\Refund\Persistence\RefundQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Refund\RefundConfig getConfig()
 */
class RefundBusinessFactory extends SprykerRefundBusinessFactory
{
    /**
     * @return array<\Spryker\Zed\Refund\Dependency\Plugin\RefundCalculatorPluginInterface>
     */
    protected function getRefundCalculatorPlugins(): array
    {
        return [
            $this->getProvidedDependency(RefundDependencyProvider::PLUGIN_ITEM_REFUND_CALCULATOR),
        ];
    }
}
