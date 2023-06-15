<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductCategoryStorage;

use Spryker\Client\CategoryStorage\Plugin\ProductCategoryStorage\ParentCategoryIdsProductAbstractCategoryStorageCollectionExpanderPlugin;
use Spryker\Client\ProductCategoryStorage\ProductCategoryStorageDependencyProvider as SprykerProductCategoryStorageDependencyProvider;

class ProductCategoryStorageDependencyProvider extends SprykerProductCategoryStorageDependencyProvider
{
    /**
     * @return list<\Spryker\Client\ProductCategoryStorageExtension\Dependency\Plugin\ProductAbstractCategoryStorageCollectionExpanderPluginInterface>
     */
    protected function getProductAbstractCategoryStorageCollectionExpanderPlugins(): array
    {
        return [
            new ParentCategoryIdsProductAbstractCategoryStorageCollectionExpanderPlugin(),
        ];
    }
}
