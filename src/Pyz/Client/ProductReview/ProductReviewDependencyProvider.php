<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductReview;

use Spryker\Client\ProductReview\Plugin\Elasticsearch\QueryExpander\PaginatedProductReviewsQueryExpanderPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\QueryExpander\ProductRatingAggregationBulkQueryExpanderPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\QueryExpander\SortByCreatedAtQueryExpanderPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\ResultFormatter\PaginatedProductReviewsResultFormatterPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\ResultFormatter\ProductRatingAggregationBulkResultFormatterPlugin;
use Spryker\Client\ProductReview\Plugin\Elasticsearch\ResultFormatter\ProductReviewsResultFormatterPlugin;
use Spryker\Client\ProductReview\ProductReviewDependencyProvider as SprykerProductReviewDependencyProvider;
use Spryker\Client\ProductReviewSearch\Plugin\Search\FilterByIdProductReviewQueryExpanderPlugin;

class ProductReviewDependencyProvider extends SprykerProductReviewDependencyProvider
{
    /**
     * @return array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function getProductReviewsBulkQueryExpanderPlugins(): array
    {
        return [
            new PaginatedProductReviewsQueryExpanderPlugin(),
            new ProductRatingAggregationBulkQueryExpanderPlugin(),
            new SortByCreatedAtQueryExpanderPlugin(),
        ];
    }

    /**
     * @phpstan-return array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     *
     * @return array<\Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface>|array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface>
     */
    public function getProductReviewsBulkSearchResultFormatterPlugins(): array
    {
        return [
            new ProductReviewsResultFormatterPlugin(),
            new PaginatedProductReviewsResultFormatterPlugin(),
            new ProductRatingAggregationBulkResultFormatterPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface|\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface>
     */
    protected function getProductReviewsQueryExpanderPlugins(): array
    {
        $productReviewQueryExpanderPlugins = parent::getProductReviewsQueryExpanderPlugins();
        $productReviewQueryExpanderPlugins[] = new FilterByIdProductReviewQueryExpanderPlugin();

        return $productReviewQueryExpanderPlugins;
    }
}
