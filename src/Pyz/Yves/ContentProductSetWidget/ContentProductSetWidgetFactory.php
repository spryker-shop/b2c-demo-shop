<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductSetWidget;

use Pyz\Yves\ContentProductSetWidget\Twig\ContentProductSetTwigFunctionProvider;
use Spryker\Shared\Twig\TwigFunctionProvider;
use SprykerShop\Yves\ContentProductSetWidget\ContentProductSetWidgetFactory as SprykerContentProductSetWidgetFactory;
use Twig\Environment;

class ContentProductSetWidgetFactory extends SprykerContentProductSetWidgetFactory
{
    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \Spryker\Shared\Twig\TwigFunctionProvider
     */
    public function createContentProductSetTwigFunctionProvider(
        Environment $twig,
        string $localeName,
    ): TwigFunctionProvider {
        return new ContentProductSetTwigFunctionProvider(
            $twig,
            $localeName,
            $this->createContentProductSetReader(),
            $this->createContentProductAbstractReader(),
        );
    }
}
