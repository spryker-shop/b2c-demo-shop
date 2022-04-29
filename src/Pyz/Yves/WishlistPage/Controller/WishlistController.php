<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\WishlistPage\Controller;

use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;
use SprykerShop\Yves\WishlistPage\Controller\WishlistController as SprykerWishlistController;
use SprykerShop\Yves\WishlistPage\Plugin\Router\WishlistPageRouteProviderPlugin;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\WishlistPage\WishlistPageFactory getFactory()
 */
class WishlistController extends SprykerWishlistController
{
    /**
     * @var string
     */
    public const PYZ_REQUEST_HEADER_REFERER = 'referer';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addItemAction(Request $request)
    {
        $wishlistItemTransfer = $this->getWishlistItemTransferFromRequest($request);
        if (!$wishlistItemTransfer) {
            return $this->redirectResponseInternal(CustomerPageRouteProviderPlugin::ROUTE_NAME_LOGIN);
        }

        $wishlistItemTransfer = $this->getFactory()
            ->getWishlistClient()
            ->addItem($wishlistItemTransfer);
        if (!$wishlistItemTransfer->getIdWishlistItem()) {
            $this->addErrorMessage('customer.account.wishlist.item.not_added');
        } else {
            $this->addSuccessMessage('cart.add.items.success');
        }

        if ($request->headers->has(static::PYZ_REQUEST_HEADER_REFERER)) {
            return $this->redirectResponseExternal($request->headers->get(static::PYZ_REQUEST_HEADER_REFERER));
        }

        return $this->redirectResponseInternal(
            WishlistPageRouteProviderPlugin::ROUTE_NAME_WISHLIST_DETAILS,
            [
            'wishlistName' => $wishlistItemTransfer->getWishlistName(),
            ]
        );
    }
}
