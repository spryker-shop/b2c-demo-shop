<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductWidget\Reader;

interface ContentProductAbstractReaderInterface
{
    /**
     * @param string $contentKey
     * @param string $localeName
     *
     * @return array<\Generated\Shared\Transfer\ProductViewTransfer>
     */
    public function getPyzProductAbstractCollection(string $contentKey, string $localeName): array;
}
