<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContentGui;

use Spryker\Zed\ContentBannerGui\Communication\Plugin\ContentGui\ContentBannerContentGuiEditorPlugin;
use Spryker\Zed\ContentBannerGui\Communication\Plugin\ContentGui\ContentBannerFormPlugin;
use Spryker\Zed\ContentFileGui\Communication\Plugin\ContentGui\ContentFileListContentGuiEditorPlugin;
use Spryker\Zed\ContentFileGui\Communication\Plugin\ContentGui\ContentFileListFormPlugin;
use Spryker\Zed\ContentGui\ContentGuiDependencyProvider as SprykerContentGuiDependencyProvider;
use Spryker\Zed\ContentNavigationGui\Communication\Plugin\ContentGui\ContentNavigationContentGuiEditorPlugin;
use Spryker\Zed\ContentNavigationGui\Communication\Plugin\ContentGui\NavigationFormContentPlugin;
use Spryker\Zed\ContentProductGui\Communication\Plugin\ContentGui\ContentProductContentGuiEditorPlugin;
use Spryker\Zed\ContentProductGui\Communication\Plugin\ContentGui\ProductAbstractListFormPlugin;
use Spryker\Zed\ContentProductSetGui\Communication\Plugin\ContentGui\ContentProductSetGuiEditorPlugin;
use Spryker\Zed\ContentProductSetGui\Communication\Plugin\ContentGui\ProductSetFormPlugin;

class ContentGuiDependencyProvider extends SprykerContentGuiDependencyProvider
{
    /**
     * @return \Spryker\Zed\ContentGuiExtension\Dependency\Plugin\ContentPluginInterface[]
     */
    protected function getContentPlugins(): array
    {
        return [
            new ContentBannerFormPlugin(),
            new ProductAbstractListFormPlugin(),
            new ProductSetFormPlugin(),
            new ContentFileListFormPlugin(),
            new NavigationFormContentPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ContentGuiExtension\Dependency\Plugin\ContentGuiEditorPluginInterface[]
     */
    protected function getContentEditorPlugins(): array
    {
        return [
            new ContentBannerContentGuiEditorPlugin(),
            new ContentProductContentGuiEditorPlugin(),
            new ContentProductSetGuiEditorPlugin(),
            new ContentFileListContentGuiEditorPlugin(),
            new ContentNavigationContentGuiEditorPlugin(),
        ];
    }
}
