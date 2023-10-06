<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Discount;

use Spryker\Zed\CategoryDiscountConnector\Communication\Plugin\Discount\CategoryDecisionRulePlugin;
use Spryker\Zed\CategoryDiscountConnector\Communication\Plugin\Discount\CategoryDiscountableItemCollectorPlugin;
use Spryker\Zed\CustomerGroupDiscountConnector\Communication\Plugin\DecisionRule\CustomerGroupDecisionRulePlugin;
use Spryker\Zed\Discount\DiscountDependencyProvider as SprykerDiscountDependencyProvider;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionCalculationFormDataExpanderPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionCalculationFormExpanderPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionCleanerPostUpdatePlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionCollectorStrategyPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionConfigurationExpanderPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionDiscountPostUpdatePlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionDiscountVoucherApplyCheckerStrategyPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionFilterApplicableItemsPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionFilterCollectedItemsPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionPostCreatePlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\DiscountPromotionViewBlockProviderPlugin;
use Spryker\Zed\DiscountPromotion\Communication\Plugin\Discount\PromotionCollectedDiscountGroupingStrategyPlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardDiscountableItemFilterPlugin;
use Spryker\Zed\Kernel\Communication\Form\FormTypeInterface;
use Spryker\Zed\MoneyGui\Communication\Plugin\Form\MoneyCollectionFormTypePlugin;
use Spryker\Zed\ProductDiscountConnector\Communication\Plugin\Collector\ProductAttributeCollectorPlugin;
use Spryker\Zed\ProductDiscountConnector\Communication\Plugin\DecisionRule\ProductAttributeDecisionRulePlugin;
use Spryker\Zed\ProductLabelDiscountConnector\Communication\Plugin\Discount\ProductLabelDiscountableItemCollectorPlugin;
use Spryker\Zed\ProductLabelDiscountConnector\Communication\Plugin\Discount\ProductLabelListDecisionRulePlugin;
use Spryker\Zed\SalesQuantity\Communication\Plugin\DiscountExtension\NonSplittableDiscountableItemTransformerStrategyPlugin;
use Spryker\Zed\ShipmentDiscountConnector\Communication\Plugin\DecisionRule\ShipmentCarrierDecisionRulePlugin;
use Spryker\Zed\ShipmentDiscountConnector\Communication\Plugin\DecisionRule\ShipmentMethodDecisionRulePlugin;
use Spryker\Zed\ShipmentDiscountConnector\Communication\Plugin\DecisionRule\ShipmentPriceDecisionRulePlugin;
use Spryker\Zed\ShipmentDiscountConnector\Communication\Plugin\DiscountCollector\ItemByShipmentCarrierPlugin;
use Spryker\Zed\ShipmentDiscountConnector\Communication\Plugin\DiscountCollector\ItemByShipmentMethodPlugin;
use Spryker\Zed\ShipmentDiscountConnector\Communication\Plugin\DiscountCollector\ItemByShipmentPricePlugin;
use Spryker\Zed\Store\Communication\Plugin\Form\StoreRelationToggleFormTypePlugin;

