<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\CartPage\Plugin\Provider\CartServiceProvider as SprykerCartServiceProvider;

/**
 * @method \SprykerShop\Yves\CartPage\CartPageFactory getFactory()
 */
class CartServiceProvider extends SprykerCartServiceProvider
{
    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function register(Application $app)
    {
        parent::register($app);

        $app['quote'] = $app->share(function () {
            $quote = $this->getFactory()
                ->getCartClient()
                ->getQuote();

            return $quote;
        });

        $app['cartItems'] = $app->share(function () {
            $cartItems = $this->getFactory()
                ->createCartItemReader()
                ->getCartItems(
                    $this->getFactory()->getCartClient()->getQuote()
                );

            return $cartItems;
        });
    }
}
