<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentNavigationWidget;

use Pyz\Yves\ContentNavigationWidget\Twig\ContentNavigationTwigFunction as SprykerShopContentNavigationTwigFunction;
use SprykerShop\Yves\ContentNavigationWidget\ContentNavigationWidgetFactory as SprykerShopContentNavigationWidgetFactory;
use SprykerShop\Yves\ContentNavigationWidget\Twig\ContentNavigationTwigFunction;
use Twig\Environment;

class ContentNavigationWidgetFactory extends SprykerShopContentNavigationWidgetFactory
{
    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \SprykerShop\Yves\ContentNavigationWidget\Twig\ContentNavigationTwigFunction
     */
    public function createContentNavigationTwigFunction(
        Environment $twig,
        string $localeName
    ): ContentNavigationTwigFunction {
        return new SprykerShopContentNavigationTwigFunction(
            $twig,
            $localeName,
            $this->getContentNavigationClient(),
            $this->getNavigationStorageClient()
        );
    }
}
