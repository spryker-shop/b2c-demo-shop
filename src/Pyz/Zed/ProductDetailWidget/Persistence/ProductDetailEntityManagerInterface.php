<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailPageWidget\Persistence;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailEntityManagerInterface
{
    /**
     * Specification:
     * - Creates a product abstract if it does not exist.
     * - Finds a product abstract by its ID.
     * - Updates fields in the product abstract entity.
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function saveProductAbstract(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer;
}
