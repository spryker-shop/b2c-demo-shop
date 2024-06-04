<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage;

use SprykerShop\Yves\CartPage\CartPageFactory as SprykerShopCartPageFactory;
use Twig\Environment;

class CartPageFactory extends SprykerShopCartPageFactory
{
    /**
     * @return \Twig\Environment
     */
    public function getTwigEnvironment(): Environment
    {
        return $this->getProvidedDependency(CartPageDependencyProvider::TWIG_ENVIRONMENT);
    }
}
