<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Checkout;

use Spryker\Zed\Availability\Communication\Plugin\ProductsAvailableCheckoutPreConditionPlugin;
use Spryker\Zed\CartNote\Communication\Plugin\Checkout\CartNoteSaverPlugin;
use Spryker\Zed\CartNote\Communication\Plugin\Checkout\UpdateCartNoteCheckoutDoSaveOrderPlugin;
use Spryker\Zed\Checkout\CheckoutDependencyProvider as SprykerCheckoutDependencyProvider;
use Spryker\Zed\Customer\Communication\Plugin\Checkout\CustomerAddressSalutationCheckoutPreConditionPlugin;
use Spryker\Zed\Customer\Communication\Plugin\Checkout\CustomerOrderSavePlugin;
use Spryker\Zed\Customer\Communication\Plugin\Checkout\CustomerSalutationCheckoutPreConditionPlugin;
use Spryker\Zed\Customer\Communication\Plugin\CustomerPreConditionCheckerPlugin;
use Spryker\Zed\Discount\Communication\Plugin\Checkout\DiscountOrderSavePlugin;
use Spryker\Zed\Discount\Communication\Plugin\Checkout\ReleaseUsedCodesCheckoutDoSaveOrderPlugin;
use Spryker\Zed\Discount\Communication\Plugin\Checkout\ReplaceSalesOrderDiscountsCheckoutDoSaveOrderPlugin;
use Spryker\Zed\Discount\Communication\Plugin\Checkout\VoucherDiscountMaxUsageCheckoutPreConditionPlugin;
use Spryker\Zed\DummyPayment\Communication\Plugin\Checkout\DummyPaymentCheckoutPostSavePlugin;
use Spryker\Zed\DummyPayment\Communication\Plugin\Checkout\DummyPaymentCheckoutPreConditionPlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\Checkout\GiftCardCheckoutPreConditionPlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\Checkout\GiftCardPaymentCheckoutDoSaveOrderPlugin;
use Spryker\Zed\GiftCardMailConnector\Communication\Plugin\Checkout\SendEmailToGiftCardUser;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Nopayment\Communication\Plugin\Checkout\NopaymentCheckoutPreConditionPlugin;
use Spryker\Zed\Payment\Communication\Plugin\Checkout\PaymentAuthorizationCheckoutPostSavePlugin;
use Spryker\Zed\Payment\Communication\Plugin\Checkout\PaymentConfirmPreOrderPaymentCheckoutPostSavePlugin;
use Spryker\Zed\Payment\Communication\Plugin\Checkout\PaymentMethodValidityCheckoutPreConditionPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Checkout\ProductBundleAvailabilityCheckoutPreConditionPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Checkout\ProductBundleOrderSaverPlugin;
use Spryker\Zed\ProductCartConnector\Communication\Plugin\Checkout\ProductExistsCheckoutPreConditionPlugin;
use Spryker\Zed\ProductConfigurationCart\Communication\Plugin\Checkout\ProductConfigurationCheckoutPreConditionPlugin;
use Spryker\Zed\ProductDiscontinued\Communication\Plugin\Checkout\ProductDiscontinuedCheckoutPreConditionPlugin;
use Spryker\Zed\ProductQuantity\Communication\Plugin\Checkout\ProductQuantityRestrictionCheckoutPreConditionPlugin;
use Spryker\Zed\QuoteCheckoutConnector\Communication\Plugin\Checkout\DisallowedQuoteCheckoutPreConditionPlugin;
use Spryker\Zed\QuoteCheckoutConnector\Communication\Plugin\Checkout\DisallowQuoteCheckoutPreSavePlugin;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\DuplicateOrderCheckoutPreConditionPlugin;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\OrderItemsSaverPlugin;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\OrderSaverPlugin;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\OrderTotalsSaverPlugin;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\UpdateOrderByQuoteCheckoutDoSaveOrderPlugin;
use Spryker\Zed\Sales\Communication\Plugin\SalesOrderExpanderPlugin;
use Spryker\Zed\SalesOrderAmendment\Communication\Plugin\Checkout\OriginalOrderQuoteExpanderCheckoutPreSavePlugin;
use Spryker\Zed\SalesOrderAmendment\Communication\Plugin\Checkout\SalesOrderAmendmentItemsCheckoutDoSaveOrderPlugin;
use Spryker\Zed\SalesOrderAmendmentOms\Communication\Plugin\Checkout\FinishOrderAmendmentCheckoutPostSavePlugin;
use Spryker\Zed\SalesOrderAmendmentOms\Communication\Plugin\Checkout\OrderAmendmentCheckoutPreCheckPlugin;
use Spryker\Zed\SalesOrderThreshold\Communication\Plugin\Checkout\ReplaceSalesOrderThresholdExpensesCheckoutDoSaveOrderPlugin;
use Spryker\Zed\SalesOrderThreshold\Communication\Plugin\Checkout\SalesOrderThresholdCheckoutPreConditionPlugin;
use Spryker\Zed\SalesOrderThreshold\Communication\Plugin\Checkout\SalesOrderThresholdExpenseSavePlugin;
use Spryker\Zed\SalesPayment\Communication\Plugin\Checkout\ReplaceSalesOrderPaymentCheckoutDoSaveOrderPlugin;
use Spryker\Zed\SalesPayment\Communication\Plugin\Checkout\SalesPaymentCheckoutDoSaveOrderPlugin;
use Spryker\Zed\SalesShipmentType\Communication\Plugin\Checkout\ShipmentTypeCheckoutDoSaveOrderPlugin;
use Spryker\Zed\Shipment\Communication\Plugin\Checkout\ReplaceSalesOrderShipmentCheckoutDoSaveOrderPlugin;
use Spryker\Zed\Shipment\Communication\Plugin\Checkout\SalesOrderShipmentSavePlugin;
use Spryker\Zed\ShipmentCheckoutConnector\Communication\Plugin\Checkout\ShipmentCheckoutPreCheckPlugin;

