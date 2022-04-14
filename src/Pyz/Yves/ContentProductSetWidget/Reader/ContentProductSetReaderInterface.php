<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductSetWidget\Reader;

use Generated\Shared\Transfer\ProductSetDataStorageTransfer;

interface ContentProductSetReaderInterface
{
    /**
     * @param string $contentKey
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductSetDataStorageTransfer|null
     */
    public function findProductSet(string $contentKey, string $localeName): ?ProductSetDataStorageTransfer;
}
