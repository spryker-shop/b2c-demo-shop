<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailWidget\Business\Reader;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductDetailReaderInterface
{
    /**
     * Specification:
     * - Finds a product abstract by its ID.
     * - Returns a ProductDetailPageResponseTransfer containing product details and status.
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function findProductAbstractById(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer;
}
