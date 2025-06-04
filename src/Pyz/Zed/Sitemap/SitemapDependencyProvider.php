<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Sitemap;

use Spryker\Zed\CategoryStorage\Communication\Plugin\Sitemap\CategoryNodeSitemapGeneratorDataProviderPlugin;
use Spryker\Zed\CmsStorage\Communication\Plugin\Sitemap\CmsPageSitemapGeneratorDataProviderPlugin;
use Spryker\Zed\ProductSetStorage\Communication\Plugin\Sitemap\ProductSetSitemapGeneratorDataProviderPlugin;
use Spryker\Zed\ProductStorage\Communication\Plugin\Sitemap\ProductAbstractSitemapGeneratorDataProviderPlugin;
use Spryker\Zed\Sitemap\SitemapDependencyProvider as SprykerSitemapDependencyProvider;

class SitemapDependencyProvider extends SprykerSitemapDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\SitemapExtension\Dependency\Plugin\SitemapGeneratorDataProviderPluginInterface>
     */
    protected function getSitemapGeneratorDataProviderPlugins(): array
    {
        return [
            new ProductAbstractSitemapGeneratorDataProviderPlugin(),
            new CategoryNodeSitemapGeneratorDataProviderPlugin(),
            new CmsPageSitemapGeneratorDataProviderPlugin(),
            new ProductSetSitemapGeneratorDataProviderPlugin(),
        ];
    }
}
