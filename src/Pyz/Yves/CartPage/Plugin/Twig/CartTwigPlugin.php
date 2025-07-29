<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\CartPage\Plugin\Twig;

use Spryker\Service\Container\ContainerInterface;
use SprykerShop\Yves\CartPage\Plugin\Twig\CartTwigPlugin as SprykerCartTwigPlugin;
use Twig\Environment;
use Twig\TwigFunction;

class CartTwigPlugin extends SprykerCartTwigPlugin
{
    /**
     * @var string
     */
    protected const FUNCTION_NAME_GET_QUOTE = 'getQuote';

    /**
     * @var string
     */
    protected const FUNCTION_NAME_GET_CART_ITEMS = 'getCartItems';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Twig\Environment $twig
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Twig\Environment
     */
    public function extend(Environment $twig, ContainerInterface $container): Environment
    {
        $twig = parent::extend($twig, $container);

        $twig = $this->addQuoteFunction($twig);
        $twig = $this->addCartItemsFunction($twig);

        return $twig;
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\Environment
     */
    protected function addQuoteFunction(Environment $twig): Environment
    {
        $quoteFunction = new TwigFunction(static::FUNCTION_NAME_GET_QUOTE, function () {
            return $this->getFactory()
                ->getCartClient()
                ->getQuote();
        });

        $twig->addFunction($quoteFunction);

        return $twig;
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return \Twig\Environment
     */
    protected function addCartItemsFunction(Environment $twig): Environment
    {
        $quoteFunction = new TwigFunction(static::FUNCTION_NAME_GET_CART_ITEMS, function () {
            return $this->getFactory()
                ->createCartItemReader()
                ->getCartItems(
                    $this->getFactory()->getCartClient()->getQuote(),
                );
        });

        $twig->addFunction($quoteFunction);

        return $twig;
    }
}
