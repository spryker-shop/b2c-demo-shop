<?php

namespace Pyz\Client\SearchElasticsearch;

use Spryker\Client\SearchElasticsearch\SearchElasticsearchFactory as SprykerSearchElasticsearchFactory;

class SearchElasticsearchFactory extends SprykerSearchElasticsearchFactory
{
    public function getVertexAiService()
    {
        return $this->getProvidedDependency(SearchElasticsearchDependencyProvider::SERVICE_VERTEX_AI);
    }
}