class CheckoutDependencyProvider extends SprykerCheckoutDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return list<\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreConditionPluginInterface>
     */
    protected function getCheckoutPreConditionsForOrderAmendment(Container $container): array
    {
        return [
            new OrderAmendmentCheckoutPreCheckPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return list<\Spryker\Zed\Checkout\Dependency\Plugin\CheckoutSaveOrderInterface|\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutDoSaveOrderInterface>
     */
    protected function getCheckoutOrderSaversForOrderAmendment(Container $container): array
    {
        return [
            new CustomerOrderSavePlugin(),
            new UpdateOrderByQuoteCheckoutDoSaveOrderPlugin(),
            new OrderTotalsSaverPlugin(),
            new ReleaseUsedCodesCheckoutDoSaveOrderPlugin(),
            new ShipmentTypeCheckoutDoSaveOrderPlugin(),
            new UpdateCartNoteCheckoutDoSaveOrderPlugin(),
            new ReplaceSalesOrderDiscountsCheckoutDoSaveOrderPlugin(),
            new ReplaceSalesOrderShipmentCheckoutDoSaveOrderPlugin(),
            new SalesOrderAmendmentItemsCheckoutDoSaveOrderPlugin(),
            new ProductBundleOrderSaverPlugin(),
            new ReplaceSalesOrderPaymentCheckoutDoSaveOrderPlugin(),
            new GiftCardPaymentCheckoutDoSaveOrderPlugin(),
            new ReplaceSalesOrderThresholdExpensesCheckoutDoSaveOrderPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return list<\Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPreSaveHookInterface|\Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPreSaveInterface|\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreSavePluginInterface>
     */
    protected function getCheckoutPreSaveHooksForOrderAmendment(Container $container): array
    {
        return [
            new DisallowQuoteCheckoutPreSavePlugin(),
            new SalesOrderExpanderPlugin(),
            new OriginalOrderQuoteExpanderCheckoutPreSavePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return list<\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPostSaveInterface>
     */
    protected function getCheckoutPostHooksForOrderAmendment(Container $container): array
    {
        return [
            new DummyPaymentCheckoutPostSavePlugin(),
            new SendEmailToGiftCardUser(),
            new PaymentAuthorizationCheckoutPostSavePlugin(),
            new PaymentConfirmPreOrderPaymentCheckoutPostSavePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreConditionPluginInterface>
     */
    protected function getCheckoutPreConditions(Container $container): array // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        return [
            new DisallowedQuoteCheckoutPreConditionPlugin(),
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
    protected function getCheckoutOrderSavers(Container $container): array // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
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
            new DiscountOrderSavePlugin(),
            new ProductBundleOrderSaverPlugin(),
            new SalesPaymentCheckoutDoSaveOrderPlugin(),
            new GiftCardPaymentCheckoutDoSaveOrderPlugin(),
            new SalesOrderThresholdExpenseSavePlugin(), #SalesOrderThresholdFeature
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPostSaveInterface>
     */
    protected function getCheckoutPostHooks(Container $container): array // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        return [
            new DummyPaymentCheckoutPostSavePlugin(),
            new SendEmailToGiftCardUser(), #GiftCardFeature
            new PaymentAuthorizationCheckoutPostSavePlugin(),
            new PaymentConfirmPreOrderPaymentCheckoutPostSavePlugin(),
            new FinishOrderAmendmentCheckoutPostSavePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPreSaveHookInterface|\Spryker\Zed\Checkout\Dependency\Plugin\CheckoutPreSaveInterface|\Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreSavePluginInterface>
     */
    protected function getCheckoutPreSaveHooks(Container $container): array // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        return [
            new DisallowQuoteCheckoutPreSavePlugin(),
            new SalesOrderExpanderPlugin(),
        ];
    }
}
