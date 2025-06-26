<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\CartPage\Plugin\Twig;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\TwigExtension\Dependency\Plugin\TwigPluginInterface;
use Spryker\Yves\Kernel\AbstractPlugin;
use Twig\Environment;

/**
 * @method \SprykerShop\Yves\CartPage\CartPageFactory getFactory()
 */
class QuoteTwigPlugin extends AbstractPlugin implements TwigPluginInterface
{
    /**
     * @param \Twig\Environment $twig
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Twig\Environment
     */
    public function extend(Environment $twig, ContainerInterface $container): Environment
    {
        $container->set('quote', function () {
            return $this->getFactory()
                ->getCartClient()
                ->getQuote();
        });

        $container->set('cartItems', function () {
            $quote = $this->getFactory()
                ->getCartClient()
                ->getQuote();

            return $this->getFactory()
                ->createCartItemReader()
                ->getCartItems($quote);
        });

        return $twig;
    }
}
