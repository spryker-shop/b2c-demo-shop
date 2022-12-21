<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductWidget\Reader;

use Spryker\Client\ContentProduct\ContentProductClientInterface;
use Spryker\Client\ProductStorage\ProductStorageClientInterface;

class ContentProductAbstractReader implements ContentProductAbstractReaderInterface
{
    /**
     * @var \Spryker\Client\ContentProduct\ContentProductClientInterface
     */
    protected $contentProductClient;

    /**
     * @var \Spryker\Client\ProductStorage\ProductStorageClientInterface
     */
    protected $productStorageClient;

    /**
     * @param \Spryker\Client\ContentProduct\ContentProductClientInterface $contentProductClient
     * @param \Spryker\Client\ProductStorage\ProductStorageClientInterface $productStorageClient
     */
    public function __construct(
        ContentProductClientInterface $contentProductClient,
        ProductStorageClientInterface $productStorageClient
    ) {
        $this->contentProductClient = $contentProductClient;
        $this->productStorageClient = $productStorageClient;
    }

    /**
     * @param string $contentKey
     * @param string $localeName
     *
     * @return array<\Generated\Shared\Transfer\ProductViewTransfer>
     */
    public function getPyzProductAbstractCollection(string $contentKey, string $localeName): array
    {
        $contentProductAbstractListTypeTransfer = $this->contentProductClient->executeProductAbstractListTypeByKey($contentKey, $localeName);

        if ($contentProductAbstractListTypeTransfer === null) {
            return [];
        }

        $productAbstractViewCollection = $this
            ->productStorageClient
            ->getProductAbstractViewTransfers($contentProductAbstractListTypeTransfer->getIdProductAbstracts(), $localeName);

        return $productAbstractViewCollection;
    }
}
