<?php

namespace Pyz\Client\SearchElasticsearch\Plugin\QueryExpander;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Exists;
use Elastica\Query\Range;
use Generated\Shared\Search\PageIndexMap;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Elastica\Query\MultiMatch;
use Elastica\Query\Term;
use Elastica\Query\Nested;
use Spryker\Client\SearchElasticsearch\Plugin\QueryExpander\FacetQueryExpanderPlugin;
use Elastica\Query\AbstractQuery;

/**
 * @method \Pyz\Client\SearchElasticsearch\SearchElasticsearchFactory getFactory()
 */
class AiElasticSearchQueryExpanderPlugin extends FacetQueryExpanderPlugin implements QueryExpanderPluginInterface
{
    const TYPE_RANGE = 'range';

    /**
     * {@inheritDoc}
     * - Expands range query with active_from and active_to fields.
     *
     * @api
     *
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<string, mixed> $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        $query = !empty($requestParameters['q']) ? $requestParameters['q'] : "";

        if ($this->getFactory()->getConfig()->isGoogleAiSearchEnabled() !== true || empty($query)) {
            return $searchQuery;
        }

        $vertexService = $this->getFactory()->getVertexAiService();
        $data = $vertexService->generateNlp($query);

        // must query
        $this->updateDynamicFullTextQuery($searchQuery->getSearchQuery(), $data);

        // Attribute query
        $this->addAttributeQuery($searchQuery->getSearchQuery(), $data);

        return $searchQuery;
    }

    protected function getFullTextBoostedBoostingValue()
    {
        return 3;
    }

    protected function createMultiMatchQuery(array $data, $query)
    {
        $fields = [
            PageIndexMap::FULL_TEXT,
            PageIndexMap::FULL_TEXT_BOOSTED . '^' . $this->getFullTextBoostedBoostingValue(),
        ];

        if (isset($data['product_type'])) {
            $query->setQuery(
                $this->createBoolQuery((new MultiMatch())
                ->setFields($fields)
                ->setQuery($data['product_type'])
                ->setType(MultiMatch::TYPE_CROSS_FIELDS))
            );
        }
    }

    /**
     * @param \Elastica\Query\AbstractQuery $matchQuery
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function createBoolQuery(AbstractQuery $matchQuery)
    {
        $boolQuery = new BoolQuery();
        $boolQuery->addMust($matchQuery);

        return $boolQuery;
    }

    /**
     * @param \Elastica\Query $query
     *
     * @return void
     */
    protected function updateDynamicFullTextQuery(Query $query, $data): void
    {
        $boolQuery = $this->getBoolQuery($query);

        $this->createMultiMatchQuery($data, $query);
    }

    protected function addAttributeQuery(Query $query, $data): void
    {
        if ($data && $data['attributes']) {
            foreach ($data['attributes'] as $key => $value) {
                $this->addContainQuery($query, $value);
            }
        }
    }

    protected function addContainQuery($query, $attribute)
    {
        $facetConfig = $this->getFactory()->getSearchConfig()->getFacetConfig();

        if (isset($attribute['min']) || isset($attribute['max'])) {
            $attribute = array_filter($attribute, function($value){return !empty($value) && $value!='null';});
            $requestParameters[$attribute['key']] = $attribute;
        } else {
            $requestParameters[$attribute['key']] = $attribute['value'];
        }

        $facetFilters = $this->getFacetFilters($facetConfig, $requestParameters);

        // $this->addFacetAggregationToQuery($query, $facetConfig, $facetFilters, $requestParameters);
        $this->addFacetFiltersToBoolQuery($query, $facetFilters);
    }

    /**
     * @param \Elastica\Query $query
     *
     * @throws \InvalidArgumentException
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function getBoolQuery(Query $query): BoolQuery
    {
        $boolQuery = $query->getQuery();
        if (!$boolQuery instanceof BoolQuery) {
            /** @phpstan-var object $boolQuery */
            throw new InvalidArgumentException(sprintf(
                'Is Active In Date Range query expander available only with %s, got: %s',
                BoolQuery::class,
                get_class($boolQuery),
            ));
        }

        return $boolQuery;
    }
}
