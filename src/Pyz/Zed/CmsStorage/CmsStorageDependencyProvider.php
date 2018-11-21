<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsStorage;

use Spryker\Zed\CmsContentWidget\Communication\Plugin\CmsPageDataExpander\CmsPageParameterMapExpanderPlugin;
use Spryker\Zed\CmsStorage\CmsStorageDependencyProvider as SprykerCmsStorageDependencyProvider;

class CmsStorageDependencyProvider extends SprykerCmsStorageDependencyProvider
{
    /**
     * @return \Spryker\Zed\Cms\Dependency\Plugin\CmsPageDataExpanderPluginInterface[]
     */
    protected function getContentWidgetDataExpander()
    {
        return [
            new CmsPageParameterMapExpanderPlugin(),
        ];
    }
}
