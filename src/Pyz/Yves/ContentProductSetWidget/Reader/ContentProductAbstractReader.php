<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductSetWidget\Reader;

use Generated\Shared\Transfer\ProductSetDataStorageTransfer;
use SprykerShop\Yves\ContentProductSetWidget\Dependency\Client\ContentProductSetWidgetToProductStorageClientInterface;

class ContentProductAbstractReader implements ContentProductAbstractReaderInterface
{
    /**
     * @var \SprykerShop\Yves\ContentProductSetWidget\Dependency\Client\ContentProductSetWidgetToProductStorageClientInterface
     */
    protected $productStorageClient;

    /**
     * @param \SprykerShop\Yves\ContentProductSetWidget\Dependency\Client\ContentProductSetWidgetToProductStorageClientInterface $productStorageClient
     */
    public function __construct(ContentProductSetWidgetToProductStorageClientInterface $productStorageClient)
    {
        $this->productStorageClient = $productStorageClient;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetDataStorageTransfer $productSetDataStorageTransfer
     * @param array $selectedAttributes
     * @param string $localeName
     *
     * @return array<\Generated\Shared\Transfer\ProductViewTransfer>
     */
    public function findProductAbstractCollection(
        ProductSetDataStorageTransfer $productSetDataStorageTransfer,
        array $selectedAttributes,
        string $localeName,
    ): array {
        $productAbstractViewCollection = [];

        foreach ($productSetDataStorageTransfer->getProductAbstractIds() as $idProductAbstract) {
            $productAbstract = $this->productStorageClient->findProductAbstractStorageData($idProductAbstract, $localeName);

            if (!$productAbstract) {
                continue;
            }

            $productAbstractSelectedAttributes = $this->getSelectedAttributesByIdProductAbstract($idProductAbstract, $selectedAttributes);
            $productAbstractViewCollection[] = $this->productStorageClient
                ->mapProductAbstractStorageData($productAbstract, $localeName, $productAbstractSelectedAttributes);
        }

        return $productAbstractViewCollection;
    }

    /**
     * @param int $idProductAbstract
     * @param array $selectedAttributes
     *
     * @return array
     */
    protected function getSelectedAttributesByIdProductAbstract(int $idProductAbstract, array $selectedAttributes): array
    {
        return isset($selectedAttributes[$idProductAbstract]) ? array_filter($selectedAttributes[$idProductAbstract]) : [];
    }
}
