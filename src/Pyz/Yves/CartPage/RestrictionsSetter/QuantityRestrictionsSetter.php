<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage\RestrictionsSetter;

use Generated\Shared\Transfer\ProductQuantityStorageTransfer;
use Generated\Shared\Transfer\ProductQuantityTransfer;
use Spryker\Client\ProductQuantityStorage\ProductQuantityStorageClientInterface;

class QuantityRestrictionsSetter implements QuantityRestrictionsSetterInterface
{
    /**
     * @var \Spryker\Client\ProductQuantityStorage\ProductQuantityStorageClientInterface
     */
    protected $productQuantityStorageClient;

    /**
     * @param \Spryker\Client\ProductQuantityStorage\ProductQuantityStorageClientInterface $productQuantityStorageClient
     */
    public function __construct(ProductQuantityStorageClientInterface $productQuantityStorageClient)
    {
        $this->productQuantityStorageClient = $productQuantityStorageClient;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer[] $itemTransfers
     *
     * @return \Generated\Shared\Transfer\ProductQuantityTransfer[]
     */
    public function setQuantityRestrictions(array $itemTransfers): array
    {
        $quantityRestrictionsBySku = [];

        foreach ($itemTransfers as $itemTransfer) {
            $productQuantityStorageTransfer = $this->productQuantityStorageClient->findProductQuantityStorage($itemTransfer->getId());
            $productQuantityTransfer = $this->createProductQuantityTransferWithRestrictions($productQuantityStorageTransfer);
            $quantityRestrictionsBySku[$itemTransfer->getSku()] = $productQuantityTransfer;
        }

        return $quantityRestrictionsBySku;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductQuantityStorageTransfer|null $productQuantityStorageTransfer
     *
     * @return \Generated\Shared\Transfer\ProductQuantityTransfer
     */
    protected function createProductQuantityTransferWithRestrictions(?ProductQuantityStorageTransfer $productQuantityStorageTransfer): ProductQuantityTransfer
    {
        $quantityMin = 1;
        $quantityMax = null;
        $quantityInterval = 1;

        if ($productQuantityStorageTransfer !== null) {
            $quantityMin = $productQuantityStorageTransfer->getQuantityMin() ?? 1;
            $quantityMax = $productQuantityStorageTransfer->getQuantityMax();
            $quantityInterval = $productQuantityStorageTransfer->getQuantityInterval() ?? 1;
        }

        return (new ProductQuantityTransfer())
            ->setQuantityMin($quantityMin)
            ->setQuantityMax($quantityMax)
            ->setQuantityInterval($quantityInterval);
    }
}
