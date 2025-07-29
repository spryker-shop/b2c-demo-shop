<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\PaymentAppShipment;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\PaymentAppShipment\PaymentAppShipmentConfig as SprykerPaymentAppShipmentConfig;

class PaymentAppShipmentConfig extends SprykerPaymentAppShipmentConfig
{
    /**
     * @var array<string, string>
     */
    protected const EXPRESS_CHECKOUT_SHIPMENT_METHODS_INDEXED_BY_PAYMENT_METHOD = [
        'payone-paypal-express' => 'spryker_dummy_shipment-standard',
    ];

    /**
     * @var list<string>
     */
    protected const SHIPMENT_ITEM_COLLECTION_FIELD_NAMES = [
        QuoteTransfer::BUNDLE_ITEMS,
    ];
}
