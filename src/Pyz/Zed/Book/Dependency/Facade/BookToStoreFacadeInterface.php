<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface BookToStoreFacadeInterface
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