class DiscountDependencyProvider extends SprykerDiscountDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\DiscountExtension\Dependency\Plugin\DecisionRulePluginInterface>
     */
    protected function getDecisionRulePlugins(): array
    {
        return array_merge(parent::getDecisionRulePlugins(), [
            new ShipmentCarrierDecisionRulePlugin(),
            new ShipmentMethodDecisionRulePlugin(),
            new ShipmentPriceDecisionRulePlugin(),
            new CustomerGroupDecisionRulePlugin(),
            new ProductLabelListDecisionRulePlugin(),
            new ProductAttributeDecisionRulePlugin(),
            new CategoryDecisionRulePlugin(),
        ]);
    }

    /**
     * @return array<\Spryker\Zed\DiscountExtension\Dependency\Plugin\DiscountableItemCollectorPluginInterface>
     */
    protected function getCollectorPlugins(): array
    {
        return array_merge(parent::getCollectorPlugins(), [
            new ProductLabelDiscountableItemCollectorPlugin(),
            new ItemByShipmentCarrierPlugin(),
            new ItemByShipmentMethodPlugin(),
            new ItemByShipmentPricePlugin(),
            new ProductAttributeCollectorPlugin(),
            new CategoryDiscountableItemCollectorPlugin(),
        ]);
    }

    /**
     * @return array<\Spryker\Zed\Discount\Dependency\Plugin\DiscountableItemFilterPluginInterface>
     */
    protected function getDiscountableItemFilterPlugins(): array
    {
        return [
            new DiscountPromotionFilterCollectedItemsPlugin(),
            new GiftCardDiscountableItemFilterPlugin(), #GiftCardFeature
        ];
    }

    /**
     * @return array<\Spryker\Zed\DiscountExtension\Dependency\Plugin\CollectedDiscountGroupingStrategyPluginInterface>
     */
    protected function getCollectedDiscountGroupingPlugins(): array
    {
        return [
            new PromotionCollectedDiscountGroupingStrategyPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\DiscountExtension\Dependency\Plugin\DiscountableItemTransformerStrategyPluginInterface>
     */
    protected function getDiscountableItemTransformerStrategyPlugins(): array
    {
        return [
            new NonSplittableDiscountableItemTransformerStrategyPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\Discount\Dependency\Plugin\CollectorStrategyPluginInterface>
     */
    protected function getCollectorStrategyPlugins(): array
    {
        return [
            new DiscountPromotionCollectorStrategyPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\Discount\Dependency\Plugin\DiscountPostCreatePluginInterface>
     */
    protected function getDiscountPostCreatePlugins(): array
    {
        return [
            new DiscountPromotionPostCreatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\Discount\Dependency\Plugin\DiscountPostUpdatePluginInterface>
     */
    protected function getDiscountPostUpdatePlugins(): array
    {
        return [
            new DiscountPromotionDiscountPostUpdatePlugin(),
            new DiscountPromotionCleanerPostUpdatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\Discount\Dependency\Plugin\DiscountConfigurationExpanderPluginInterface>
     */
    protected function getDiscountConfigurationExpanderPlugins(): array
    {
        return [
            new DiscountPromotionConfigurationExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\Discount\Dependency\Plugin\Form\DiscountFormExpanderPluginInterface>
     */
    protected function getDiscountFormExpanderPlugins(): array
    {
        return [
            new DiscountPromotionCalculationFormExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\Discount\Dependency\Plugin\Form\DiscountFormDataProviderExpanderPluginInterface>
     */
    protected function getDiscountFormDataProviderExpanderPlugins(): array
    {
        return [
            new DiscountPromotionCalculationFormDataExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\Discount\Dependency\Plugin\DiscountViewBlockProviderPluginInterface>
     */
    protected function getDiscountViewTemplateProviderPlugins(): array
    {
        return [
            new DiscountPromotionViewBlockProviderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\Discount\Dependency\Plugin\DiscountApplicableFilterPluginInterface>
     */
    protected function getDiscountApplicableFilterPlugins(): array
    {
        return [
           new DiscountPromotionFilterApplicableItemsPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\Kernel\Communication\Form\FormTypeInterface
     */
    protected function getStoreRelationFormTypePlugin(): FormTypeInterface
    {
        return new StoreRelationToggleFormTypePlugin();
    }

    /**
     * @return array<\Spryker\Zed\DiscountExtension\Dependency\Plugin\DiscountVoucherApplyCheckerStrategyPluginInterface>
     */
    protected function getDiscountVoucherApplyCheckerStrategyPlugins(): array
    {
        return [
            new DiscountPromotionDiscountVoucherApplyCheckerStrategyPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\Kernel\Communication\Form\FormTypeInterface
     */
    protected function getMoneyCollectionFormTypePlugin(): FormTypeInterface
    {
        return new MoneyCollectionFormTypePlugin();
    }
}
