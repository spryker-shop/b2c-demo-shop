<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductDetailPage\Expander;

use Spryker\Client\ProductQuantityStorage\ProductQuantityStorageClientInterface;

class QuantityRestrictionViewDataExpander implements QuantityRestrictionViewDataExpanderInterface
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
     * @param array $viewData
     *
     * @return array
     */
    public function expandProductDetailViewWithQuantityRestrictions(array $viewData): array
    {
        $fkProductConcrete = $viewData['product']->getIdProductConcrete();

        if ($fkProductConcrete === null) {
            return $viewData;
        }

        return $this->setQuantityRestrictionsToViewData($fkProductConcrete, $viewData);
    }

    /**
     * @param int $fkProductConcrete
     * @param array $viewData
     *
     * @return array
     */
    protected function setQuantityRestrictionsToViewData(int $fkProductConcrete, array $viewData): array
    {
        $viewData['minQuantity'] = 1;
        $viewData['maxQuantity'] = null;
        $viewData['quantityInterval'] = 1;

        $productQuantityStorageTransfer = $this->productQuantityStorageClient
            ->findProductQuantityStorage($fkProductConcrete);

        if ($productQuantityStorageTransfer !== null) {
            $viewData['minQuantity'] = $productQuantityStorageTransfer->getQuantityMin() ?? 1;
            $viewData['maxQuantity'] = $productQuantityStorageTransfer->getQuantityMax();
            $viewData['quantityInterval'] = $productQuantityStorageTransfer->getQuantityInterval() ?? 1;
        }

        return $viewData;
    }
}
