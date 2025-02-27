<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Quote;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Quote\QuoteConfig as SprykerQuoteConfig;

class QuoteConfig extends SprykerQuoteConfig
{
    /**
     * @return array<string>
     */
    public function getQuoteFieldsAllowedForSaving(): array
    {
        return array_merge(parent::getQuoteFieldsAllowedForSaving(), [
            QuoteTransfer::BUNDLE_ITEMS,
            QuoteTransfer::CART_NOTE, #CartNoteFeature
            QuoteTransfer::VOUCHER_DISCOUNTS, #PromotionsDiscountsFeature
            QuoteTransfer::CART_RULE_DISCOUNTS, #PromotionsDiscountsFeature
            QuoteTransfer::PROMOTION_ITEMS, #PromotionsDiscountsFeature
            QuoteTransfer::GIFT_CARDS, #GiftCardFeature
            QuoteTransfer::IS_ORDER_PLACED_SUCCESSFULLY,
            QuoteTransfer::EXPENSES,
        ]);
    }
}
