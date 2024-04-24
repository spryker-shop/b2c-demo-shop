<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Calculation;

use Spryker\Zed\Calculation\CalculationDependencyProvider as SprykerCalculationDependencyProvider;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\CanceledTotalCalculationPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\DiscountAmountAggregatorForGenericAmountPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\DiscountTotalCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\ExpenseTotalCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\GrandTotalCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\InitialGrandTotalCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\ItemDiscountAmountFullAggregatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\ItemProductOptionPriceAggregatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\ItemSubtotalAggregatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\NetTotalCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\OrderTaxTotalCalculationPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\PriceCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\PriceToPayAggregatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\RefundableAmountCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\RefundTotalCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\RemoveAllCalculatedDiscountsCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\RemoveCanceledAmountCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\RemoveTotalsCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\SubtotalCalculatorPlugin;
use Spryker\Zed\Calculation\Communication\Plugin\Calculator\TaxTotalCalculatorPlugin;
use Spryker\Zed\DiscountCalculationConnector\Communication\Plugin\Calculation\DiscountCalculationPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Calculation\RemovePromotionItemsCalculatorPlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardCalculatorPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Payment\Communication\Plugin\Calculation\PaymentCalculatorPlugin;
use Spryker\Zed\PersistentCart\Communication\Plugin\Calculation\QuoteSaveQuotePostRecalculateStrategyPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Calculation\CalculateBundlePricesPlugin;
use Spryker\Zed\ProductOption\Communication\Plugin\Calculation\ProductOptionTaxRateCalculatorPlugin;
use Spryker\Zed\SalesOrderThreshold\Communication\Plugin\Calculation\AddSalesOrderThresholdExpenseCalculatorPlugin;
use Spryker\Zed\SalesOrderThreshold\Communication\Plugin\Calculation\RemoveSalesOrderThresholdExpenseCalculatorPlugin;
use Spryker\Zed\Shipment\Communication\Plugin\Calculation\FilterObsoleteShipmentExpensesCalculatorPlugin;
use Spryker\Zed\Shipment\Communication\Plugin\Calculation\ShipmentTaxRateCalculatorPlugin;
use Spryker\Zed\Shipment\Communication\Plugin\Calculation\ShipmentTotalCalculatorPlugin;
use Spryker\Zed\TaxApp\Communication\Plugin\Calculation\TaxAppCalculationPlugin;
use Spryker\Zed\TaxProductConnector\Communication\Plugin\Calculation\ProductItemTaxRateCalculatorPlugin;

