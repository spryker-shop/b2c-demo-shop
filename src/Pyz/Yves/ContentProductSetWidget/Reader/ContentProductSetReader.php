<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductSetWidget\Reader;

use Generated\Shared\Transfer\ProductSetDataStorageTransfer;
use SprykerShop\Yves\ContentProductSetWidget\Dependency\Client\ContentProductSetWidgetToContentProductSetClientInterface;
use SprykerShop\Yves\ContentProductSetWidget\Dependency\Client\ContentProductSetWidgetToProductSetStorageClientInterface;

class ContentProductSetReader implements ContentProductSetReaderInterface
{
    /**
     * @var \SprykerShop\Yves\ContentProductSetWidget\Dependency\Client\ContentProductSetWidgetToContentProductSetClientInterface
     */
    protected $contentProductSetClient;

    /**
     * @var \SprykerShop\Yves\ContentProductSetWidget\Dependency\Client\ContentProductSetWidgetToProductSetStorageClientInterface
     */
    protected $productSetStorageClient;

    /**
     * @param \SprykerShop\Yves\ContentProductSetWidget\Dependency\Client\ContentProductSetWidgetToContentProductSetClientInterface $contentProductSetClient
     * @param \SprykerShop\Yves\ContentProductSetWidget\Dependency\Client\ContentProductSetWidgetToProductSetStorageClientInterface $productSetStorageClient
     */
    public function __construct(
        ContentProductSetWidgetToContentProductSetClientInterface $contentProductSetClient,
        ContentProductSetWidgetToProductSetStorageClientInterface $productSetStorageClient,
    ) {
        $this->contentProductSetClient = $contentProductSetClient;
        $this->productSetStorageClient = $productSetStorageClient;
    }

    /**
     * @param string $contentKey
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductSetDataStorageTransfer|null
     */
    public function findProductSet(string $contentKey, string $localeName): ?ProductSetDataStorageTransfer
    {
        $contentProductSetTypeTransfer = $this->contentProductSetClient->executeProductSetTypeByKey($contentKey, $localeName);

        if ($contentProductSetTypeTransfer === null) {
            return null;
        }

        return $this->productSetStorageClient
            ->getProductSetByIdProductSet($contentProductSetTypeTransfer->getIdProductSet(), $localeName);
    }
}
