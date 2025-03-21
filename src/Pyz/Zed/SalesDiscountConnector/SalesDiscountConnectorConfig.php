<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\SalesDiscountConnector;

use Spryker\Zed\SalesDiscountConnector\SalesDiscountConnectorConfig as SprykerSalesDiscountConnectorConfig;

class SalesDiscountConnectorConfig extends SprykerSalesDiscountConnectorConfig
{
    /**
     * @return bool
     */
    public function isCurrentOrderExcludedFromCount(): bool
    {
        return true;
    }
}