class CalculationDependencyProvider extends SprykerCalculationDependencyProvider
{
    /**
     * This calculator stack working with quote object which happens to be processed in cart/checkout
     *
     * You can view calculated values in: http://{domain.tld}/calculation/debug. For this to work you must have items in cart.
     *
     * RemoveTotalsCalculatorPlugin - Reset TotalsTransfer object
     *
     * RemoveAllCalculatedDiscountsCalculatorPlugin - Reset CalculateDiscounts for:
     *   - Item.calculatedDiscounts
     *   - Item.productOption.calculatedDiscounts
     *   - Expense.calculatedDiscounts
     *
     * RemoveCanceledAmountCalculatorPlugin - Reset item canceled amount for:
     *   - Item.canceledAmount
     *
     * PriceCalculatorPlugin - Calculates price based on tax mode, tax mode is set in this calculator based on CalculationConstants::TAX_MODE configuration key.
     *    - Item.unitPrice
     *    - Item.sumPrice
     *    - Item.productOption.unitPrice
     *    - Item.productOption.sumPrice
     *    - Expense.unitPrice
     *    - Expense.sumPrice
     *  When "gross" mode:
     *    - Item.sumGrossPrice
     *    - Item.productOption.sumGrossPrice
     *    - Expense.sumGrossPrice
     *  When "Net" mode:
     *    - Item.sumNetPrice
     *    - Item.productOption.sumNetPrice
     *    - Expense.sumNetPrice
     *
     * ItemProductOptionPriceAggregatorPlugin - Item option price sum total
     *    - Item.unitProductOptionAggregation
     *    - Item.sumProductOptionAggregation
     *
     * ItemSubtotalAggregatorPlugin - Total price amount (item + options + item expenses)
     *    - Item.unitSubtotal
     *    - Item.sumSubtotal
     *
     * SubtotalCalculatorPlugin - Sum of item sumAggregation
     *    - Total.subtotal
     *
     * DiscountCalculationPlugin - Discount bundle calculator, runs cart/order rules/applies voucher codes.
     *    - Item.calculatedDiscounts[].unitGrossAmount
     *    - Item.productOptions.calculatedDiscounts[].unitGrossAmount
     *    - Expense.calculatedDiscounts[].unitGrossAmount
     *
     * DiscountAmountAggregatorForGenericAmountPlugin - Sums all discounts for corresponding object
     *    - Item.unitDiscountAmountAggregation
     *    - Item.sumDiscountAmountAggregation
     *    - Item.productOptions.unitDiscountAmountAggregation
     *    - Item.productOptions.sumDiscountAmountAggregation
     *    - Expense.unitDiscountAmountAggregation
     *    - Expense.sumDiscountAmountAggregation
     *
     *    - Item.calculatedDiscounts[].sumGrossAmount
     *    - Item.productOptions.calculatedDiscounts[].sumGrossAmount
     *    - Expense.calculatedDiscounts[].sumGrossAmount
     *
     * ItemDiscountAmountFullAggregatorPlugin - Sums item all discounts with additions (option and item expense discounts)
     *    - Item.unitDiscountAmountFullAggregation
     *    - Item.sumDiscountAmountFullAggregation
     *
     * PriceToPayAggregatorPlugin - Final price customer have to pay after discounts
     *    - Item.unitPriceToPayAggregation
     *    - Item.sumPriceToPayAggregation
     *    - Expense.unitPriceToPayAggregation
     *    - Expense.sumPriceToPayAggregation
     *
     * TaxRateAverageAggregatorPlugin - average tax rate for item, used when recalculating canceled amount when refunded
     *    - Item.taxRateAverageAggregation
     *
     *  TaxAppCalculationPlugin - Calculate tax using external tax application. Replaces all tax calculation plugins above.
     *  Replaced tax calculation plugins should be moved to {@link \Spryker\Zed\TaxApp\TaxAppDependencyProvider::getFallbackQuoteCalculationPlugins} method.
     *  Replaced tax calculation plugin stack should include all plugins which were present between extracted tax-related plugins.
     *
     * ProductItemTaxRateCalculatorPlugin - Sets tax rate to item based on shipping address
     *    - Item.taxRate
     *
     * ProductOptionTaxRateCalculatorPlugin - Sets tax rate to expense based on shipping address
     *    - Item.productOptions[].taxRate
     *
     * ShipmentTaxRateCalculatorPlugin - Sets tax rate to expense based on shipping address
     *    - Expense.taxRate
     *
     * TaxAmountCalculatorPlugin - Calculates tax amount based on tax mode after discounts
     *    - Item.unitTaxAmount
     *    - Item.sumTaxAmount
     *    - Item.productOptions[].unitTaxAmount
     *    - Item.productOptions[].sumTaxAmount
     *    - Expense.unitTaxAmount
     *    - Expense.sumTaxAmount
     *
     * ItemTaxAmountFullAggregatorPlugin - Calculate for all item additions
     *    - Item.unitTaxAmountFullAggregation
     *    - Item.sumTaxAmountFullAggregation
     *
     * TaxRateAverageAggregatorPlugin - Calculate tax rate average aggregation used when recalculating taxable amount after refund
     *    - Item.taxRateAverageAggregation
     *
     * RefundableAmountCalculatorPlugin - Calculate refundable for each item and expenses
     *    - Item.refundableAmount
     *    - Expense.refundableAmount
     *
     * CalculateBundlePricesPlugin - Calculate bundle item total, from bundled items
     *    - BundledItem.unitPrice
     *    - BundledItem.sumPrice
     *    - BundledItem.unitGrossPrice
     *    - BundledItem.sumGrossPrice
     *    - BundledItem.unitNetPrice
     *    - BundledItem.sumNetPrice
     *    – BundledItem.unitTaxAmountFullAggregation
     *    - BundledItem.sumTaxAmountFullAggregation
     *    - BundledItem.unitTaxAmountAggregation
     *    - BundledItem.sumTaxAmountAggregation
     *
     * ExpenseTotalCalculatorPlugin - Calculate order expenses total
     *    - Totals.expenseTotal
     *
     * DiscountTotalCalculatorPlugin - Calculate discount total
     *    - Totals.discountTotal
     *
     * RefundTotalCalculatorPlugin - Calculate refund total
     *    - Totals.refundTotal
     *
     * GrandTotalCalculatorPlugin - Calculate grand total
     *    - Totals.grandTotal
     *
     * TaxTotalCalculatorPlugin - Total tax amount
     *    - Totals.taxTotal.amount
     *
     * NetTotalCalculatorPlugin - Calculate total amount before taxes
     *   - Totals.netTotal
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\CalculationExtension\Dependency\Plugin\CalculationPluginInterface>
     */
    protected function getQuoteCalculatorPluginStack(Container $container): array
    {
        /** @var array<\Spryker\Zed\Calculation\Dependency\Plugin\CalculationPluginInterface> $pluginStack */
        $pluginStack = [
            new RemoveTotalsCalculatorPlugin(),
            new RemoveAllCalculatedDiscountsCalculatorPlugin(),
            new RemovePromotionItemsCalculatorPlugin(),
            new RemoveCanceledAmountCalculatorPlugin(),
            new RemoveSalesOrderThresholdExpenseCalculatorPlugin(), #SalesOrderThresholdFeature
            new FilterObsoleteShipmentExpensesCalculatorPlugin(),

            new PriceCalculatorPlugin(),
            new ItemProductOptionPriceAggregatorPlugin(),
            new ItemSubtotalAggregatorPlugin(),

            new SubtotalCalculatorPlugin(),
            new AddSalesOrderThresholdExpenseCalculatorPlugin(), #SalesOrderThresholdFeature

            new ProductItemTaxRateCalculatorPlugin(),
            new ProductOptionTaxRateCalculatorPlugin(),
            new ShipmentTaxRateCalculatorPlugin(),

            new GiftCardCalculatorPlugin(), #GiftCardFeature

            new InitialGrandTotalCalculatorPlugin(),
            new DiscountCalculationPlugin(),
            new DiscountAmountAggregatorForGenericAmountPlugin(),
            new ItemDiscountAmountFullAggregatorPlugin(),

            new TaxAppCalculationPlugin(),

            new PriceToPayAggregatorPlugin(),

            new RefundableAmountCalculatorPlugin(),

            new CalculateBundlePricesPlugin(),

            new ShipmentTotalCalculatorPlugin(),
            new ExpenseTotalCalculatorPlugin(),
            new DiscountTotalCalculatorPlugin(),
            new RefundTotalCalculatorPlugin(),
            new TaxTotalCalculatorPlugin(),
            new GrandTotalCalculatorPlugin(),
            new NetTotalCalculatorPlugin(),

            new PaymentCalculatorPlugin(),
        ];

        return $pluginStack;
    }

