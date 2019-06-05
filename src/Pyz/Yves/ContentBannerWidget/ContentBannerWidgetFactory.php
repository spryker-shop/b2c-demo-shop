<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ContentBannerWidget;

use Pyz\Yves\ContentBannerWidget\Twig\ContentBannerTwigFunction;
use SprykerShop\Yves\ContentBannerWidget\Twig\ContentBannerTwigFunction as SprykerShopContentBannerTwigFunction;
use Twig\Environment;
use SprykerShop\Yves\ContentBannerWidget\ContentBannerWidgetFactory as SprykerContentBannerWidgetFactory;

class ContentBannerWidgetFactory extends SprykerContentBannerWidgetFactory
{
    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \Pyz\Yves\ContentBannerWidget\Twig\ContentBannerTwigFunction
     */
    public function createContentBannerTwigFunction(Environment $twig, string $localeName): SprykerShopContentBannerTwigFunction
    {
        return new ContentBannerTwigFunction(
            $twig,
            $localeName,
            $this->getContentBannerClient()
        );
    }
}
