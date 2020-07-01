<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Shared\SearchElasticsearch;

use Spryker\Shared\SearchElasticsearch\SearchElasticsearchConfig as SprykerSearchElasticsearchConfig;

class SearchElasticsearchConfig extends SprykerSearchElasticsearchConfig
{
    protected const SUPPORTED_SOURCE_IDENTIFIERS = [
        'page',
        'product-review',
        'return_reason',
    ];
}
