<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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