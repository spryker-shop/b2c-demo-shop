<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsBlock;

use Spryker\Zed\CmsBlock\CmsBlockDependencyProvider as SprykerCmsBlockDependencyProvider;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\Plugin\CmsBlockCategoryConnectorUpdatePlugin;
use Spryker\Zed\CmsBlockProductConnector\Communication\Plugin\CmsBlockProductAbstractUpdatePlugin;

class CmsBlockDependencyProvider extends SprykerCmsBlockDependencyProvider
{
    /**
     * @return \Spryker\Zed\CmsBlockExtension\Dependency\Plugin\CmsBlockUpdatePluginInterface[]
     */
    protected function getCmsBlockUpdatePlugins(): array
    {
        return array_merge(parent::getCmsBlockUpdatePlugins(), [
            new CmsBlockCategoryConnectorUpdatePlugin(),
            new CmsBlockProductAbstractUpdatePlugin(),
        ]);
    }
}
