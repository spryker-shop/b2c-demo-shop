<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CatalogPage;

use SprykerShop\Yves\CatalogPage\CatalogPageConfig as SprykerCatalogPageConfig;

class CatalogPageConfig extends SprykerCatalogPageConfig
{
    /**
     * @var bool
     */
    protected const IS_MINI_CART_ASYNC_MODE_ENABLED = true;

    /**
     * @return bool
     */
    public function isVisibleEmptyRangeFilters(): bool
    {
        return false;
    }
}
