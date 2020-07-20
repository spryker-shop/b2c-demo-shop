<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductPageSearch;

use Spryker\Zed\ProductPageSearch\ProductPageSearchConfig as SprykerProductPageSearchConfig;

class ProductPageSearchConfig extends SprykerProductPageSearchConfig
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return bool
     */
    public function isProductAbstractAddToCartEnabled(): bool
    {
        return true;
    }
}
