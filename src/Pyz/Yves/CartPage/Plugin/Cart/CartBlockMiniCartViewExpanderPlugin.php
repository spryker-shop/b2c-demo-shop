<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage\Plugin\Cart;

use Generated\Shared\Transfer\MiniCartViewTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Kernel\AbstractPlugin;
use SprykerShop\Yves\CartPageExtension\Dependency\Plugin\MiniCartViewExpanderPluginInterface;

/**
 * @method \Pyz\Yves\CartPage\CartPageFactory getFactory()
 */
class CartBlockMiniCartViewExpanderPlugin extends AbstractPlugin implements MiniCartViewExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\MiniCartViewTransfer $miniCartViewTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\MiniCartViewTransfer
     */
    public function expand(
        MiniCartViewTransfer $miniCartViewTransfer,
        QuoteTransfer $quoteTransfer,
    ): MiniCartViewTransfer {
        if (!$miniCartViewTransfer->getCounterOnly()) {
            $content = $this->getFactory()
                ->getTwigEnvironment()
                ->render('@ShopUi/components/organisms/navigation-top-async/navigation-top-async.twig');

            $miniCartViewTransfer->setContent($content);
        }

        return $miniCartViewTransfer;
    }
}
