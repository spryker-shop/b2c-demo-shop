<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct;

use Spryker\Zed\PriceProduct\PriceProductConfig as SprykerPriceProductConfig;

class PriceProductConfig extends SprykerPriceProductConfig
{
    /**
     * Perform orphan prices removing automatically.
     */
    protected const IS_DELETE_ORPHAN_STORE_PRICES_ON_SAVE_ENABLED = true;
}
