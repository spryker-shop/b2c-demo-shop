<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentBannerWidget\Twig;

use SprykerShop\Yves\ContentBannerWidget\Twig\ContentBannerTwigFunction as SprykerContentBannerTwigFunction;

class ContentBannerTwigFunction extends SprykerContentBannerTwigFunction
{
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER = 'slider';
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITHOUT_LINK = 'slider-without-link';

    /**
     * @return array
     */
    protected function getAvailableTemplates(): array
    {
        return array_merge(
            parent::getAvailableTemplates(),
            [
                static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER => '@ContentBannerWidget/views/slider/slider.twig',
                static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITHOUT_LINK => '@ContentBannerWidget/views/slider-without-link/slider-without-link.twig',
            ]
        );
    }
}
