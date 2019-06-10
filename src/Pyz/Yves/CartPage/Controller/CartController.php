<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage\Controller;

use Generated\Shared\Transfer\ProductQuantityTransfer;
use SprykerShop\Yves\CartPage\Controller\CartController as SprykerCartController;
use SprykerShop\Yves\CartPage\Plugin\Provider\CartControllerProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\CartPage\CartPageFactory getFactory()
 */
class CartController extends SprykerCartController
{
    public const REQUEST_HEADER_REFERER = 'referer';

    /**
     * @param string $sku
     * @param float $quantity
     * @param array $optionValueIds
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction($sku, $quantity, array $optionValueIds, Request $request)
    {
        parent::addAction($sku, $quantity, $optionValueIds, $request);

        return $this->redirect($request);
    }

    /**
     * @param array|null $selectedAttributes
     *
     * @return array
     */
    protected function executeIndexAction(?array $selectedAttributes): array
    {
        $viewData = parent::executeIndexAction($selectedAttributes);
        $itemTransfers = $viewData['cartItems'];

        $viewData['quantityRestrictionsBySku'] = $this->setQuantityRestrictions($itemTransfers);

        return $viewData;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer[] $itemTransfers
     *
     * @return \Generated\Shared\Transfer\ProductQuantityTransfer[]
     */
    protected function setQuantityRestrictions(array $itemTransfers): array
    {
        $quantityRestrictionsBySku = [];
        $productQuantityStorageClient = $this->getFactory()->getProductQuantityStorageClient();

        foreach ($itemTransfers as $itemTransfer) {
            $quantityMin = 1;
            $quantityMax = null;
            $quantityInterval = null;
            $productQuantityStorageTransfer = $productQuantityStorageClient->findProductQuantityStorage($itemTransfer->getId());
            if ($productQuantityStorageTransfer !== null) {
                $quantityMin = $productQuantityStorageTransfer->getQuantityMin() ?? 1;
                $quantityMax = $productQuantityStorageTransfer->getQuantityMax();
                $quantityInterval = $productQuantityStorageTransfer->getQuantityInterval() ?? 1;
            }

            $productQuantityTransfer = new ProductQuantityTransfer();
            $productQuantityTransfer->setQuantityMin($quantityMin)
                ->setQuantityMax($quantityMax)
                ->setQuantityInterval($quantityInterval);
            $quantityRestrictionsBySku[$itemTransfer->getSku()] = $productQuantityTransfer;
        }

        return $quantityRestrictionsBySku;
    }

    /**
     * @param string $sku
     * @param string|null $groupKey
     * @param \Symfony\Component\HttpFoundation\Request|null $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($sku, $groupKey = null, ?Request $request = null)
    {
        parent::removeAction($sku, $groupKey);

        return $this->redirect($request);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirect(Request $request)
    {
        if ($request->headers->has(static::REQUEST_HEADER_REFERER)) {
            return $this->redirectResponseExternal($request->headers->get(static::REQUEST_HEADER_REFERER));
        }

        return $this->redirectResponseInternal(CartControllerProvider::ROUTE_CART);
    }
}
