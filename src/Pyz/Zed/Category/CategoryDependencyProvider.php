<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Category;

use Spryker\Zed\Category\CategoryDependencyProvider as SprykerDependencyProvider;
use Spryker\Zed\Category\Communication\Plugin\Category\MainChildrenPropagationCategoryStoreAssignerPlugin;
use Spryker\Zed\Category\Communication\Plugin\CategoryUrlPathPrefixUpdaterPlugin;
use Spryker\Zed\CategoryExtension\Dependency\Plugin\CategoryStoreAssignerPluginInterface;
use Spryker\Zed\CategoryImage\Communication\Plugin\CategoryImageSetCreatorPlugin;
use Spryker\Zed\CategoryImage\Communication\Plugin\CategoryImageSetExpanderPlugin;
use Spryker\Zed\CategoryImage\Communication\Plugin\CategoryImageSetUpdaterPlugin;
use Spryker\Zed\CategoryImage\Communication\Plugin\RemoveCategoryImageSetRelationPlugin;
use Spryker\Zed\CategoryNavigationConnector\Communication\Plugin\UpdateNavigationRelationPlugin;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\Plugin\Category\CmsBlockCategoryCategoryRelationPlugin;
use Spryker\Zed\ProductCategory\Communication\Plugin\Category\ProductUpdateEventTriggerCategoryRelationUpdatePlugin;
use Spryker\Zed\ProductCategory\Communication\Plugin\RemoveProductCategoryRelationPlugin;

class CategoryDependencyProvider extends SprykerDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\CategoryExtension\Dependency\Plugin\CategoryRelationDeletePluginInterface>
     */
    protected function getRelationDeletePluginStack(): array
    {
        /**
         * @var array<\Spryker\Zed\Category\Dependency\Plugin\CategoryRelationDeletePluginInterface> $deletePlugins
         */
        $deletePlugins = [
            new RemoveProductCategoryRelationPlugin(),
            new RemoveCategoryImageSetRelationPlugin(),
        ];

        return $deletePlugins;
    }

    /**
     * @return array<\Spryker\Zed\CategoryExtension\Dependency\Plugin\CategoryRelationUpdatePluginInterface>
     */
    protected function getRelationUpdatePluginStack(): array
    {
        return [
            new UpdateNavigationRelationPlugin(),
            new CmsBlockCategoryCategoryRelationPlugin(),
            new ProductUpdateEventTriggerCategoryRelationUpdatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CategoryExtension\Dependency\Plugin\CategoryTransferExpanderPluginInterface>
     */
    protected function getCategoryPostReadPlugins(): array
    {
        return [
            new CategoryImageSetExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CategoryExtension\Dependency\Plugin\CategoryUrlPathPluginInterface>
     */
    protected function getCategoryUrlPathPlugins(): array
    {
        return [
            new CategoryUrlPathPrefixUpdaterPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CategoryExtension\Dependency\Plugin\CategoryUpdateAfterPluginInterface>
     */
    protected function getCategoryPostUpdatePlugins(): array
    {
        return [
            new CategoryImageSetUpdaterPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CategoryExtension\Dependency\Plugin\CategoryCreateAfterPluginInterface>
     */
    protected function getCategoryPostCreatePlugins(): array
    {
        return [
            new CategoryImageSetCreatorPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\CategoryExtension\Dependency\Plugin\CategoryStoreAssignerPluginInterface
     */
    protected function getCategoryStoreAssignerPlugin(): CategoryStoreAssignerPluginInterface
    {
        return new MainChildrenPropagationCategoryStoreAssignerPlugin();
    }
}
