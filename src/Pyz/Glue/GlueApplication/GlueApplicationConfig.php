<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\GlueApplication;

use Spryker\Glue\CartsRestApi\CartsRestApiConfig;
use Spryker\Glue\GlueApplication\GlueApplicationConfig as SprykerGlueApplicationConfig;

class GlueApplicationConfig extends SprykerGlueApplicationConfig
{
    /**
     * @return array
     */
    public function getCorsAllowedHeaders(): array
    {
        return array_merge(
            parent::getCorsAllowedHeaders(),
            [CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID]
        );
    }

    /**
     * @return bool
     */
    public function isEagerRelationshipsLoadingEnabled(): bool
    {
        return false;
    }
}
