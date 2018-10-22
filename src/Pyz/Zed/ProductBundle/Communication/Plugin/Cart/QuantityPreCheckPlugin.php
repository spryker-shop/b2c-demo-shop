<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductBundle\Communication\Plugin\Cart;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\CartPreCheckResponseTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Spryker\Zed\Cart\Dependency\CartPreCheckPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductBundle\Communication\ProductBundleCommunicationFactory getFactory()
 */
class QuantityPreCheckPlugin extends AbstractPlugin implements CartPreCheckPluginInterface
{
    const ADD_ITEMS_SUCCESS = 'cart.add.items.error.text';

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartPreCheckResponseTransfer
     */
    public function check(CartChangeTransfer $cartChangeTransfer)
    {
        $cartPreCheckResponseTransfer = new CartPreCheckResponseTransfer();
        $cartPreCheckResponseTransfer->setIsSuccess(true);

        foreach ($cartChangeTransfer->getItems() as $item) {
            if ($item->getQuantity() <= 0) {
                $messageTransfer = new MessageTransfer();
                $messageTransfer->setValue(static::ADD_ITEMS_SUCCESS);
                $cartPreCheckResponseTransfer->addMessage($messageTransfer);
                $cartPreCheckResponseTransfer->setIsSuccess(false);
            }

            break;
        }
         return $cartPreCheckResponseTransfer;
    }
}
