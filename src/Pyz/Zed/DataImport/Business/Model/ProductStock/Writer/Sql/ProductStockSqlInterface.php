<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\Sql;

interface ProductStockSqlInterface
{
    /**
     * @return string
     */
    public function createStockSQL(): string;

    /**
     * @return string
     */
    public function createStockProductSQL(): string;

    /**
     * @return string
     */
    public function createAbstractAvailabilitySQL(): string;

    /**
     * @return string
     */
    public function createAvailabilitySQL(): string;
}
