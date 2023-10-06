<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentBannerWidget\Twig;

use SprykerShop\Yves\ContentBannerWidget\Twig\ContentBannerTwigFunctionProvider as SprykerShopContentBannerTwigFunctionProvider;

class ContentBannerTwigFunctionProvider extends SprykerShopContentBannerTwigFunctionProvider
{
    /**
     * @var string
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER = 'slider';

    /**
     * @var string
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITHOUT_LINK = 'slider-without-link';

    /**
     * @return array<string, string>
     */
    protected function getAvailableTemplates(): array
    {
        $contentWidgetTemplates = parent::getAvailableTemplates();

        return [
            static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER => '@ContentBannerWidget/views/slider/slider.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITHOUT_LINK => '@ContentBannerWidget/views/slider-without-link/slider-without-link.twig',
        ] + $contentWidgetTemplates;
    }
}
