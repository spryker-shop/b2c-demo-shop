<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage\RestrictionsSetter;

interface QuantityRestrictionsSetterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer[] $itemTransfers
     *
     * @return \Generated\Shared\Transfer\ProductQuantityTransfer[]
     */
    public function setQuantityRestrictions(array $itemTransfers): array;
}
