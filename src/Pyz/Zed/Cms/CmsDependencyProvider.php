<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Cms;

use Spryker\Zed\Cms\CmsDependencyProvider as SprykerCmsDependencyProvider;
use Spryker\Zed\CmsContentWidget\Communication\Plugin\CmsPageDataExpander\CmsPageParameterMapExpanderPlugin;
use Spryker\Zed\CmsNavigationConnector\Communication\Plugin\CmsPageBeforeDeleteNavigationPlugin;
use Spryker\Zed\CmsNavigationConnector\Communication\Plugin\PostCmsPageActivatorNavigationPlugin;
use Spryker\Zed\CmsUserConnector\Communication\Plugin\UserCmsVersionPostSavePlugin;
use Spryker\Zed\CmsUserConnector\Communication\Plugin\UserCmsVersionTransferExpanderPlugin;
use Spryker\Zed\Kernel\Container;

class CmsDependencyProvider extends SprykerCmsDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\CmsExtension\Dependency\Plugin\CmsVersionPostSavePluginInterface>
     */
    protected function getPostSavePlugins(Container $container): array
    {
        return [
            new UserCmsVersionPostSavePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\CmsExtension\Dependency\Plugin\CmsVersionTransferExpanderPluginInterface>
     */
    protected function getTransferExpanderPlugins(Container $container): array
    {
        return [
            new UserCmsVersionTransferExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CmsExtension\Dependency\Plugin\CmsPageDataExpanderPluginInterface>
     */
    protected function getCmsPageDataExpanderPlugins(): array
    {
        return [
            new CmsPageParameterMapExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\Cms\Communication\Plugin\PostCmsPageActivatorPluginInterface>
     */
    protected function getCmsPagePostActivatorPlugins(): array
    {
        return [
            new PostCmsPageActivatorNavigationPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CmsExtension\Dependency\Plugin\CmsPageBeforeDeletePluginInterface>
     */
    protected function getCmsPageBeforeDeletePlugins(): array
    {
        return [
            new CmsPageBeforeDeleteNavigationPlugin(),
        ];
    }
}
