<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\UrlStorage;

use Spryker\Client\CategoryStorage\Plugin\UrlStorageCategoryNodeMapperPlugin;
use Spryker\Client\CmsStorage\Plugin\UrlStorageCmsPageMapperPlugin;
use Spryker\Client\ProductSetStorage\Plugin\UrlStorageProductSetMapperPlugin;
use Spryker\Client\ProductStorage\Plugin\UrlStorageProductAbstractMapperPlugin;
use Spryker\Client\UrlStorage\Plugin\UrlStorageRedirectMapperPlugin;
use Spryker\Client\UrlStorage\UrlStorageDependencyProvider as SprykerUrlDependencyProvider;

class UrlStorageDependencyProvider extends SprykerUrlDependencyProvider
{
    /**
     * @return array<\Spryker\Client\UrlStorage\Dependency\Plugin\UrlStorageResourceMapperPluginInterface>
     */
    protected function getUrlStorageResourceMapperPlugins(): array
    {
        return [
            new UrlStorageCmsPageMapperPlugin(),
            new UrlStorageCategoryNodeMapperPlugin(),
            new UrlStorageProductAbstractMapperPlugin(),
            new UrlStorageProductSetMapperPlugin(),
            new UrlStorageRedirectMapperPlugin(),
        ];
    }
}
