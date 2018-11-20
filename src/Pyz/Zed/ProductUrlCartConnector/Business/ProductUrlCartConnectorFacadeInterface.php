<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductUrlCartConnector\Business;

use Generated\Shared\Transfer\CartChangeTransfer;

interface ProductUrlCartConnectorFacadeInterface
{
    /**
     * Specification:
     * - Reads a persisted abstract product from database.
     * - Expands the items of the CartChangeTransfer with the abstract product's url.
     * - Returns the expanded CartChangeTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer);
}
