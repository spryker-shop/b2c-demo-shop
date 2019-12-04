<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsBlockStorage;

use Spryker\Zed\CmsBlockStorage\CmsBlockStorageDependencyProvider as SprykerCmsBlockStorageDependencyProvider;
use Spryker\Zed\CmsContentWidget\Communication\Plugin\CmsBlockStorage\CmsBlockStorageStorageParameterMapExpanderPlugin;

class CmsBlockStorageDependencyProvider extends SprykerCmsBlockStorageDependencyProvider
{
    /**
     * @return \Spryker\Zed\CmsBlockStorage\Dependency\Plugin\CmsBlockStorageDataExpanderPluginInterface[]
     */
    protected function getContentWidgetDataExpanderPlugins(): array
    {
        return [
            new CmsBlockStorageStorageParameterMapExpanderPlugin(),
        ];
    }
}
