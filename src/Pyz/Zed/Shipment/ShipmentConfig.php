<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Shipment;

use Spryker\Zed\Shipment\ShipmentConfig as SprykerShipmentConfig;

class ShipmentConfig extends SprykerShipmentConfig
{
    /**
     * @return bool
     */
    public function shouldExecuteQuotePostRecalculationPlugins(): bool
    {
        return false;
    }
}
