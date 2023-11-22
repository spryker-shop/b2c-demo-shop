<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductWidget\Twig;

use SprykerShop\Yves\ContentProductWidget\Twig\ContentProductAbstractListTwigFunctionProvider as SprykerShopContentProductAbstractListTwigFunctionProvider;

/**
 * @method \SprykerShop\Yves\ContentProductWidget\ContentProductWidgetFactory getFactory()
 */
class ContentProductAbstractListTwigFunctionProvider extends SprykerShopContentProductAbstractListTwigFunctionProvider
{
    /**
     * @var string
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITH_BUTTON = 'slider-with-button';

    /**
     * @var string
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER = 'slider';

    /**
     * @var string
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER_NOT_INCLUDE_GROUP = 'slider-not-include-group';

    /**
     * @return array<string, string>
     */
    protected function getAvailableTemplates(): array
    {
        $contentWidgetTemplates = parent::getAvailableTemplates();

        return [
            static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITH_BUTTON => '@ContentProductWidget/views/cms-product-abstract-and-button/cms-product-abstract-and-button.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER => '@ContentProductWidget/views/cms-product-abstract/cms-product-abstract.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER_NOT_INCLUDE_GROUP => '@ContentProductWidget/views/cms-product-abstract-not-include-group/cms-product-abstract-not-include-group.twig',
        ] + $contentWidgetTemplates;
    }
}
