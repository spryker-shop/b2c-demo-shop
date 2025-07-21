<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\SalesOrderAmendmentWidget;

use SprykerShop\Yves\SalesOrderAmendmentWidget\SalesOrderAmendmentWidgetConfig as SprykerSalesOrderAmendmentWidgetConfig;

class SalesOrderAmendmentWidgetConfig extends SprykerSalesOrderAmendmentWidgetConfig
{
    /**
     * @var bool
     */
    protected const IS_ORDER_AMENDMENT_CONFIRMATION_ENABLED = true;

    /**
     * @var string|null
     */
    protected const ORDER_AMENDMENT_CART_REORDER_STRATEGY = 'replace';
}
