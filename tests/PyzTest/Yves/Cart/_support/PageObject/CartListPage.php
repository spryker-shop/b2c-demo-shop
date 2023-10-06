<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Cart\PageObject;

class CartListPage
{
    /**
     * @var string
     */
    public const START_CHECKOUT_XPATH = '[data-qa="cart-go-to-checkout"]';

    /**
     * @var string
     */
    public const CART_HEADER = 'Cart';

    /**
     * @var string
     */
    public const FIRST_CART_ITEM_QUANTITY_INPUT_XPATH = '[data-qa*="cart-quantity-input"] [data-qa="quantity-input"]';

    /**
     * @var string
     */
    public const FIRST_CART_ITEM_CHANGE_QUANTITY_BUTTON_XPATH = '[data-qa*="cart-quantity-input"] [data-qa="quantity-input-submit"]';
}
