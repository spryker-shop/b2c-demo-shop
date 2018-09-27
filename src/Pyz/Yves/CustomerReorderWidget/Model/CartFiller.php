<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CustomerReorderWidget\Model;

use ArrayObject;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use SprykerShop\Yves\CustomerReorderWidget\Model\CartFiller as SprykerCartFiller;

class CartFiller extends SprykerCartFiller
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    protected function updateCart(array $orderItems, OrderTransfer $orderTransfer): void
    {
        $cartChangeTransfer = new CartChangeTransfer();
        $quoteTransfer = (new QuoteTransfer())
            ->setCurrency((new CurrencyTransfer())->setCode($orderTransfer->getCurrencyIsoCode()))
            ->setStore((new StoreTransfer())->setName($orderTransfer->getStore()));
        $cartChangeTransfer->setQuote($quoteTransfer);
        $orderItemsObject = new ArrayObject($orderItems);
        $cartChangeTransfer->setItems($orderItemsObject);

        $this->cartClient->addValidItems($cartChangeTransfer, [static::PARAM_ORDER_REFERENCE => $orderTransfer->getOrderReference()]);
    }
}
