<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\SalesQuantity;

use Spryker\Zed\DiscountPromotion\Communication\Plugin\SalesQuantity\NonSplittablePromotionProductItemFilterPlugin;
use Spryker\Zed\SalesQuantity\SalesQuantityDependencyProvider as SprykerSalesQuantityDependencyProvider;

class SalesQuantityDependencyProvider extends SprykerSalesQuantityDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\SalesQuantityExtension\Dependency\Plugin\NonSplittableItemFilterPluginInterface>
     */
    protected function getNonSplittableItemFilterPlugins(): array
    {
        return [
            new NonSplittablePromotionProductItemFilterPlugin(),
        ];
    }
}
