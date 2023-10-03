<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentBannerWidget;

use Pyz\Yves\ContentBannerWidget\Twig\ContentBannerTwigFunctionProvider;
use Spryker\Shared\Twig\TwigFunctionProvider;
use SprykerShop\Yves\ContentBannerWidget\ContentBannerWidgetFactory as SprykerContentBannerWidgetFactory;
use Twig\Environment;

class ContentBannerWidgetFactory extends SprykerContentBannerWidgetFactory
{
    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \Spryker\Shared\Twig\TwigFunctionProvider
     */
    public function createContentBannerTwigFunctionProvider(Environment $twig, string $localeName): TwigFunctionProvider
    {
        return new ContentBannerTwigFunctionProvider(
            $twig,
            $localeName,
            $this->getContentBannerClient(),
        );
    }
}
