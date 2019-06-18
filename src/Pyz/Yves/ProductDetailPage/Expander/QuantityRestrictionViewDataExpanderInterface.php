<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductDetailPage\Expander;

interface QuantityRestrictionViewDataExpanderInterface
{
    /**
     * @param array $viewData
     *
     * @return array
     */
    public function expandProductDetailViewWithQuantityRestrictions(array $viewData): array;
}
