<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Router;

use Pyz\Yves\ExampleProductSalePage\Plugin\Router\ExampleProductSaleRouteProviderPlugin;
use Pyz\Yves\MultiCartPage\Plugin\Router\MultiCartPageRouteProviderPlugin;
use Spryker\Yves\Router\Plugin\RouteManipulator\LanguageDefaultPostAddRouteManipulatorPlugin;
use Spryker\Yves\Router\Plugin\RouteManipulator\SslPostAddRouteManipulatorPlugin;
use Spryker\Yves\Router\Plugin\RouteManipulator\StoreDefaultPostAddRouteManipulatorPlugin;
use Spryker\Yves\Router\Plugin\Router\YvesDevelopmentRouterPlugin;
use Spryker\Yves\Router\Plugin\Router\YvesRouterPlugin;
use Spryker\Yves\Router\Plugin\RouterEnhancer\LanguagePrefixRouterEnhancerPlugin;
use Spryker\Yves\Router\Plugin\RouterEnhancer\StorePrefixRouterEnhancerPlugin;
use Spryker\Yves\Router\RouterDependencyProvider as SprykerRouterDependencyProvider;
use SprykerShop\Yves\AgentPage\Plugin\Router\AgentPageRouteProviderPlugin;
use SprykerShop\Yves\AgentWidget\Plugin\Router\AgentWidgetRouteProviderPlugin;
use SprykerShop\Yves\AvailabilityNotificationPage\Plugin\Router\AvailabilityNotificationPageRouteProviderPlugin;
use SprykerShop\Yves\AvailabilityNotificationWidget\Plugin\Router\AvailabilityNotificationWidgetRouteProviderPlugin;
use SprykerShop\Yves\CalculationPage\Plugin\Router\CalculationPageRouteProviderPlugin;
use SprykerShop\Yves\CartCodeWidget\Plugin\Router\CartCodeWidgetRouteProviderPlugin;
use SprykerShop\Yves\CartNoteWidget\Plugin\Router\CartNoteWidgetRouteProviderPlugin;
use SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin;
use SprykerShop\Yves\CartToShoppingListWidget\Plugin\Router\CartToShoppingListWidgetRouteProviderPlugin;
use SprykerShop\Yves\CatalogPage\Plugin\Router\CatalogPageRouteProviderPlugin;
use SprykerShop\Yves\CheckoutPage\Plugin\Router\CheckoutPageRouteProviderPlugin;
use SprykerShop\Yves\CmsPage\Plugin\Router\CmsPageRouteProviderPlugin;
use SprykerShop\Yves\CmsSearchPage\Plugin\Router\CmsSearchPageRouteProviderPlugin;
use SprykerShop\Yves\CommentWidget\Plugin\Router\CommentWidgetRouteProviderPlugin;
use SprykerShop\Yves\CompanyPage\Plugin\Router\CompanyPageRouteProviderPlugin;
use SprykerShop\Yves\CompanyUserAgentWidget\Plugin\Router\CompanyUserAgentWidgetRouteProviderPlugin;
use SprykerShop\Yves\CompanyUserInvitationPage\Plugin\Router\CompanyUserInvitationPageRouteProviderPlugin;
use SprykerShop\Yves\CurrencyWidget\Plugin\Router\CurrencyWidgetRouteProviderPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;
use SprykerShop\Yves\CustomerReorderWidget\Plugin\Router\CustomerReorderWidgetRouteProviderPlugin;
use SprykerShop\Yves\DiscountWidget\Plugin\Router\DiscountWidgetRouteProviderPlugin;
use SprykerShop\Yves\ErrorPage\Plugin\Router\ErrorPageRouteProviderPlugin;
use SprykerShop\Yves\FileManagerWidget\Plugin\Router\FileManagerWidgetRouteProviderPlugin;
use SprykerShop\Yves\HeartbeatPage\Plugin\Router\HeartbeatPageRouteProviderPlugin;
use SprykerShop\Yves\HomePage\Plugin\Router\HomePageRouteProviderPlugin;
use SprykerShop\Yves\NewsletterPage\Plugin\Router\NewsletterPageRouteProviderPlugin;
use SprykerShop\Yves\NewsletterWidget\Plugin\Router\NewsletterWidgetRouteProviderPlugin;
use SprykerShop\Yves\PersistentCartSharePage\Plugin\Router\PersistentCartSharePageRouteProviderPlugin;
use SprykerShop\Yves\PersistentCartShareWidget\Plugin\Router\PersistentCartShareWidgetRouteProviderPlugin;
use SprykerShop\Yves\PriceWidget\Plugin\Router\PriceWidgetRouteProviderPlugin;
use SprykerShop\Yves\ProductNewPage\Plugin\Router\ProductNewPageRouteProviderPlugin;
use SprykerShop\Yves\ProductReviewWidget\Plugin\Router\ProductReviewWidgetRouteProviderPlugin;
use SprykerShop\Yves\ProductSearchWidget\Plugin\Router\ProductSearchWidgetRouteProviderPlugin;
use SprykerShop\Yves\ProductSetListPage\Plugin\Router\ProductSetListPageRouteProviderPlugin;
use SprykerShop\Yves\QuickOrderPage\Plugin\Router\QuickOrderPageRouteProviderPlugin;
use SprykerShop\Yves\QuoteApprovalWidget\Plugin\Router\QuoteApprovalWidgetRouteProviderPlugin;
use SprykerShop\Yves\QuoteRequestAgentPage\Plugin\Router\QuoteRequestAgentPageRouteProviderPlugin;
use SprykerShop\Yves\QuoteRequestAgentWidget\Plugin\Router\QuoteRequestAgentWidgetRouteProviderPlugin;
use SprykerShop\Yves\QuoteRequestPage\Plugin\Router\QuoteRequestPageRouteProviderPlugin;
use SprykerShop\Yves\QuoteRequestWidget\Plugin\Router\QuoteRequestWidgetRouteProviderPlugin;
use SprykerShop\Yves\ResourceSharePage\Plugin\Router\ResourceSharePageRouteProviderPlugin;
use SprykerShop\Yves\SharedCartPage\Plugin\Router\SharedCartPageRouteProviderPlugin;
use SprykerShop\Yves\ShoppingListPage\Plugin\Router\ShoppingListPageRouteProviderPlugin;
use SprykerShop\Yves\ShoppingListWidget\Plugin\Router\ShoppingListWidgetRouteProviderPlugin;
use SprykerShop\Yves\StorageRouter\Plugin\Router\StorageRouterPlugin;

