<?php

namespace Pyz\Client\SearchElasticsearch;

use Spryker\Client\SearchElasticsearch\SearchElasticsearchConfig as SprykerSearchElasticsearchConfig;

/**
 * @method \Pyz\Shared\SearchElasticsearch\SearchElasticsearchConfig getSharedConfig()
 */
class SearchElasticsearchConfig extends SprykerSearchElasticsearchConfig
{
    public function isGoogleAiSearchEnabled(): bool
    {
        return $this->getSharedConfig()->isGoogleAiSearchEnabled();
    }
}
