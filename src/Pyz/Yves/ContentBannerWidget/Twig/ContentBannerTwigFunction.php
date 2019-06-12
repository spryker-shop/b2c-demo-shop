<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentBannerWidget\Twig;

use SprykerShop\Yves\ContentBannerWidget\Twig\ContentBannerTwigFunction as SprykerContentBannerTwigFunction;

class ContentBannerTwigFunction extends SprykerContentBannerTwigFunction
{
    protected const WIDGET_TEMPLATE_IDENTIFIER_JUMBOTRON = 'banner-jumbotron';
    protected const WIDGET_TEMPLATE_IDENTIFIER_JUMBOTRON_WITHOUT_LINK = 'banner-jumbotron-without-link';

    /**
     * @return array
     */
    protected function getAvailableTemplates(): array
    {
        return array_merge(
            parent::getAvailableTemplates(),
            [
                static::WIDGET_TEMPLATE_IDENTIFIER_JUMBOTRON => '@ContentBannerWidget/views/banner/banner-jumbotron.twig',
                static::WIDGET_TEMPLATE_IDENTIFIER_JUMBOTRON_WITHOUT_LINK => '@ContentBannerWidget/views/banner/banner-jumbotron-without-link.twig',
            ]
        );
    }
}