class RouterDependencyProvider extends SprykerRouterDependencyProvider
{
    /**
     * @return \Spryker\Yves\RouterExtension\Dependency\Plugin\RouterPluginInterface[]
     */
    protected function getRouterPlugins(): array
    {
        return [
            new YvesRouterPlugin(),
            new StorageRouterPlugin(),
            // This router will only be hit, when no other router was able to match/generate.
            new YvesDevelopmentRouterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Yves\RouterExtension\Dependency\Plugin\RouteProviderPluginInterface[]
     */
    protected function getRouteProvider(): array
    {
        return [
            new ErrorPageRouteProviderPlugin(),
            new HomePageRouteProviderPlugin(),
            new CheckoutPageRouteProviderPlugin(),
            new CustomerPageRouteProviderPlugin(),
            new CustomerReorderWidgetRouteProviderPlugin(),
            new NewsletterPageRouteProviderPlugin(),
            new CartPageRouteProviderPlugin(),
            new HeartbeatPageRouteProviderPlugin(),
            new NewsletterWidgetRouteProviderPlugin(),
            new CatalogPageRouteProviderPlugin(),
            new CalculationPageRouteProviderPlugin(),
            new ProductSetListPageRouteProviderPlugin(),
            new ExampleProductSaleRouteProviderPlugin(),
            new CmsPageRouteProviderPlugin(),
            new CurrencyWidgetRouteProviderPlugin(),
            new ProductNewPageRouteProviderPlugin(),
            new ProductReviewWidgetRouteProviderPlugin(),
            new DiscountWidgetRouteProviderPlugin(),
            new PriceWidgetRouteProviderPlugin(),
            new CartCodeWidgetRouteProviderPlugin(),
            new CartNoteWidgetRouteProviderPlugin(), #CartNoteFeature
            new QuickOrderPageRouteProviderPlugin(),
            new CompanyPageRouteProviderPlugin(),
            new MultiCartPageRouteProviderPlugin(), #MultiCartFeature
            new SharedCartPageRouteProviderPlugin(), #SharedCartFeature
            new ShoppingListPageRouteProviderPlugin(), #ShoppingListFeature
            new CartToShoppingListWidgetRouteProviderPlugin(), #ShoppingListFeature
            new ShoppingListWidgetRouteProviderPlugin(), #ShoppingListFeature
            new CompanyUserInvitationPageRouteProviderPlugin(), #BulkImportCompanyUserInvitationsFeature
            new AgentPageRouteProviderPlugin(), #AgentFeature
            new AgentWidgetRouteProviderPlugin(), #AgentFeature
            new FileManagerWidgetRouteProviderPlugin(),
            new CmsSearchPageRouteProviderPlugin(), #CmsSearchPageFeature
            new ProductSearchWidgetRouteProviderPlugin(),
            new AvailabilityNotificationWidgetRouteProviderPlugin(),
            new AvailabilityNotificationPageRouteProviderPlugin(),
            new QuoteApprovalWidgetRouteProviderPlugin(), #QuoteApprovalFeature
            new QuoteRequestAgentPageRouteProviderPlugin(),
            new QuoteRequestAgentWidgetRouteProviderPlugin(),
            new QuoteRequestPageRouteProviderPlugin(),
            new QuoteRequestWidgetRouteProviderPlugin(),
            new PersistentCartSharePageRouteProviderPlugin(),
            new PersistentCartShareWidgetRouteProviderPlugin(),
            new ResourceSharePageRouteProviderPlugin(),
            new CommentWidgetRouteProviderPlugin(),
            new CompanyUserAgentWidgetRouteProviderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Yves\RouterExtension\Dependency\Plugin\PostAddRouteManipulatorPluginInterface[]
     */
    protected function getPostAddRouteManipulator(): array
    {
        return [
            new LanguageDefaultPostAddRouteManipulatorPlugin(),
            new StoreDefaultPostAddRouteManipulatorPlugin(),
            new SslPostAddRouteManipulatorPlugin(),
        ];
    }

    /**
     * @return \Spryker\Yves\RouterExtension\Dependency\Plugin\RouterEnhancerPluginInterface[]
     */
    protected function getRouterEnhancerPlugins(): array
    {
        return [
            new LanguagePrefixRouterEnhancerPlugin(),
            new StorePrefixRouterEnhancerPlugin(),
        ];
    }
}
