<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ContentProductWidget;

use Pyz\Yves\ContentProductWidget\Twig\ContentProductAbstractListTwigFunction;
use SprykerShop\Yves\ContentProductWidget\ContentProductWidgetFactory as SprykerContentProductWidgetFactory;
use SprykerShop\Yves\ContentProductWidget\Twig\ContentProductAbstractListTwigFunction as SprykerContentProductAbstractListTwigFunction;
use Twig\Environment;

class ContentProductWidgetFactory extends SprykerContentProductWidgetFactory
{
    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \Pyz\Yves\ContentProductWidget\Twig\ContentProductAbstractListTwigFunction
     */
    public function createContentBannerTwigFunction(Environment $twig, string $localeName): SprykerContentProductAbstractListTwigFunction
    {
        return new ContentProductAbstractListTwigFunction(
            $twig,
            $localeName,
            $this->createContentProductAbstractReader()
        );
    }
}
