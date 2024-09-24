<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuthorizationPickingAppBackendApi;

use SprykerEco\Zed\AuthorizationPickingAppBackendApi\AuthorizationPickingAppBackendApiConfig as SprykerEcoAuthorizationPickingAppBackendApiConfig;

class AuthorizationPickingAppBackendApiConfig extends SprykerEcoAuthorizationPickingAppBackendApiConfig
{
    /**
     * @return list<string>
     */
    public function getUserScopes(): array
    {
        return [
            'warehouse-user',
        ];
    }
}
