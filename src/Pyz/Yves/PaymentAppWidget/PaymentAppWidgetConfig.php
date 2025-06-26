<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\PaymentAppWidget;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerShop\Yves\CheckoutPage\Plugin\Router\CheckoutPageRouteProviderPlugin;
use SprykerShop\Yves\PaymentAppWidget\PaymentAppWidgetConfig as SprykerPaymentAppWidgetConfig;

class PaymentAppWidgetConfig extends SprykerPaymentAppWidgetConfig
{
    /**
     * @var list<string>
     */
    protected const CHECKOUT_STEPS_TO_SKIP_IN_EXPRESS_CHECKOUT_WORKFLOW = [
        'address',
        'shipment',
        'payment',
    ];

    /**
     * @var list<string>
     */
    protected const QUOTE_FIELDS_TO_CLEAN_IN_EXPRESS_CHECKOUT_WORKFLOW = [
        QuoteTransfer::PAYMENT,
        QuoteTransfer::PAYMENTS,
        QuoteTransfer::SHIPMENT,
        QuoteTransfer::BILLING_ADDRESS,
        QuoteTransfer::SHIPPING_ADDRESS,
        QuoteTransfer::PRE_ORDER_PAYMENT_DATA,
    ];

    /**
     * @return string
     */
    public function getExpressCheckoutStartPageRouteName(): string
    {
        return CheckoutPageRouteProviderPlugin::ROUTE_NAME_CHECKOUT_INDEX;
    }
}
