<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\Router;

use Pyz\Yves\ExampleProductSalePage\Plugin\Router\ExampleProductSaleRouteProviderPlugin;
use Spryker\Yves\CustomerDataChangeRequest\Plugin\Router\CustomerDataChangeRequestRouteProviderPlugin;
use Spryker\Yves\HealthCheck\Plugin\Router\HealthCheckRouteProviderPlugin;
use Spryker\Yves\MultiFactorAuth\Plugin\Router\Agent\MultiFactorAuthAgentRouteProviderPlugin;
use Spryker\Yves\MultiFactorAuth\Plugin\Router\Customer\MultiFactorAuthCustomerRouteProviderPlugin;
use Spryker\Yves\Router\Plugin\RouteManipulator\LanguageDefaultPostAddRouteManipulatorPlugin;
use Spryker\Yves\Router\Plugin\RouteManipulator\SslPostAddRouteManipulatorPlugin;
use Spryker\Yves\Router\Plugin\RouteManipulator\StoreDefaultPostAddRouteManipulatorPlugin;
use Spryker\Yves\Router\Plugin\Router\YvesDevelopmentRouterPlugin;
use Spryker\Yves\Router\Plugin\Router\YvesRouterPlugin;
use Spryker\Yves\Router\Plugin\RouterEnhancer\LanguagePrefixRouterEnhancerPlugin;
use Spryker\Yves\Router\Plugin\RouterEnhancer\StorePrefixRouterEnhancerPlugin;
use Spryker\Yves\Router\RouterDependencyProvider as SprykerRouterDependencyProvider;
use Spryker\Yves\Sitemap\Plugin\Router\SitemapRouteProviderPlugin;
use SprykerShop\Yves\AgentPage\Plugin\Router\AgentPageRouteProviderPlugin;
use SprykerShop\Yves\AgentWidget\Plugin\Router\AgentWidgetRouteProviderPlugin;
use SprykerShop\Yves\AvailabilityNotificationPage\Plugin\Router\AvailabilityNotificationPageRouteProviderPlugin;
use SprykerShop\Yves\AvailabilityNotificationWidget\Plugin\Router\AvailabilityNotificationWidgetRouteProviderPlugin;
use SprykerShop\Yves\CalculationPage\Plugin\Router\CalculationPageRouteProviderPlugin;
use SprykerShop\Yves\CartCodeWidget\Plugin\Router\CartCodeAsyncWidgetRouteProviderPlugin;
use SprykerShop\Yves\CartCodeWidget\Plugin\Router\CartCodeWidgetRouteProviderPlugin;
use SprykerShop\Yves\CartNoteWidget\Plugin\Router\CartNoteWidgetAsyncRouteProviderPlugin;
use SprykerShop\Yves\CartNoteWidget\Plugin\Router\CartNoteWidgetRouteProviderPlugin;
use SprykerShop\Yves\CartPage\Plugin\Router\CartPageAsyncRouteProviderPlugin;
use SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin;
use SprykerShop\Yves\CartReorderPage\Plugin\Router\CartReorderPageRouteProviderPlugin;
use SprykerShop\Yves\CatalogPage\Plugin\Router\CatalogPageRouteProviderPlugin;
use SprykerShop\Yves\CheckoutPage\Plugin\Router\CheckoutPageRouteProviderPlugin;
use SprykerShop\Yves\CmsPage\Plugin\Router\CmsPageRouteProviderPlugin;
use SprykerShop\Yves\CmsSearchPage\Plugin\Router\CmsSearchPageRouteProviderPlugin;
use SprykerShop\Yves\ConfigurableBundleNoteWidget\Plugin\Router\ConfigurableBundleNoteWidgetAsyncRouteProviderPlugin;
use SprykerShop\Yves\ConfigurableBundleNoteWidget\Plugin\Router\ConfigurableBundleNoteWidgetRouteProviderPlugin;
use SprykerShop\Yves\ConfigurableBundlePage\Plugin\Router\ConfigurableBundlePageRouteProviderPlugin;
use SprykerShop\Yves\ConfigurableBundleWidget\Plugin\Router\ConfigurableBundleWidgetAsyncRouteProviderPlugin;
use SprykerShop\Yves\ConfigurableBundleWidget\Plugin\Router\ConfigurableBundleWidgetRouteProviderPlugin;
use SprykerShop\Yves\CurrencyWidget\Plugin\Router\CurrencyWidgetRouteProviderPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;
use SprykerShop\Yves\DiscountWidget\Plugin\Router\DiscountWidgetRouteProviderPlugin;
use SprykerShop\Yves\ErrorPage\Plugin\Router\ErrorPageRouteProviderPlugin;
use SprykerShop\Yves\FileManagerWidget\Plugin\Router\FileManagerWidgetRouteProviderPlugin;
use SprykerShop\Yves\HomePage\Plugin\Router\HomePageRouteProviderPlugin;
use SprykerShop\Yves\NewsletterPage\Plugin\Router\NewsletterPageRouteProviderPlugin;
use SprykerShop\Yves\NewsletterWidget\Plugin\Router\NewsletterWidgetRouteProviderPlugin;
use SprykerShop\Yves\OrderCancelWidget\Plugin\Router\OrderCancelWidgetRouteProviderPlugin;
use SprykerShop\Yves\OrderCustomReferenceWidget\Plugin\Router\OrderCustomReferenceWidgetAsyncRouteProviderPlugin;
use SprykerShop\Yves\OrderCustomReferenceWidget\Plugin\Router\OrderCustomReferenceWidgetRouteProviderPlugin;
use SprykerShop\Yves\PaymentAppWidget\Plugin\Router\PaymentAppWidgetRouteProviderPlugin;
use SprykerShop\Yves\PaymentPage\Plugin\Router\PaymentPageRouteProviderPlugin;
use SprykerShop\Yves\PriceWidget\Plugin\Router\PriceWidgetRouteProviderPlugin;
use SprykerShop\Yves\ProductComparisonPage\Plugin\Router\ProductComparisonPageRouteProviderPlugin;
use SprykerShop\Yves\ProductConfiguratorGatewayPage\Plugin\Router\ProductConfiguratorGatewayPageRouteProviderPlugin;
use SprykerShop\Yves\ProductNewPage\Plugin\Router\ProductNewPageRouteProviderPlugin;
use SprykerShop\Yves\ProductReviewWidget\Plugin\Router\ProductReviewWidgetRouteProviderPlugin;
use SprykerShop\Yves\ProductSearchWidget\Plugin\Router\ProductSearchWidgetRouteProviderPlugin;
use SprykerShop\Yves\ProductSetListPage\Plugin\Router\ProductSetListPageRouteProviderPlugin;
use SprykerShop\Yves\SalesOrderAmendmentWidget\Plugin\Router\SalesOrderAmendmentWidgetRouteProviderPlugin;
use SprykerShop\Yves\SalesReturnPage\Plugin\Router\SalesReturnPageRouteProviderPlugin;
use SprykerShop\Yves\StorageRouter\Plugin\Router\StorageRouterPlugin;
use SprykerShop\Yves\WishlistPage\Plugin\Router\WishlistPageRouteProviderPlugin;

