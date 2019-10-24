<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\ProductPricesRestApi;

use Spryker\Glue\ProductPricesRestApi\ProductPricesRestApiConfig as SprykerProductPricesRestApiConfig;

class ProductPricesRestApiConfig extends SprykerProductPricesRestApiConfig
{
    protected const PERMISSION_CHECK_ENABLED = true;
}
