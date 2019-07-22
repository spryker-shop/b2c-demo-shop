<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductSetWidget\Twig;

use SprykerShop\Yves\ContentProductSetWidget\Twig\ContentProductSetTwigFunction as SprykerContentProductSetTwigFunction;

/**
 * @method \SprykerShop\Yves\ContentProductWidget\ContentProductWidgetFactory getFactory()
 */
class ContentProductSetTwigFunction extends SprykerContentProductSetTwigFunction
{
    protected const WIDGET_TEMPLATE_IDENTIFIER_ADD_TO_CART = 'add-to-cart';

    /**
     * @return array
     */
    protected function getAvailableTemplates(): array
    {
        return array_merge(
            parent::getAvailableTemplates(),
            [
                static::WIDGET_TEMPLATE_IDENTIFIER_ADD_TO_CART => '@ContentProductSetWidget/views/add-to-cart/add-to-cart.twig',
            ]
        );
    }
}
