<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomersRestApi;

use Generated\Shared\Transfer\RestAddressTransfer;
use Spryker\Glue\CustomersRestApi\CustomersRestApiConfig as SprykerCustomersRestApiConfig;

class CustomersRestApiConfig extends SprykerCustomersRestApiConfig
{
    /**
     * Specification:
     * - Defines a list of properties in a `RestAddressTransfer` that should trigger validation skip.
     *
     * @api
     *
     * @return list<string>
     */
    public function getBillingAddressFieldsToSkipValidation(): array
    {
        return array_merge(parent::getBillingAddressFieldsToSkipValidation(), [
            RestAddressTransfer::ID_COMPANY_BUSINESS_UNIT_ADDRESS,
        ]);
    }
}