class RouterDependencyProvider extends SprykerRouterDependencyProvider
{
    /**
     * @return array<\Spryker\Yves\RouterExtension\Dependency\Plugin\RouterPluginInterface>
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
     * @return array<\Spryker\Yves\RouterExtension\Dependency\Plugin\RouteProviderPluginInterface>
     */
    protected function getRouteProvider(): array
    {
        return [
            new ErrorPageRouteProviderPlugin(),
            new HomePageRouteProviderPlugin(),
            new CheckoutPageRouteProviderPlugin(),
            new CustomerPageRouteProviderPlugin(),
            new NewsletterPageRouteProviderPlugin(),
            new CartPageRouteProviderPlugin(),
            new WishlistPageRouteProviderPlugin(),
            new HealthCheckRouteProviderPlugin(),
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
            new AgentPageRouteProviderPlugin(), #AgentFeature
            new AgentWidgetRouteProviderPlugin(), #AgentFeature
            new FileManagerWidgetRouteProviderPlugin(),
            new CmsSearchPageRouteProviderPlugin(), #CmsSearchPageFeature
            new ProductSearchWidgetRouteProviderPlugin(),
            new AvailabilityNotificationWidgetRouteProviderPlugin(),
            new AvailabilityNotificationPageRouteProviderPlugin(),
            new ConfigurableBundleWidgetRouteProviderPlugin(),
            new ConfigurableBundleNoteWidgetRouteProviderPlugin(),
            new ConfigurableBundlePageRouteProviderPlugin(),
            new OrderCustomReferenceWidgetRouteProviderPlugin(),
            new SalesReturnPageRouteProviderPlugin(),
            new OrderCancelWidgetRouteProviderPlugin(),
            new PaymentPageRouteProviderPlugin(),
            new ProductConfiguratorGatewayPageRouteProviderPlugin(),
            new CartCodeAsyncWidgetRouteProviderPlugin(),
            new CartNoteWidgetAsyncRouteProviderPlugin(),
            new CartPageAsyncRouteProviderPlugin(),
            new ConfigurableBundleNoteWidgetAsyncRouteProviderPlugin(),
            new ConfigurableBundleWidgetAsyncRouteProviderPlugin(),
            new OrderCustomReferenceWidgetAsyncRouteProviderPlugin(),
            new ProductComparisonPageRouteProviderPlugin(),
            new PaymentAppWidgetRouteProviderPlugin(),
            new CustomerDataChangeRequestRouteProviderPlugin(),
            new MultiFactorAuthCustomerRouteProviderPlugin(),
            new MultiFactorAuthAgentRouteProviderPlugin(),
            new SitemapRouteProviderPlugin(),
            new CartReorderPageRouteProviderPlugin(),
            new SalesOrderAmendmentWidgetRouteProviderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Yves\RouterExtension\Dependency\Plugin\PostAddRouteManipulatorPluginInterface>
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
     * @return array<\Spryker\Yves\RouterExtension\Dependency\Plugin\RouterEnhancerPluginInterface>
     */
    protected function getRouterEnhancerPlugins(): array
    {
        return [
            new StorePrefixRouterEnhancerPlugin(),
            new LanguagePrefixRouterEnhancerPlugin(),
        ];
    }
}
