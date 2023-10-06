<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsBlockGui;

use Spryker\Zed\CmsBlockCategoryConnector\Communication\Plugin\CmsBlockCategoryFormPlugin;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\Plugin\CmsBlockCategoryListViewPlugin;
use Spryker\Zed\CmsBlockGui\CmsBlockGuiDependencyProvider as CmsBlockGuiCmsBlockGuiDependencyProvider;
use Spryker\Zed\ContentGui\Communication\Plugin\CmsBlockGui\HtmlToTwigExpressionsCmsBlockGlossaryBeforeSavePlugin;
use Spryker\Zed\ContentGui\Communication\Plugin\CmsBlockGui\TwigExpressionsToHtmlCmsBlockGlossaryAfterFindPlugin;
use Spryker\Zed\Kernel\Communication\Form\FormTypeInterface;
use Spryker\Zed\Store\Communication\Plugin\Form\StoreRelationToggleFormTypePlugin;

class CmsBlockGuiDependencyProvider extends CmsBlockGuiCmsBlockGuiDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\CmsBlockGui\Communication\Plugin\CmsBlockFormPluginInterface>
     */
    protected function getCmsBlockFormPlugins(): array
    {
        $plugins = parent::getCmsBlockFormPlugins();
        $plugins = array_merge($plugins, [
            new CmsBlockCategoryFormPlugin(),
        ]);

        return $plugins;
    }

    /**
     * @return array<\Spryker\Zed\CmsBlockGui\Communication\Plugin\CmsBlockViewPluginInterface>
     */
    protected function getCmsBlockViewPlugins(): array
    {
        return array_merge(parent::getCmsBlockViewPlugins(), [
            new CmsBlockCategoryListViewPlugin(),
        ]);
    }

    /**
     * @return \Spryker\Zed\Kernel\Communication\Form\FormTypeInterface
     */
    protected function getStoreRelationFormTypePlugin(): FormTypeInterface
    {
        return new StoreRelationToggleFormTypePlugin();
    }

    /**
     * @return array<\Spryker\Zed\CmsBlockGuiExtension\Dependency\Plugin\CmsBlockGlossaryAfterFindPluginInterface>
     */
    protected function getCmsBlockGlossaryAfterFindPlugins(): array
    {
        return [
            new TwigExpressionsToHtmlCmsBlockGlossaryAfterFindPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CmsBlockGuiExtension\Dependency\Plugin\CmsBlockGlossaryBeforeSavePluginInterface>
     */
    protected function getCmsBlockGlossaryBeforeSavePlugins(): array
    {
        return [
            new HtmlToTwigExpressionsCmsBlockGlossaryBeforeSavePlugin(),
        ];
    }
}
