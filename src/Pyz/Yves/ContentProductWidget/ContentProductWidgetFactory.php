<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\ContentProductWidget;

use Pyz\Yves\ContentProductWidget\Twig\ContentProductAbstractListTwigFunctionProvider;
use Spryker\Shared\Twig\TwigFunctionProvider;
use SprykerShop\Yves\ContentProductWidget\ContentProductWidgetFactory as SprykerContentProductWidgetFactory;
use Twig\Environment;

class ContentProductWidgetFactory extends SprykerContentProductWidgetFactory
{
    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \Spryker\Shared\Twig\TwigFunctionProvider
     */
    public function createContentProductAbstractListTwigFunctionProvider(Environment $twig, string $localeName): TwigFunctionProvider
    {
        return new ContentProductAbstractListTwigFunctionProvider(
            $twig,
            $localeName,
            $this->createContentProductAbstractReader(),
        );
    }
}
