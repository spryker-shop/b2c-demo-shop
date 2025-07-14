<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\SalesOrderAmendment;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\SalesOrderAmendment\SalesOrderAmendmentConfig as SprykerSalesOrderAmendmentConfig;

class SalesOrderAmendmentConfig extends SprykerSalesOrderAmendmentConfig
{
    /**
     * @return array<string>
     */
    public function getQuoteFieldsAllowedForSaving(): array
    {
        return array_merge(parent::getQuoteFieldsAllowedForSaving(), [
            QuoteTransfer::BUNDLE_ITEMS,
            QuoteTransfer::CART_NOTE,
            QuoteTransfer::EXPENSES,
            QuoteTransfer::VOUCHER_DISCOUNTS,
            QuoteTransfer::GIFT_CARDS,
            QuoteTransfer::CART_RULE_DISCOUNTS,
            QuoteTransfer::PROMOTION_ITEMS,
            QuoteTransfer::IS_LOCKED,
            QuoteTransfer::QUOTE_REQUEST_VERSION_REFERENCE,
            QuoteTransfer::IS_ORDER_PLACED_SUCCESSFULLY,
            // the next fields are needed for the async quote process flow
            QuoteTransfer::CUSTOMER,
            QuoteTransfer::CUSTOMER_REFERENCE,
            QuoteTransfer::STORE,
            QuoteTransfer::PAYMENT,
            QuoteTransfer::PAYMENTS,
            QuoteTransfer::BILLING_ADDRESS,
            QuoteTransfer::SHIPPING_ADDRESS,
            QuoteTransfer::ORDER_CUSTOM_REFERENCE,
            QuoteTransfer::SHIPMENT,
            QuoteTransfer::ERRORS,
        ]);
    }
}
