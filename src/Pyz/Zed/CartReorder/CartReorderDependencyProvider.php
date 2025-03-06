<?php

declare(strict_types = 1);

namespace Pyz\Zed\CartReorder;

use Spryker\Zed\AvailabilityCartConnector\Communication\Plugin\CartReorder\RemoveUnavailableItemsCartReorderPreAddToCartPlugin;
use Spryker\Zed\CartNote\Communication\Plugin\CartReorder\CartNoteCartPreReorderPlugin;
use Spryker\Zed\CartNote\Communication\Plugin\CartReorder\CartNoteCartReorderItemHydratorPlugin;
use Spryker\Zed\CartReorder\CartReorderDependencyProvider as SprykerCartReorderDependencyProvider;
use Spryker\Zed\ConfigurableBundleNote\Communication\Plugin\CartReorder\ConfigurableBundleNoteCartReorderItemHydratorPlugin;
use Spryker\Zed\Currency\Communication\Plugin\CartReorder\CopyOrderCurrencyCartPreReorderPlugin;
use Spryker\Zed\PersistentCart\Communication\Plugin\CartReorder\PersistentCartReorderQuoteProviderStrategyPlugin;
use Spryker\Zed\PersistentCart\Communication\Plugin\CartReorder\UpdateQuoteCartPostReorderPlugin;
use Spryker\Zed\Price\Communication\Plugin\CartReorder\CopyOrderPriceModeCartPreReorderPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\CartReorder\ProductBundleCartReorderOrderItemFilterPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\CartReorder\ReplaceBundledItemsCartPreReorderPlugin;
use Spryker\Zed\ProductCartConnector\Communication\Plugin\CartReorder\RemoveInactiveItemsCartReorderPreAddToCartPlugin;
use Spryker\Zed\ProductList\Communication\Plugin\CartReorder\ProductListRestrictedItemsCartPreReorderPlugin;
use Spryker\Zed\ProductOption\Communication\Plugin\CartReorder\ProductOptionCartReorderItemHydratorPlugin;
use Spryker\Zed\ProductOptionCartConnector\Communication\Plugin\CartReorder\RemoveInactiveProductOptionItemsCartReorderPreAddToCartPlugin;
use Spryker\Zed\ProductQuantity\Communication\Plugin\CartReorder\MergeProductQuantityRestrictionItemsCartPreReorderPlugin;
use Spryker\Zed\SalesConfigurableBundle\Communication\Plugin\CartReorder\ConfigurableBundleCartReorderItemHydratorPlugin;
use Spryker\Zed\SalesConfigurableBundle\Communication\Plugin\CartReorder\ConfiguredBundleCartPostReorderPlugin;
use Spryker\Zed\SalesConfigurableBundle\Communication\Plugin\CartReorder\MergeConfigurableBundleItemsCartPreReorderPlugin;
use Spryker\Zed\SalesOrderAmendment\Communication\Plugin\CartReorder\AmendmentOrderReferenceCartPreReorderPlugin;
use Spryker\Zed\SalesOrderAmendment\Communication\Plugin\CartReorder\AmendmentQuoteNameCartPreReorderPlugin;
use Spryker\Zed\SalesOrderAmendment\Communication\Plugin\CartReorder\OrderAmendmentCartReorderValidatorPlugin;
use Spryker\Zed\SalesOrderAmendment\Communication\Plugin\CartReorder\OrderAmendmentQuoteProcessFlowExpanderCartPreReorderPlugin;
use Spryker\Zed\SalesOrderAmendment\Communication\Plugin\CartReorder\OriginalSalesOrderItemGroupKeyCartReorderItemHydratorPlugin;
use Spryker\Zed\SalesOrderAmendmentOms\Communication\Plugin\CartReorder\IsAmendableOrderCartReorderValidatorRulePlugin;
use Spryker\Zed\SalesOrderAmendmentOms\Communication\Plugin\CartReorder\StartOrderAmendmentCartReorderPostCreatePlugin;
use Spryker\Zed\SalesProductConfiguration\Communication\Plugin\CartReorder\ProductConfigurationCartReorderItemHydratorPlugin;

class CartReorderDependencyProvider extends SprykerCartReorderDependencyProvider
{
    /**
     * @return list<\Spryker\Zed\CartReorderExtension\Dependency\Plugin\CartReorderQuoteProviderStrategyPluginInterface>
     */
    protected function getCartReorderQuoteProviderStrategyPlugins(): array
    {
        return [
            new PersistentCartReorderQuoteProviderStrategyPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\CartReorderExtension\Dependency\Plugin\CartReorderValidatorPluginInterface>
     */
    protected function getCartReorderValidatorPluginsForOrderAmendment(): array
    {
        return [
            new OrderAmendmentCartReorderValidatorPlugin(),
            new IsAmendableOrderCartReorderValidatorRulePlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\CartReorderExtension\Dependency\Plugin\CartPreReorderPluginInterface>
     */
    protected function getCartPreReorderPlugins(): array
    {
        return [
            new CopyOrderCurrencyCartPreReorderPlugin(),
            new CopyOrderPriceModeCartPreReorderPlugin(),
            new ProductListRestrictedItemsCartPreReorderPlugin(),
            new OrderAmendmentQuoteProcessFlowExpanderCartPreReorderPlugin(),
            new AmendmentOrderReferenceCartPreReorderPlugin(),
            new AmendmentQuoteNameCartPreReorderPlugin(),
            new ReplaceBundledItemsCartPreReorderPlugin(),
            new MergeConfigurableBundleItemsCartPreReorderPlugin(),
            new CartNoteCartPreReorderPlugin(),
            new MergeProductQuantityRestrictionItemsCartPreReorderPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\CartReorderExtension\Dependency\Plugin\CartReorderItemHydratorPluginInterface>
     */
    protected function getCartReorderItemHydratorPlugins(): array
    {
        return [
            new CartNoteCartReorderItemHydratorPlugin(),
            new ProductConfigurationCartReorderItemHydratorPlugin(),
            new ProductOptionCartReorderItemHydratorPlugin(),
            new ConfigurableBundleCartReorderItemHydratorPlugin(),
            new ConfigurableBundleNoteCartReorderItemHydratorPlugin(),
            new OriginalSalesOrderItemGroupKeyCartReorderItemHydratorPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\CartReorderExtension\Dependency\Plugin\CartPostReorderPluginInterface>
     */
    protected function getCartPostReorderPlugins(): array
    {
        return [
            new UpdateQuoteCartPostReorderPlugin(),
            new ConfiguredBundleCartPostReorderPlugin(),
            new StartOrderAmendmentCartReorderPostCreatePlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\CartReorderExtension\Dependency\Plugin\CartReorderPreAddToCartPluginInterface>
     */
    protected function getCartReorderPreAddToCartPlugins(): array
    {
        return [
            new RemoveUnavailableItemsCartReorderPreAddToCartPlugin(),
            new RemoveInactiveItemsCartReorderPreAddToCartPlugin(),
            new RemoveInactiveProductOptionItemsCartReorderPreAddToCartPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\CartReorderExtension\Dependency\Plugin\CartReorderOrderItemFilterPluginInterface>
     */
    protected function getCartReorderOrderItemFilterPlugins(): array
    {
        return [
            new ProductBundleCartReorderOrderItemFilterPlugin(),
        ];
    }
}
