<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\ContentProductSetWidget\Twig;

use SprykerShop\Yves\ContentProductSetWidget\Twig\ContentProductSetTwigFunctionProvider as SprykerShopContentProductSetTwigFunctionProvider;

/**
 * @method \SprykerShop\Yves\ContentProductWidget\ContentProductWidgetFactory getFactory()
 */
class ContentProductSetTwigFunctionProvider extends SprykerShopContentProductSetTwigFunctionProvider
{
    /**
     * @var string
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_ADD_TO_CART = 'add-to-cart';

    /**
     * @return array<string>
     */
    protected function getAvailableTemplates(): array
    {
        $contentWidgetTemplates = parent::getAvailableTemplates();

        return [
            static::WIDGET_TEMPLATE_IDENTIFIER_ADD_TO_CART => '@ContentProductSetWidget/views/add-to-cart/add-to-cart.twig',
        ] + $contentWidgetTemplates;
    }
}
