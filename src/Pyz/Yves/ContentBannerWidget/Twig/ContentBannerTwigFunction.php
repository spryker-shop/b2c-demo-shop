<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ContentBannerWidget\Twig;

use SprykerShop\Yves\ContentBannerWidget\Twig\ContentBannerTwigFunction as SprykerContentBannerTwigFunction;

class ContentBannerTwigFunction extends SprykerContentBannerTwigFunction
{
    /**
     * @uses \Spryker\Shared\ContentBanner\ContentBannerConfig::WIDGET_TEMPLATE_IDENTIFIER_JUMBOTRON
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_JUMBOTRON = 'banner-jumbotron';

    /**
     * @return array
     */
    protected function getAvailableTemplates(): array
    {
        return array_merge(
            parent::getAvailableTemplates(),
            [
                static::WIDGET_TEMPLATE_IDENTIFIER_JUMBOTRON => '@ContentBannerWidget/views/banner/banner-jumbotron.twig',
            ]
        );
    }
}
