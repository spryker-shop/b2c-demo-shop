<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Collector;

use Spryker\Shared\CmsBlockCategoryConnector\CmsBlockCategoryConnectorConfig;
use Spryker\Shared\CmsBlockProductConnector\CmsBlockProductConnectorConstants;
use Spryker\Zed\CmsBlockCategoryConnector\Communication\Plugin\CmsBlockCategoryConnectorCollectorPlugin;
use Spryker\Zed\CmsBlockProductConnector\Communication\Plugin\CmsBlockProductConnectorCollectorPlugin;
use Spryker\Zed\Collector\CollectorDependencyProvider as SprykerCollectorDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CollectorDependencyProvider extends SprykerCollectorDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): array
    {
        $container[self::STORAGE_PLUGINS] = function (Container $container) {
            return [
                CmsBlockCategoryConnectorConfig::RESOURCE_TYPE_CMS_BLOCK_CATEGORY_CONNECTOR => new CmsBlockCategoryConnectorCollectorPlugin(),
                CmsBlockProductConnectorConstants::RESOURCE_TYPE_CMS_BLOCK_PRODUCT_CONNECTOR => new CmsBlockProductConnectorCollectorPlugin(),
            ];
        };
    }
}
