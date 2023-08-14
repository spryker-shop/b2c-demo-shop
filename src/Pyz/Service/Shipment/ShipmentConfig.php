<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\Shipment;

use Generated\Shared\Transfer\ShipmentTransfer;
use Spryker\Service\Shipment\ShipmentConfig as SprykerShipmentConfig;

class ShipmentConfig extends SprykerShipmentConfig
{
    /**
     * Returns array of field names for generation of hash for shipment.
     *
     * @api
     *
     * @return array<string>
     */
    public function getShipmentHashFields(): array
    {
        return [
            ShipmentTransfer::SHIPMENT_TYPE_UUID,
        ];
    }
}
