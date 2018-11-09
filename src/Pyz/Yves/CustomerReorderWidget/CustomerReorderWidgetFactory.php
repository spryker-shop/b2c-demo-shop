<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CustomerReorderWidget;

use Pyz\Yves\CustomerReorderWidget\Model\CartFiller;
use SprykerShop\Yves\CustomerReorderWidget\CustomerReorderWidgetFactory as SprykerCustomerReorderWidgetFactory;
use SprykerShop\Yves\CustomerReorderWidget\Model\CartFillerInterface;

class CustomerReorderWidgetFactory extends SprykerCustomerReorderWidgetFactory
{
    /**
     * @return \SprykerShop\Yves\CustomerReorderWidget\Model\CartFillerInterface
     */
    public function createCartFiller(): CartFillerInterface
    {
        return new CartFiller(
            $this->getCartClient(),
            $this->createItemsFetcher()
        );
    }
}
