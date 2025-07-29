<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\SalesInvoice;

use Spryker\Zed\SalesInvoice\SalesInvoiceConfig as SprykerSalesInvoiceConfig;

class SalesInvoiceConfig extends SprykerSalesInvoiceConfig
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getOrderInvoiceTemplatePath(): string
    {
        return 'SalesInvoice/invoice/invoice.twig';
    }
}
