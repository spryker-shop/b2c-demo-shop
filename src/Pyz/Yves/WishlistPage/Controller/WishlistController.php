<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\WishlistPage\Controller;

use SprykerShop\Yves\CustomerPage\Plugin\Provider\CustomerPageControllerProvider;
use SprykerShop\Yves\WishlistPage\Plugin\Provider\WishlistPageControllerProvider;
use Symfony\Component\HttpFoundation\Request;
use SprykerShop\Yves\WishlistPage\Controller\WishlistController as SprykerWishlistController;

/**
 * @method \SprykerShop\Yves\WishlistPage\WishlistPageFactory getFactory()
 */
class WishlistController extends SprykerWishlistController
{
    public const REQUEST_HEADER_REFERER = 'referer';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addItemAction(Request $request)
    {
        $wishlistItemTransfer = $this->getWishlistItemTransferFromRequest($request);
        if (!$wishlistItemTransfer) {
            return $this->redirectResponseInternal(CustomerPageControllerProvider::ROUTE_LOGIN);
        }

        $wishlistItemTransfer = $this->getFactory()
            ->getWishlistClient()
            ->addItem($wishlistItemTransfer);
        if (!$wishlistItemTransfer->getIdWishlistItem()) {
            $this->addErrorMessage('customer.account.wishlist.item.not_added');
        } else {
            $this->addSuccessMessage('cart.add.items.success');
        }

        if ($request->headers->has(static::REQUEST_HEADER_REFERER)) {
            return $this->redirectResponseExternal($request->headers->get(static::REQUEST_HEADER_REFERER));
        }

        return $this->redirectResponseInternal(WishlistPageControllerProvider::ROUTE_WISHLIST_DETAILS, [
            'wishlistName' => $wishlistItemTransfer->getWishlistName(),
        ]);
    }
}
