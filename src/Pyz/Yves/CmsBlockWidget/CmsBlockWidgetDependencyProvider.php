<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CmsBlockWidget;

use Spryker\Yves\CmsBlock\Twig\Plugin\TwigCmsBlockPlaceholder;
use SprykerShop\Yves\CmsBlockWidget\CmsBlockWidgetDependencyProvider as SprykerCmsBlockWidgetDependencyProvider;
use SprykerShop\Yves\CmsBlockWidget\Plugin\Twig\TwigCmsBlock;

class CmsBlockWidgetDependencyProvider extends SprykerCmsBlockWidgetDependencyProvider
{
    /**
     * @return \Spryker\Yves\Twig\Plugin\TwigFunctionPluginInterface[]
     */
    protected function getTwigFunctionPlugins()
    {
        return [
            new TwigCmsBlock(),
            new TwigCmsBlockPlaceholder(),
        ];
    }
}
