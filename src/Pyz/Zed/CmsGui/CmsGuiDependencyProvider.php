<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsGui;

use Spryker\Zed\CmsGui\CmsGuiDependencyProvider as SprykerCmsGuiDependencyProvider;
use Spryker\Zed\CmsGui\Communication\Plugin\CmsPageTableExpanderPlugin;
use Spryker\Zed\CmsGui\Communication\Plugin\CreateGlossaryExpanderPlugin;
use Spryker\Zed\ContentGui\Communication\Plugin\CmsGui\HtmlToTwigExpressionsCmsGlossaryBeforeSavePlugin;
use Spryker\Zed\ContentGui\Communication\Plugin\CmsGui\TwigExpressionsToHtmlCmsGlossaryAfterFindPlugin;
use Spryker\Zed\Kernel\Communication\Form\FormTypeInterface;
use Spryker\Zed\Store\Communication\Plugin\Form\StoreRelationToggleFormTypePlugin;

class CmsGuiDependencyProvider extends SprykerCmsGuiDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\CmsGui\Dependency\Plugin\CmsPageTableExpanderPluginInterface>
     */
    protected function getCmsPageTableExpanderPlugins(): array
    {
        return [
            new CmsPageTableExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CmsGui\Dependency\Plugin\CreateGlossaryExpanderPluginInterface>
     */
    protected function getCreateGlossaryExpanderPlugins(): array
    {
        return [
            new CreateGlossaryExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\Kernel\Communication\Form\FormTypeInterface
     */
    protected function getStoreRelationFormTypePlugin(): FormTypeInterface
    {
        return new StoreRelationToggleFormTypePlugin();
    }

    /**
     * @return array<\Spryker\Zed\CmsGuiExtension\Dependency\Plugin\CmsGlossaryAfterFindPluginInterface>
     */
    protected function getCmsGlossaryAfterFindPlugins(): array
    {
        return [
            new TwigExpressionsToHtmlCmsGlossaryAfterFindPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CmsGuiExtension\Dependency\Plugin\CmsGlossaryBeforeSavePluginInterface>
     */
    protected function getCmsGlossaryBeforeSavePlugins(): array
    {
        return [
            new HtmlToTwigExpressionsCmsGlossaryBeforeSavePlugin(),
        ];
    }
}
