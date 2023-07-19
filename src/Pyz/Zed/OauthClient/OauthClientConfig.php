<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\OauthClient;

use Spryker\Zed\OauthClient\OauthClientConfig as SprykerOauthClientConfig;

class OauthClientConfig extends SprykerOauthClientConfig
{
    /**
     * @api
     *
     * @return bool
     */
    public function isAccessTokenRequestExpandedByMessageAttributes(): bool
    {
        return true;
    }
}
