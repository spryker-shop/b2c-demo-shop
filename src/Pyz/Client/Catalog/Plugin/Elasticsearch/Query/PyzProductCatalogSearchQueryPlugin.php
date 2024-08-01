<?php

namespace Pyz\Client\Catalog\Plugin\Elasticsearch\Query;

use Spryker\Client\Catalog\Plugin\Elasticsearch\Query\ProductCatalogSearchQueryPlugin;
use Elastica\Query;
use Elastica\Query\MatchAll;

class PyzProductCatalogSearchQueryPlugin extends ProductCatalogSearchQueryPlugin
{
    /**
     * @param \Elastica\Query $baseQuery
     *
     * @return \Elastica\Query
     */
    protected function addFulltextSearchToQuery(Query $baseQuery)
    {
        if ($this->searchString && $this->getFactory()->getConfig()->isGoogleAiSearchEnabled() !== true) {
            $matchQuery = $this->createFulltextSearchQuery($this->searchString);
        } else {
            $matchQuery = new MatchAll();
        }

        $baseQuery->setQuery($this->createBoolQuery($matchQuery));

        /** @var \Elastica\Query\BoolQuery $boolQuery */
        $boolQuery = $baseQuery->getQuery();

        $this->setTypeFilter($boolQuery);
        $this->setSuggestion($baseQuery);

        return $baseQuery;
    }
}
