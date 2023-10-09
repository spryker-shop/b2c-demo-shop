<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Business;

interface ExampleProductSalePageFacadeInterface
{
    /**
     * @return array<\Generated\Shared\Transfer\ProductLabelProductAbstractRelationsTransfer>
     */
    public function findProductLabelProductAbstractRelationChanges(): array;
}