    /**
     * This calculator plugin stack working with order object which happens to be created after order is placed
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\CalculationExtension\Dependency\Plugin\CalculationPluginInterface>
     */
    protected function getOrderCalculatorPluginStack(Container $container): array
    {
        return [

            new PriceCalculatorPlugin(),
            new ItemProductOptionPriceAggregatorPlugin(),
            new ItemSubtotalAggregatorPlugin(),

            new SubtotalCalculatorPlugin(),

            new DiscountCalculationPlugin(),

            new DiscountAmountAggregatorForGenericAmountPlugin(),
            new ItemDiscountAmountFullAggregatorPlugin(),

            new TaxAppCalculationPlugin(),

            new PriceToPayAggregatorPlugin(),

            new RefundableAmountCalculatorPlugin(),

            new ExpenseTotalCalculatorPlugin(),
            new DiscountTotalCalculatorPlugin(),
            new RefundTotalCalculatorPlugin(),
            new CanceledTotalCalculationPlugin(),
            new OrderTaxTotalCalculationPlugin(),

            new GrandTotalCalculatorPlugin(),
            new NetTotalCalculatorPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CalculationExtension\Dependency\Plugin\QuotePostRecalculatePluginStrategyInterface>
     */
    protected function getQuotePostRecalculatePlugins(): array
    {
        return [
            new QuoteSaveQuotePostRecalculateStrategyPlugin(),
        ];
    }
}
