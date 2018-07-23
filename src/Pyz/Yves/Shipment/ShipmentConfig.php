<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\Shipment;

use Spryker\Yves\Shipment\ShipmentConfig as SprykerShipmentConfig;

class ShipmentConfig extends SprykerShipmentConfig
{
    /**
     * Specification:
     * - Defines a name of a shipment method, which will be used for orders without selected shipment
     * - The defined shipment method name MUST exist in your DB
     *
     * @example 'No shipment'
     *
     * @return string
     */
    public function getNoShipmentMethodName()
    {
        return 'No shipment';
    }
}
