<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Glue\CartsRestApi;

use Spryker\Glue\CartsRestApi\CartsRestApiConfig as SprykerCartsRestApiConfig;
use Spryker\Glue\ConfigurableBundleCartsRestApi\ConfigurableBundleCartsRestApiConfig;

class CartsRestApiConfig extends SprykerCartsRestApiConfig
{
    /**
     * @var bool
     */
    protected const ALLOWED_CART_ITEM_EAGER_RELATIONSHIP = false;

    /**
     * @var bool
     */
    protected const ALLOWED_GUEST_CART_ITEM_EAGER_RELATIONSHIP = false;

    /**
     * @var array<string>
     */
    protected const GUEST_CART_RESOURCES = [
        self::RESOURCE_GUEST_CARTS,
        self::RESOURCE_GUEST_CARTS_ITEMS,
        ConfigurableBundleCartsRestApiConfig::RESOURCE_GUEST_CONFIGURED_BUNDLES,
    ];
}
