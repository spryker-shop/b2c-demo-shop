<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\OauthWarehouse;

use Spryker\Zed\OauthWarehouse\OauthWarehouseConfig as SprykerOauthWarehouseConfig;

class OauthWarehouseConfig extends SprykerOauthWarehouseConfig
{
    /**
     * @var string
     */
    public const SCOPE_WAREHOUSE_USER = 'warehouse-user';

    /**
     * @var string
     */
    public const SCOPE_BACK_OFFICE_USER = 'back-office-user';

    /**
     * Specification:
     * - Returns a list of user scopes that are allowed to be authorized.
     * - If empty, all user scopes are allowed.
     *
     * @api
     *
     * @return list<string>
     */
    public function getAllowedUserScopes(): array
    {
        return [
            static::SCOPE_BACK_OFFICE_USER,
            static::SCOPE_WAREHOUSE_USER,
        ];
    }
}
