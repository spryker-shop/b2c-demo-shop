<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ConfigurableBundlePageSearch;

use Spryker\Client\ConfigurableBundlePageSearch\ConfigurableBundlePageSearchDependencyProvider as SprykerConfigurableBundlePageSearchDependencyProvider;
use Spryker\Client\ConfigurableBundlePageSearch\Plugin\Elasticsearch\ResultFormatter\ConfigurableBundleTemplatePageSearchResultFormatterPlugin;
use Spryker\Client\Search\Plugin\Elasticsearch\QueryExpander\LocalizedQueryExpanderPlugin;

class ConfigurableBundlePageSearchDependencyProvider extends SprykerConfigurableBundlePageSearchDependencyProvider
{
    /**
     * @return \Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface[]
     */
    protected function getConfigurableBundleTemplatePageSearchResultFormatterPlugins(): array
    {
        return [
            new ConfigurableBundleTemplatePageSearchResultFormatterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface[]
     */
    protected function getConfigurableBundleTemplatePageSearchQueryExpanderPlugins(): array
    {
        return [
            new LocalizedQueryExpanderPlugin(),
        ];
    }
}
