<?php
/**
 * Created by PhpStorm.
 * User: kravchenko
 * Date: 2019-12-06
 * Time: 12:06
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
