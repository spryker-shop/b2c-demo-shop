<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CategoryGui;

use Spryker\Zed\CategoryGui\CategoryGuiDependencyProvider as SpykerCategoryGuiDependencyProvider;
use Spryker\Zed\CategoryImageGui\Communication\Plugin\CategoryGui\ImageSetCategoryFormTabExpanderPlugin;
use Spryker\Zed\CategoryImageGui\Communication\Plugin\CategoryGui\ImageSetSubformCategoryFormPlugin;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\Plugin\CategoryGui\CmsBlockCategoryRelationReadPlugin;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\Plugin\CategoryGui\CmsBlockSubformCategoryFormPlugin;
use Spryker\Zed\Kernel\Communication\Form\FormTypeInterface;
use Spryker\Zed\ProductCategory\Communication\Plugin\CategoryGui\ProductCategoryRelationReadPlugin;
use Spryker\Zed\StoreGui\Communication\Plugin\Form\StoreRelationDropdownFormTypePlugin;

/**
 * @method \Spryker\Zed\CategoryGui\CategoryGuiConfig getConfig()
 */
class CategoryGuiDependencyProvider extends SpykerCategoryGuiDependencyProvider
{
    /**
     * @return \Spryker\Zed\Kernel\Communication\Form\FormTypeInterface
     */
    protected function getStoreRelationFormTypePlugin(): FormTypeInterface
    {
        return new StoreRelationDropdownFormTypePlugin();
    }

    /**
     * @return array<\Spryker\Zed\CategoryGuiExtension\Dependency\Plugin\CategoryFormTabExpanderPluginInterface>
     */
    protected function getCategoryFormTabExpanderPlugins(): array
    {
        return [
            new ImageSetCategoryFormTabExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CategoryGuiExtension\Dependency\Plugin\CategoryFormPluginInterface>
     */
    protected function getCategoryFormPlugins(): array
    {
        return [
            new ImageSetSubformCategoryFormPlugin(),
            new CmsBlockSubformCategoryFormPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CategoryGuiExtension\Dependency\Plugin\CategoryRelationReadPluginInterface>
     */
    protected function getCategoryRelationReadPlugins(): array
    {
        return [
            new ProductCategoryRelationReadPlugin(),
            new CmsBlockCategoryRelationReadPlugin(),
        ];
    }
}
