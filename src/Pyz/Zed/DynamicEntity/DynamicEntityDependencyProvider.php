<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DynamicEntity;

use Spryker\Zed\Availability\Communication\Plugin\DynamicEntity\AvailabilityDynamicEntityPostCreatePlugin;
use Spryker\Zed\Availability\Communication\Plugin\DynamicEntity\AvailabilityDynamicEntityPostUpdatePlugin;
use Spryker\Zed\CategoryDynamicEntityConnector\Communication\Plugin\DynamicEntity\CategoryClosureTableDynamicEntityPostCreatePlugin;
use Spryker\Zed\CategoryDynamicEntityConnector\Communication\Plugin\DynamicEntity\CategoryClosureTableDynamicEntityPostUpdatePlugin;
use Spryker\Zed\CategoryDynamicEntityConnector\Communication\Plugin\DynamicEntity\CategoryTreeDynamicEntityPostCreatePlugin;
use Spryker\Zed\CategoryDynamicEntityConnector\Communication\Plugin\DynamicEntity\CategoryTreeDynamicEntityPostUpdatePlugin;
use Spryker\Zed\CategoryDynamicEntityConnector\Communication\Plugin\DynamicEntity\CategoryUrlDynamicEntityPostCreatePlugin;
use Spryker\Zed\CategoryDynamicEntityConnector\Communication\Plugin\DynamicEntity\CategoryUrlDynamicEntityPostUpdatePlugin;
use Spryker\Zed\DynamicEntity\DynamicEntityDependencyProvider as SprykerDynamicEntityDependencyProvider;
use Spryker\Zed\ProductDynamicEntityConnector\Communication\Plugin\DynamicEntity\ProductAbstractLocalizedAttributesDynamicEntityPostCreatePlugin;
use Spryker\Zed\ProductDynamicEntityConnector\Communication\Plugin\DynamicEntity\ProductAbstractLocalizedAttributesDynamicEntityPostUpdatePlugin;

class DynamicEntityDependencyProvider extends SprykerDynamicEntityDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\DynamicEntityExtension\Dependency\Plugin\DynamicEntityPostUpdatePluginInterface>
     */
    protected function getDynamicEntityPostUpdatePlugins(): array
    {
        return [
            new AvailabilityDynamicEntityPostUpdatePlugin(),
            new CategoryClosureTableDynamicEntityPostUpdatePlugin(),
            new CategoryUrlDynamicEntityPostUpdatePlugin(),
            new CategoryTreeDynamicEntityPostUpdatePlugin(),
            new ProductAbstractLocalizedAttributesDynamicEntityPostUpdatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\DynamicEntityExtension\Dependency\Plugin\DynamicEntityPostCreatePluginInterface>
     */
    protected function getDynamicEntityPostCreatePlugins(): array
    {
        return [
            new AvailabilityDynamicEntityPostCreatePlugin(),
            new CategoryClosureTableDynamicEntityPostCreatePlugin(),
            new CategoryUrlDynamicEntityPostCreatePlugin(),
            new CategoryTreeDynamicEntityPostCreatePlugin(),
            new ProductAbstractLocalizedAttributesDynamicEntityPostCreatePlugin(),
        ];
    }
}
