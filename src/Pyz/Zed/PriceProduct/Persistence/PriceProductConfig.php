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
     * Decides if orphan store prices need to be cleared after every product price update.
     */
    protected const IS_DELETE_ORPHAN_STORE_PRICES_ON_SAVE_ENABLED = false;
}
