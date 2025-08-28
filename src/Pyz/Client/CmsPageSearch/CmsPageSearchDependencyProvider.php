<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\CmsPageSearch;

use Generated\Shared\Transfer\SearchContextTransfer;
use Spryker\Client\CmsPageSearch\CmsPageSearchConfig;
use Spryker\Client\CmsPageSearch\CmsPageSearchDependencyProvider as SprykerCmsPageSearchDependencyProvider;
use Spryker\Client\CmsPageSearch\Plugin\Elasticsearch\Query\CmsPageSearchQueryPlugin;
use Spryker\Client\CmsPageSearch\Plugin\Elasticsearch\QueryExpander\PaginatedCmsPageQueryExpanderPlugin;
use Spryker\Client\CmsPageSearch\Plugin\Elasticsearch\QueryExpander\SortedCmsPageQueryExpanderPlugin;
use Spryker\Client\CmsPageSearch\Plugin\Elasticsearch\ResultFormatter\PaginatedCmsPageResultFormatterPlugin;
use Spryker\Client\CmsPageSearch\Plugin\Elasticsearch\ResultFormatter\RawCmsPageSearchResultFormatterPlugin;
use Spryker\Client\CmsPageSearch\Plugin\Elasticsearch\ResultFormatter\SortedCmsPageSearchResultFormatterPlugin;
use Spryker\Client\CmsPageSearch\Plugin\Elasticsearch\SearchResultCount\SearchElasticSearchResultCountPlugin;
use Spryker\Client\CmsPageSearch\Plugin\Search\SearchHttp\ResultFormatter\CmsPageSearchHttpResultFormatterPlugin;
use Spryker\Client\CmsPageSearch\Plugin\Search\SearchHttp\ResultFormatter\CmsPageSortSearchHttpResultFormatterPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\IsActiveInDateRangeQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\IsActiveQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\LocalizedQueryExpanderPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\StoreQueryExpanderPlugin;
use Spryker\Client\SearchHttp\Plugin\Catalog\Query\SearchHttpQueryPlugin;
use Spryker\Client\SearchHttp\Plugin\Catalog\QueryExpander\BasicSearchHttpQueryExpanderPlugin;
use Spryker\Client\SearchHttp\Plugin\Catalog\QueryExpander\FacetSearchHttpQueryExpanderPlugin;
use Spryker\Client\SearchHttp\Plugin\Catalog\ResultFormatter\FacetSearchHttpResultFormatterPlugin;
use Spryker\Client\SearchHttp\Plugin\Catalog\ResultFormatter\PaginationSearchHttpResultFormatterPlugin;
use Spryker\Client\SearchHttp\Plugin\Search\SearchHttpSearchResultCountPlugin;

class CmsPageSearchDependencyProvider extends SprykerCmsPageSearchDependencyProvider
{
    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>|array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function createCmsPageSearchQueryExpanderPlugins(): array
    {
        return [
            new StoreQueryExpanderPlugin(),
            new LocalizedQueryExpanderPlugin(),
            new SortedCmsPageQueryExpanderPlugin(),
            new PaginatedCmsPageQueryExpanderPlugin(),
            new IsActiveQueryExpanderPlugin(),
            new IsActiveInDateRangeQueryExpanderPlugin(),
        ];
    }

    /**
     * @phpstan-return array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     *
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>|array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    protected function createCmsPageSearchResultFormatterPlugins(): array
    {
        return [
            new SortedCmsPageSearchResultFormatterPlugin(),
            new PaginatedCmsPageResultFormatterPlugin(),
            new RawCmsPageSearchResultFormatterPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>|array<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function createCmsPageSearchCountQueryExpanderPlugins(): array
    {
        return [
            new StoreQueryExpanderPlugin(),
            new LocalizedQueryExpanderPlugin(),
            new IsActiveQueryExpanderPlugin(),
            new IsActiveInDateRangeQueryExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function getCmsPageHttpSearchQueryExpanderPlugins(): array
    {
        return [
            new BasicSearchHttpQueryExpanderPlugin(),
            new FacetSearchHttpQueryExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    protected function getCmsPageHttpSearchResultFormatterPlugins(): array
    {
        return [
            new PaginationSearchHttpResultFormatterPlugin(),
            new CmsPageSortSearchHttpResultFormatterPlugin(),
            new CmsPageSearchHttpResultFormatterPlugin(),
            new FacetSearchHttpResultFormatterPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface>
     */
    protected function getCmsPageSearchQueryPlugins(): array
    {
        /** @var array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface> $plugins */
        $plugins = [
            new SearchHttpQueryPlugin(
                (new SearchContextTransfer())
                    ->setSourceIdentifier(CmsPageSearchConfig::SOURCE_IDENTIFIER_CMS_PAGE),
            ),
            new CmsPageSearchQueryPlugin(),
        ];

        return $plugins;
    }

    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\SearchResultCountPluginInterface>
     */
    protected function getCmsPageSearchResultCountPlugins(): array
    {
        return [
            CmsPageSearchConfig::SEARCH_STRATEGY_SEARCH_HTTP => new SearchHttpSearchResultCountPlugin(),
            CmsPageSearchConfig::SEARCH_STRATEGY_ELASTICSEARCH => new SearchElasticSearchResultCountPlugin(),
        ];
    }
}
