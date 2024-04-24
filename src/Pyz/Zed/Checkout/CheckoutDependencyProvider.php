<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Checkout;

use Spryker\Zed\Availability\Communication\Plugin\ProductsAvailableCheckoutPreConditionPlugin;
use Spryker\Zed\CartNote\Communication\Plugin\Checkout\CartNoteSaverPlugin;
use Spryker\Zed\Checkout\CheckoutDependencyProvider as SprykerCheckoutDependencyProvider;
use Spryker\Zed\Customer\Communication\Plugin\Checkout\CustomerAddressSalutationCheckoutPreConditionPlugin;
use Spryker\Zed\Customer\Communication\Plugin\Checkout\CustomerOrderSavePlugin;
use Spryker\Zed\Customer\Communication\Plugin\Checkout\CustomerSalutationCheckoutPreConditionPlugin;
use Spryker\Zed\Customer\Communication\Plugin\CustomerPreConditionCheckerPlugin;
use Spryker\Zed\Discount\Communication\Plugin\Checkout\DiscountOrderSavePlugin;
use Spryker\Zed\Discount\Communication\Plugin\Checkout\VoucherDiscountMaxUsageCheckoutPreConditionPlugin;
use Spryker\Zed\DummyPayment\Communication\Plugin\Checkout\DummyPaymentCheckoutPostSavePlugin;
use Spryker\Zed\DummyPayment\Communication\Plugin\Checkout\DummyPaymentCheckoutPreConditionPlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\Checkout\GiftCardCheckoutDoSaveOrderPlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\Checkout\GiftCardCheckoutPreConditionPlugin;
use Spryker\Zed\GiftCardMailConnector\Communication\Plugin\Checkout\SendEmailToGiftCardUser;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Nopayment\Communication\Plugin\Checkout\NopaymentCheckoutPreConditionPlugin;
use Spryker\Zed\Payment\Communication\Plugin\Checkout\PaymentAuthorizationCheckoutPostSavePlugin;
use Spryker\Zed\Payment\Communication\Plugin\Checkout\PaymentMethodValidityCheckoutPreConditionPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Checkout\ProductBundleAvailabilityCheckoutPreConditionPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Checkout\ProductBundleOrderSaverPlugin;
use Spryker\Zed\ProductCartConnector\Communication\Plugin\Checkout\ProductExistsCheckoutPreConditionPlugin;
use Spryker\Zed\ProductConfigurationCart\Communication\Plugin\Checkout\ProductConfigurationCheckoutPreConditionPlugin;
use Spryker\Zed\ProductDiscontinued\Communication\Plugin\Checkout\ProductDiscontinuedCheckoutPreConditionPlugin;
use Spryker\Zed\ProductOption\Communication\Plugin\Checkout\ProductOptionOrderSaverPlugin;
use Spryker\Zed\ProductQuantity\Communication\Plugin\Checkout\ProductQuantityRestrictionCheckoutPreConditionPlugin;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\DuplicateOrderCheckoutPreConditionPlugin;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\OrderItemsSaverPlugin;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\OrderSaverPlugin;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\OrderTotalsSaverPlugin;
use Spryker\Zed\Sales\Communication\Plugin\SalesOrderExpanderPlugin;
use Spryker\Zed\SalesOrderThreshold\Communication\Plugin\Checkout\SalesOrderThresholdCheckoutPreConditionPlugin;
use Spryker\Zed\SalesOrderThreshold\Communication\Plugin\Checkout\SalesOrderThresholdExpenseSavePlugin;
use Spryker\Zed\SalesPayment\Communication\Plugin\Checkout\SalesPaymentCheckoutDoSaveOrderPlugin;
use Spryker\Zed\Shipment\Communication\Plugin\Checkout\SalesOrderShipmentSavePlugin;
use Spryker\Zed\ShipmentCheckoutConnector\Communication\Plugin\Checkout\ShipmentCheckoutPreCheckPlugin;

class CheckoutDependencyProvider extends SprykerCheckoutDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreConditionPluginInterface>
     */
    protected function getCheckoutPreConditions(Container $container): array
    {
        return [
            new CustomerPreConditionCheckerPlugin(),
            new CustomerSalutationCheckoutPreConditionPlugin(),
            new CustomerAddressSalutationCheckoutPreConditionPlugin(),
            new ProductsAvailableCheckoutPreConditionPlugin(),
            new ProductBundleAvailabilityCheckoutPreConditionPlugin(),
            new GiftCardCheckoutPreConditionPlugin(),
            new NopaymentCheckoutPreConditionPlugin(),
            new DummyPaymentCheckoutPreConditionPlugin(),
            new ShipmentCheckoutPreCheckPlugin(),
            new ProductDiscontinuedCheckoutPreConditionPlugin(), #ProductDiscontinuedFeature
            new SalesOrderThresholdCheckoutPreConditionPlugin(), #SalesOrderThresholdFeature
            new VoucherDiscountMaxUsageCheckoutPreConditionPlugin(),
            new ShipmentCheckoutPreCheckPlugin(),
            new PaymentMethodValidityCheckoutPreConditionPlugin(),
            new ProductConfigurationCheckoutPreConditionPlugin(),
            new DuplicateOrderCheckoutPreConditionPlugin(),
            new ProductExistsCheckoutPreConditionPlugin(),
            new ProductQuantityRestrictionCheckoutPreConditionPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutDoSaveOrderInterface>|array<\Spryker\Zed\Checkout\Dependency\Plugin\CheckoutSaveOrderInterface>
     */
    protected function getCheckoutOrderSavers(Container $container): array
    {
        return [
            new CustomerOrderSavePlugin(),
            /*
             * Plugins
             * `OrderSaverPlugin`,
             * `OrderTotalsSaverPlugin`,
             * `SalesOrderShipmentSavePlugin`,
             * `OrderItemsSaverPlugin`,
             * `ProductConfigurationOrderSaverPlugin`
             * must be enabled in the strict order.
             */
            new OrderSaverPlugin(),
            new OrderTotalsSaverPlugin(),
            new SalesOrderShipmentSavePlugin(),
            new OrderItemsSaverPlugin(),
            new CartNoteSaverPlugin(), #CartNoteFeature
            new ProductOptionOrderSaverPlugin(),
            new DiscountOrderSavePlugin(),
            new ProductBundleOrderSaverPlugin(),
            new SalesPaymentCheckoutDoSaveOrderPlugin(),
            new GiftCardCheckoutDoSaveOrderPlugin(),
            new SalesOrderThresholdExpenseSavePlugin(), #SalesOrderThresholdFeature
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPostSaveInterface>
     */
    protected function getCheckoutPostHooks(Container $container): array
    {
        return [
            new DummyPaymentCheckoutPostSavePlugin(),
            new SendEmailToGiftCardUser(), #GiftCardFeature
            new PaymentAuthorizationCheckoutPostSavePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPreSaveInterface>|array<\Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPreSaveHookInterface>
     */
    protected function getCheckoutPreSaveHooks(Container $container): array
    {
        return [
            new SalesOrderExpanderPlugin(),
        ];
    }
}
