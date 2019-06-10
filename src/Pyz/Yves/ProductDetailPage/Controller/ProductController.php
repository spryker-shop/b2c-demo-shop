<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductDetailPage\Controller;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerShop\Yves\ProductDetailPage\Controller\ProductController as SprykerShopProductController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Client\Product\ProductClientInterface getClient()
 * @method \Pyz\Yves\ProductDetailPage\ProductDetailPageFactory getFactory()
 */
class ProductController extends SprykerShopProductController
{
    /**
     * @param array $productData
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executeDetailAction(array $productData, Request $request): array
    {
        $viewData = parent::executeDetailAction($productData, $request);

        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->addItem(
            (new ItemTransfer())->setIdProductAbstract($viewData['product']->getIdProductAbstract())
        );
        $viewData['cart'] = $quoteTransfer;

        return $this->setQuantityRestrictions($viewData);
    }

    /**
     * @param array $viewData
     *
     * @return array
     */
    protected function setQuantityRestrictions(array $viewData): array
    {
        $viewData['minQuantity'] = 1;
        $viewData['maxQuantity'] = null;
        $viewData['quantityInterval'] = 1;

        $fkProductConcrete = $viewData['product']->getIdProductConcrete();

        if ($fkProductConcrete === null) {
            return $viewData;
        }

        $productQuantityStorageTransfer = $this->getFactory()
            ->getProductQuantityStorageClient()
            ->findProductQuantityStorage($fkProductConcrete);

        if ($productQuantityStorageTransfer !== null) {
            $viewData['minQuantity'] = $productQuantityStorageTransfer->getQuantityMin() ?? 1;
            $viewData['maxQuantity'] = $productQuantityStorageTransfer->getQuantityMax();
            $viewData['quantityInterval'] = $productQuantityStorageTransfer->getQuantityInterval() ?? 1;
        }

        return $viewData;
    }
}
