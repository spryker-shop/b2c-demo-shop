<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage;

use SprykerShop\Yves\CartNoteWidget\Plugin\CartPage\CartNoteQuoteItemWidgetPlugin;
use SprykerShop\Yves\CartNoteWidget\Plugin\CartPage\CartNoteQuoteWidgetPlugin;
use SprykerShop\Yves\CartPage\CartPageDependencyProvider as SprykerCartPageDependencyProvider;
use SprykerShop\Yves\CheckoutWidget\Plugin\CartPage\CheckoutBreadcrumbWidgetPlugin;
use SprykerShop\Yves\DiscountPromotionWidget\Plugin\CartPage\DiscountPromotionItemListWidgetPlugin;
use SprykerShop\Yves\DiscountWidget\Plugin\CartPage\DiscountSummaryWidgetPlugin;
use SprykerShop\Yves\DiscountWidget\Plugin\CartPage\DiscountVoucherFormWidgetPlugin;
use SprykerShop\Yves\ProductBundleWidget\Plugin\CartPage\ProductBundleCartItemTransformerPlugin;
use SprykerShop\Yves\ProductBundleWidget\Plugin\CartPage\ProductBundleItemsWidgetPlugin;
use SprykerShop\Yves\ProductOptionWidget\Plugin\CartPage\CartItemProductOptionWidgetPlugin;
use SprykerShop\Yves\ProductRelationWidget\Plugin\CartPage\UpSellingProductsWidgetPlugin;

class CartPageDependencyProvider extends SprykerCartPageDependencyProvider
{
    /**
     * @return array
     */
    protected function getCartPageWidgetPlugins(): array
    {
        return [
            CartItemProductOptionWidgetPlugin::class,
            CheckoutBreadcrumbWidgetPlugin::class,
            DiscountVoucherFormWidgetPlugin::class,
            DiscountSummaryWidgetPlugin::class,
            DiscountPromotionItemListWidgetPlugin::class,
            UpSellingProductsWidgetPlugin::class,
            ProductBundleItemsWidgetPlugin::class,
            CartNoteQuoteWidgetPlugin::class, #CartNoteFeature
            CartNoteQuoteItemWidgetPlugin::class, #CartNoteFeature
        ];
    }

    /**
     * @return \SprykerShop\Yves\CartPage\Dependency\Plugin\CartItemTransformerPluginInterface[]
     */
    protected function getCartItemTransformerPlugins(): array
    {
        return [
            new ProductBundleCartItemTransformerPlugin(),
        ];
    }
}
