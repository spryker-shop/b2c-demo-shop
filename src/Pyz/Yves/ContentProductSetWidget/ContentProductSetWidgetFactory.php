<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductSetWidget;

use Pyz\Yves\ContentProductSetWidget\Twig\ContentProductSetTwigFunction;
use SprykerShop\Yves\ContentProductSetWidget\ContentProductSetWidgetFactory as SprykerContentProductSetWidgetFactory;
use SprykerShop\Yves\ContentProductSetWidget\Twig\ContentProductSetTwigFunction as SprykerContentProductSetTwigFunction;
use Twig\Environment;

class ContentProductSetWidgetFactory extends SprykerContentProductSetWidgetFactory
{
    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \SprykerShop\Yves\ContentProductSetWidget\Twig\ContentProductSetTwigFunction
     */
    public function createContentProductSetTwigFunction(
        Environment $twig,
        string $localeName
    ): SprykerContentProductSetTwigFunction {
        return new ContentProductSetTwigFunction(
            $twig,
            $localeName,
            $this->createContentProductSetReader(),
            $this->createContentProductAbstractReader()
        );
    }
}
