<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CartsRestApi;

use Spryker\Glue\CartsRestApi\CartsRestApiConfig as SprykerCartsRestApiConfig;

class CartsRestApiConfig extends SprykerCartsRestApiConfig
{
    public const ALLOWED_CART_ITEM_EAGER_RELATIONSHIP = false;
}
