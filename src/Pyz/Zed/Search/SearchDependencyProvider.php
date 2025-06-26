<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Search;

use Spryker\Zed\Search\SearchDependencyProvider as SprykerSearchDependencyProvider;
use Spryker\Zed\SearchElasticsearch\Communication\Plugin\Search\ElasticsearchIndexInstallerPlugin;
use Spryker\Zed\SearchElasticsearch\Communication\Plugin\Search\ElasticsearchIndexMapInstallerPlugin;

class SearchDependencyProvider extends SprykerSearchDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\SearchExtension\Dependency\Plugin\InstallPluginInterface>
     */
    protected function getSearchSourceInstallerPlugins(): array
    {
        return [
            new ElasticsearchIndexInstallerPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\SearchExtension\Dependency\Plugin\InstallPluginInterface>
     */
    protected function getSearchMapInstallerPlugins(): array
    {
        return [
            new ElasticsearchIndexMapInstallerPlugin(),
        ];
    }
}
