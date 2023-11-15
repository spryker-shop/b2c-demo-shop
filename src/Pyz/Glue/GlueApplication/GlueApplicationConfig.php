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
     * @deprecated Will be removed without replacement.
     *
     * @var bool
     */
    public const VALIDATE_REQUEST_HEADERS = false;

    /**
     * @return array<string>
     */
    public function getCorsAllowedHeaders(): array
    {
        return array_merge(
            parent::getCorsAllowedHeaders(),
            [CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID],
        );
    }

    /**
     * @deprecated Will be removed without replacement.
     *
     * @return bool
     */
    public function isEagerRelationshipsLoadingEnabled(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isConfigurableResponseEnabled(): bool
    {
        return true;
    }

    /**
     * @return array<string>
     */
    public function getRoutePatternsAllowedForCacheWarmUp(): array
    {
        return [
            '/^\/dynamic-entity\/.+/', // @see {@link \Spryker\Glue\DynamicEntityBackendApi\DynamicEntityBackendApiConfig::getRoutePrefix()}
        ];
    }

    /**
     * @return bool
     */
    public function isTerminationEnabled(): bool
    {
        return true;
    }
}
