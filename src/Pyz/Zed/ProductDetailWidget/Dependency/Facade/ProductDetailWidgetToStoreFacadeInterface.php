<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailPageWidget\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface ProductDetailWidgetToStoreFacadeInterface
{
    /**
     * Specification:
     * - Returns the current store information.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(): StoreTransfer;
}
