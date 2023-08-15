<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\OauthApi;

use Spryker\Glue\OauthApi\OauthApiConfig as SprykerOauthApiConfig;

class OauthApiConfig extends SprykerOauthApiConfig
{
    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function isConventionalResponseCodeEnabled(): bool
    {
        return true;
    }
}
