<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Sales;

use Spryker\Zed\Sales\SalesConfig as SprykerSalesConfig;

class SalesConfig extends SprykerSalesConfig
{
    /**
     * This method provides list of urls to render blocks inside order detail page.
     * URL defines path to external bundle controller. For example: /discount/sales/list would call discount bundle, sales controller, list action.
     * Action should return return array or redirect response.
     *
     * example:
     * [
     *    'discount' => '/discount/sales/index',
     * ]
     *
     * @return array<string>
     */
    public function getSalesDetailExternalBlocksUrls(): array
    {
        $projectExternalBlocks = [
            'cart_note' => '/cart-note/sales/list', #CartNoteFeature
            'return' => '/sales-return-gui/sales/list',
            'cart_note_bundle_items' => '/cart-note-product-bundle-connector/sales/list', #CartNoteFeature
            'payments' => '/sales-payment-gui/sales/list',
            'giftCards' => '/gift-card/sales/list',
            'discount' => '/discount/sales/list',
            'refund' => '/refund/sales/list',
        ];

        $externalBlocks = parent::getSalesDetailExternalBlocksUrls();

        return array_merge($externalBlocks, $projectExternalBlocks);
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isHydrateOrderHistoryToItems(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isOldDeterminationForOrderItemProcessEnabled(): bool
    {
        return false;
    }
}
