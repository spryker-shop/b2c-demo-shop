<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductWidget\Reader;

use SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToContentProductClientBridgeInterface;
use SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToProductStorageClientBridgeInterface;

class ContentProductAbstractReader implements ContentProductAbstractReaderInterface
{
    /**
     * @var \SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToContentProductClientBridgeInterface
     */
    protected $contentProductClient;

    /**
     * @var \SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToProductStorageClientBridgeInterface
     */
    protected $productStorageClient;

    /**
     * @param \SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToContentProductClientBridgeInterface $contentProductClient
     * @param \SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToProductStorageClientBridgeInterface $productStorageClient
     */
    public function __construct(
        ContentProductWidgetToContentProductClientBridgeInterface $contentProductClient,
        ContentProductWidgetToProductStorageClientBridgeInterface $productStorageClient,
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
    public function getProductAbstractCollection(string $contentKey, string $localeName): array
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
