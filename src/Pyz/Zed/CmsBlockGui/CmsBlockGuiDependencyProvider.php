<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsBlockGui;

use Spryker\Zed\CmsBlockGui\CmsBlockGuiDependencyProvider as CmsBlockGuiCmsBlockGuiDependencyProvider;
use Spryker\Zed\ContentGui\Communication\Plugin\CmsBlockGui\HtmlToTwigExpressionsCmsBlockGlossaryBeforeSavePlugin;
use Spryker\Zed\ContentGui\Communication\Plugin\CmsBlockGui\TwigExpressionsToHtmlCmsBlockGlossaryAfterFindPlugin;
use Spryker\Zed\Store\Communication\Plugin\Form\StoreRelationToggleFormTypePlugin;

class CmsBlockGuiDependencyProvider extends CmsBlockGuiCmsBlockGuiDependencyProvider
{
    /**
     * @return \Spryker\Zed\Kernel\Communication\Form\FormTypeInterface
     */
    protected function getStoreRelationFormTypePlugin()
    {
        return new StoreRelationToggleFormTypePlugin();
    }

    /**
     * @return \Spryker\Zed\CmsBlockGuiExtension\Dependency\Plugin\CmsBlockGlossaryAfterFindPluginInterface[]
     */
    protected function getCmsBlockGlossaryAfterFindPlugins(): array
    {
        return [
            new TwigExpressionsToHtmlCmsBlockGlossaryAfterFindPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\CmsBlockGuiExtension\Dependency\Plugin\CmsBlockGlossaryBeforeSavePluginInterface[]
     */
    protected function getCmsBlockGlossaryBeforeSavePlugins(): array
    {
        return [
            new HtmlToTwigExpressionsCmsBlockGlossaryBeforeSavePlugin(),
        ];
    }
}
