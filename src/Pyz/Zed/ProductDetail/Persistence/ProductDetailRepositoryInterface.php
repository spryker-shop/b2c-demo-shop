<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetail\Persistence;

use Generated\Shared\Transfer\ProductResponseTransfer;

interface ProductDetailRepositoryInterface
{
    /**
     * Specification:
     * - Finds a product abstract by its ID.
     *
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductResponseTransfer|null
     */
    public function findProductAbstractBySku(string $sku): ?ProductResponseTransfer;
}
