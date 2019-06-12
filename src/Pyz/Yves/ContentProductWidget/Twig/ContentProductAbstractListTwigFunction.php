<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductWidget\Twig;

use SprykerShop\Yves\ContentProductWidget\Twig\ContentProductAbstractListTwigFunction as SprykerContentProductAbstractListTwigFunction;

/**
 * @method \SprykerShop\Yves\ContentProductWidget\ContentProductWidgetFactory getFactory()
 */
class ContentProductAbstractListTwigFunction extends SprykerContentProductAbstractListTwigFunction
{
    protected const WIDGET_TEMPLATE_IDENTIFIER_BUTTON = 'with-button';

        /**
         * @return array
         */
    protected function getAvailableTemplates(): array
    {
        return array_merge(
            parent::getAvailableTemplates(),
            [
                static::WIDGET_TEMPLATE_IDENTIFIER_BUTTON => '@ContentProductWidget/views/cms-product-abstract/cms-product-abstract-and-button.twig',
            ]
        );
    }
}
