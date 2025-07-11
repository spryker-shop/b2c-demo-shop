<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Glue\MultiFactorAuth;

use Spryker\Glue\MultiFactorAuth\MultiFactorAuthConfig as SprykerMultiFactorAuthConfig;

class MultiFactorAuthConfig extends SprykerMultiFactorAuthConfig
{
    /**
     * @return array<string>
     */
    public function getRestApiMultiFactorAuthProtectedResources(): array
    {
        return [
            'customer-password',
            'customers',
            'addresses',
            'carts',
            'checkout',
            'order-payments',
        ];
    }

    /**
     * @return array<string>
     */
    public function getMultiFactorAuthProtectedBackendResources(): array
    {
        return [
            'warehouse-user-assignments',
        ];
    }

    /**
     * @return array<string>
     */
    public function getMultiFactorAuthProtectedStorefrontResources(): array
    {
        return [];
    }
}
