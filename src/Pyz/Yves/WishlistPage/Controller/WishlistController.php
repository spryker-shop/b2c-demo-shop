<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\WishlistPage\Controller;

use Generated\Shared\Transfer\WishlistResponseTransfer;
use Generated\Shared\Transfer\WishlistTransfer;
use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;
use SprykerShop\Yves\WishlistPage\Controller\WishlistController as SprykerWishlistController;
use SprykerShop\Yves\WishlistPage\Plugin\Router\WishlistPageRouteProviderPlugin;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\WishlistPage\WishlistPageFactory getFactory()
 */
class WishlistController extends SprykerWishlistController
{
    /**
     * @var string
     */
    public const REQUEST_HEADER_REFERER = 'referer';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addItemAction(Request $request): RedirectResponse
    {
        $wishlistItemTransfer = $this->getWishlistItemTransferFromRequest($request);
        if (!$wishlistItemTransfer) {
            return $this->redirectResponseInternal(CustomerPageRouteProviderPlugin::ROUTE_NAME_LOGIN);
        }

        $wishlistAddItemForm = $this->getFactory()->getWishlistAddItemForm()->handleRequest($request);

        if (!$wishlistAddItemForm->isSubmitted() || !$wishlistAddItemForm->isValid()) {
            $this->addErrorMessage(static::MESSAGE_FORM_CSRF_VALIDATION_ERROR);

            return $this->redirectResponseInternal(WishlistPageRouteProviderPlugin::ROUTE_NAME_WISHLIST_DETAILS, [
                'wishlistName' => $wishlistItemTransfer->getWishlistName(),
            ]);
        }

        $wishlistResponseTransfer = new WishlistResponseTransfer();
        if ($wishlistItemTransfer->getWishlistName() === static::DEFAULT_NAME) {
            $wishlistResponseTransfer = $this->getFactory()->getWishlistClient()->validateAndCreateWishlist(
                (new WishlistTransfer())
                    ->setName(static::DEFAULT_NAME)
                    ->setFkCustomer($wishlistItemTransfer->getFkCustomer()),
            );
        }

        $wishlistItemTransfer = $this->getFactory()
            ->getWishlistClient()
            ->addItem($wishlistItemTransfer);

        if (!$wishlistItemTransfer->getIdWishlistItem()) {
            if ($wishlistResponseTransfer->getWishlist()) {
                $this->getFactory()->getWishlistClient()->removeWishlistByName($wishlistResponseTransfer->getWishlist());
            }

            $this->addErrorMessage('customer.account.wishlist.item.not_added');

            return $this->redirectResponseInternal(WishlistPageRouteProviderPlugin::ROUTE_NAME_WISHLIST_OVERVIEW, [
                'wishlistName' => $wishlistItemTransfer->getWishlistName(),
            ]);
        }

        if ($request->headers->has(static::REQUEST_HEADER_REFERER)) {
            return $this->redirectResponseExternal($request->headers->get(static::REQUEST_HEADER_REFERER));
        }

        return $this->redirectResponseInternal(WishlistPageRouteProviderPlugin::ROUTE_NAME_WISHLIST_DETAILS, [
            'wishlistName' => $wishlistItemTransfer->getWishlistName(),
        ]);
    }
}
