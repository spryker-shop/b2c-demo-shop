<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\GlueApplication;

use Spryker\Glue\AgentAuthRestApi\Plugin\GlueApplication\AgentAccessTokenRestRequestValidatorPlugin;
use Spryker\Glue\AgentAuthRestApi\Plugin\GlueApplication\AgentAccessTokenRestUserFinderPlugin;
use Spryker\Glue\AgentAuthRestApi\Plugin\GlueApplication\AgentAccessTokensResourceRoutePlugin;
use Spryker\Glue\AgentAuthRestApi\Plugin\GlueApplication\AgentCustomerImpersonationAccessTokensResourceRoutePlugin;
use Spryker\Glue\AgentAuthRestApi\Plugin\GlueApplication\AgentCustomerSearchResourceRoutePlugin;
use Spryker\Glue\AgentAuthRestApi\Plugin\GlueApplication\AgentRestUserValidatorPlugin;
use Spryker\Glue\AlternativeProductsRestApi\Plugin\GlueApplication\AbstractAlternativeProductsResourceRoutePlugin;
use Spryker\Glue\AlternativeProductsRestApi\Plugin\GlueApplication\ConcreteAlternativeProductsResourceRoutePlugin;
use Spryker\Glue\AuthRestApi\Plugin\AccessTokensResourceRoutePlugin;
use Spryker\Glue\AuthRestApi\Plugin\FormatAuthenticationErrorResponseHeadersPlugin;
use Spryker\Glue\AuthRestApi\Plugin\GlueApplication\AccessTokenRestRequestValidatorPlugin;
use Spryker\Glue\AuthRestApi\Plugin\GlueApplication\FormattedControllerBeforeActionValidateAccessTokenPlugin;
use Spryker\Glue\AuthRestApi\Plugin\GlueApplication\SimultaneousAuthenticationRestRequestValidatorPlugin;
use Spryker\Glue\AuthRestApi\Plugin\GlueApplication\TokenResourceRoutePlugin;
use Spryker\Glue\AuthRestApi\Plugin\RefreshTokensResourceRoutePlugin;
use Spryker\Glue\AuthRestApi\Plugin\RestUserFinderByAccessTokenPlugin;
use Spryker\Glue\AvailabilityNotificationsRestApi\Plugin\GlueApplication\AvailabilityNotificationsResourceRoutePlugin;
use Spryker\Glue\AvailabilityNotificationsRestApi\Plugin\GlueApplication\CustomerAvailabilityNotificationsResourceRoutePlugin;
use Spryker\Glue\AvailabilityNotificationsRestApi\Plugin\GlueApplication\MyAvailabilityNotificationsResourceRoutePlugin;
use Spryker\Glue\CartCodesRestApi\Plugin\GlueApplication\CartCodesResourceRoutePlugin;
use Spryker\Glue\CartCodesRestApi\Plugin\GlueApplication\CartRuleByQuoteResourceRelationshipPlugin;
use Spryker\Glue\CartCodesRestApi\Plugin\GlueApplication\CartVouchersResourceRoutePlugin;
use Spryker\Glue\CartCodesRestApi\Plugin\GlueApplication\GuestCartCodesResourceRoutePlugin;
use Spryker\Glue\CartCodesRestApi\Plugin\GlueApplication\GuestCartVouchersResourceRoutePlugin;
use Spryker\Glue\CartCodesRestApi\Plugin\GlueApplication\VoucherByQuoteResourceRelationshipPlugin;
use Spryker\Glue\CartsRestApi\CartsRestApiConfig;
use Spryker\Glue\CartsRestApi\Plugin\ControllerBeforeAction\SetAnonymousCustomerIdControllerBeforeActionPlugin;
use Spryker\Glue\CartsRestApi\Plugin\GlueApplication\CartByRestCheckoutDataResourceRelationshipPlugin;
use Spryker\Glue\CartsRestApi\Plugin\GlueApplication\CartItemsByQuoteResourceRelationshipPlugin;
use Spryker\Glue\CartsRestApi\Plugin\GlueApplication\GuestCartByRestCheckoutDataResourceRelationshipPlugin;
use Spryker\Glue\CartsRestApi\Plugin\GlueApplication\GuestCartItemsByQuoteResourceRelationshipPlugin;
use Spryker\Glue\CartsRestApi\Plugin\ResourceRoute\CartItemsResourceRoutePlugin;
use Spryker\Glue\CartsRestApi\Plugin\ResourceRoute\CartsResourceRoutePlugin;
use Spryker\Glue\CartsRestApi\Plugin\ResourceRoute\CustomerCartsResourceRoutePlugin;
use Spryker\Glue\CartsRestApi\Plugin\ResourceRoute\GuestCartItemsResourceRoutePlugin;
use Spryker\Glue\CartsRestApi\Plugin\ResourceRoute\GuestCartsResourceRoutePlugin;
use Spryker\Glue\CartsRestApi\Plugin\Validator\AnonymousCustomerUniqueIdValidatorPlugin;
use Spryker\Glue\CatalogSearchProductsResourceRelationship\Plugin\CatalogSearchAbstractProductsResourceRelationshipPlugin;
use Spryker\Glue\CatalogSearchProductsResourceRelationship\Plugin\CatalogSearchSuggestionsAbstractProductsResourceRelationshipPlugin;
use Spryker\Glue\CatalogSearchRestApi\CatalogSearchRestApiConfig;
use Spryker\Glue\CatalogSearchRestApi\Plugin\CatalogSearchRequestParametersIntegerRestRequestValidatorPlugin;
use Spryker\Glue\CatalogSearchRestApi\Plugin\CatalogSearchResourceRoutePlugin;
use Spryker\Glue\CatalogSearchRestApi\Plugin\CatalogSearchSuggestionsResourceRoutePlugin;
use Spryker\Glue\CategoriesRestApi\Plugin\CategoriesResourceRoutePlugin;
use Spryker\Glue\CategoriesRestApi\Plugin\CategoryResourceRoutePlugin;
use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig;
use Spryker\Glue\CheckoutRestApi\Plugin\GlueApplication\CheckoutDataResourcePlugin;
use Spryker\Glue\CheckoutRestApi\Plugin\GlueApplication\CheckoutResourcePlugin;
use Spryker\Glue\CmsPagesContentBannersResourceRelationship\Plugin\GlueApplication\ContentBannerByCmsPageResourceRelationshipPlugin;
use Spryker\Glue\CmsPagesContentProductAbstractListsResourceRelationship\Plugin\GlueApplication\ContentProductAbstractListByCmsPageResourceRelationshipPlugin;
use Spryker\Glue\CmsPagesRestApi\CmsPagesRestApiConfig;
use Spryker\Glue\CmsPagesRestApi\Plugin\GlueApplication\CmsPagesResourceRoutePlugin;
use Spryker\Glue\ConfigurableBundleCartsRestApi\Plugin\GlueApplication\ConfiguredBundlesResourceRoutePlugin;
use Spryker\Glue\ConfigurableBundleCartsRestApi\Plugin\GlueApplication\GuestConfiguredBundlesResourceRoutePlugin;
use Spryker\Glue\ConfigurableBundlesProductsResourceRelationship\ConfigurableBundlesProductsResourceRelationshipConfig;
use Spryker\Glue\ConfigurableBundlesProductsResourceRelationship\Plugin\GlueApplication\ProductConcreteByConfigurableBundleTemplateSlotResourceRelationshipPlugin;
use Spryker\Glue\ConfigurableBundlesRestApi\ConfigurableBundlesRestApiConfig;
use Spryker\Glue\ConfigurableBundlesRestApi\Plugin\GlueApplication\ConfigurableBundleTemplateImageSetByConfigurableBundleTemplateResourceRelationshipPlugin;
use Spryker\Glue\ConfigurableBundlesRestApi\Plugin\GlueApplication\ConfigurableBundleTemplateSlotByConfigurableBundleTemplateResourceRelationshipPlugin;
use Spryker\Glue\ConfigurableBundlesRestApi\Plugin\GlueApplication\ConfigurableBundleTemplatesResourceRoutePlugin;
use Spryker\Glue\ContentBannersRestApi\Plugin\ContentBannerResourceRoutePlugin;
use Spryker\Glue\ContentProductAbstractListsRestApi\ContentProductAbstractListsRestApiConfig;
use Spryker\Glue\ContentProductAbstractListsRestApi\Plugin\GlueApplication\AbstractProductsResourceRoutePlugin as ContentProductAbstractListAbstractProductsResourceRoutePlugin;
use Spryker\Glue\ContentProductAbstractListsRestApi\Plugin\GlueApplication\ContentProductAbstractListsResourceRoutePlugin;
use Spryker\Glue\ContentProductAbstractListsRestApi\Plugin\GlueApplication\ProductAbstractByContentProductAbstractListResourceRelationshipPlugin;
use Spryker\Glue\CustomerAccessRestApi\Plugin\GlueApplication\CustomerAccessFormatRequestPlugin;
use Spryker\Glue\CustomerAccessRestApi\Plugin\GlueApplication\CustomerAccessResourceRoutePlugin;
use Spryker\Glue\CustomersRestApi\CustomersRestApiConfig;
use Spryker\Glue\CustomersRestApi\Plugin\AddressesResourceRoutePlugin;
use Spryker\Glue\CustomersRestApi\Plugin\CustomerForgottenPasswordResourceRoutePlugin;
use Spryker\Glue\CustomersRestApi\Plugin\CustomerPasswordResourceRoutePlugin;
use Spryker\Glue\CustomersRestApi\Plugin\CustomerRestorePasswordResourceRoutePlugin;
use Spryker\Glue\CustomersRestApi\Plugin\CustomersResourceRoutePlugin;
use Spryker\Glue\CustomersRestApi\Plugin\CustomersToAddressesRelationshipPlugin;
use Spryker\Glue\CustomersRestApi\Plugin\GlueApplication\AddressByCheckoutDataResourceRelationshipPlugin;
use Spryker\Glue\CustomersRestApi\Plugin\GlueApplication\CustomerConfirmationResourceRoutePlugin;
use Spryker\Glue\CustomersRestApi\Plugin\SetCustomerBeforeActionPlugin;
use Spryker\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use Spryker\Glue\DiscountPromotionsRestApi\Plugin\GlueApplication\PromotionItemByQuoteTransferResourceRelationshipPlugin;
use Spryker\Glue\EntityTagsRestApi\Plugin\GlueApplication\EntityTagFormatResponseHeadersPlugin;
use Spryker\Glue\EntityTagsRestApi\Plugin\GlueApplication\EntityTagRestRequestValidatorPlugin;
use Spryker\Glue\EventDispatcher\Plugin\Application\EventDispatcherApplicationPlugin;
use Spryker\Glue\GiftCardsRestApi\Plugin\GlueApplication\GiftCardByQuoteResourceRelationshipPlugin;
use Spryker\Glue\GlueApplication\GlueApplicationDependencyProvider as SprykerGlueApplicationDependencyProvider;
use Spryker\Glue\GlueApplication\Plugin\Application\GlueApplicationApplicationPlugin;
use Spryker\Glue\GlueApplication\Plugin\GlueApplication\CorsValidateHttpRequestPlugin;
use Spryker\Glue\GlueApplication\Plugin\GlueApplication\FallbackStorefrontApiGlueApplicationBootstrapPlugin;
use Spryker\Glue\GlueApplication\Plugin\GlueApplication\HeadersValidateHttpRequestPlugin;
use Spryker\Glue\GlueApplication\Plugin\GlueApplication\PaginationParametersValidateHttpRequestPlugin;
use Spryker\Glue\GlueApplicationAuthorizationConnector\Plugin\GlueApplication\AuthorizationRestUserValidatorPlugin;
use Spryker\Glue\GlueApplicationAuthorizationConnector\Plugin\GlueApplication\AuthorizationRouterParameterExpanderPlugin;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRelationshipCollectionInterface;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\BackendApiGlueApplicationBootstrapPlugin;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\BackendRouterProviderPlugin;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\ControllerConfigurationCacheCollectorPlugin as BackendControllerConfigurationCacheCollectorPlugin;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\CustomRouteRoutesProviderPlugin as BackendCustomRouteRoutesProviderPlugin;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\ResourcesProviderPlugin as BackendResourcesProviderPlugin;
use Spryker\Glue\GlueBackendApiApplicationAuthorizationConnector\Plugin\GlueApplication\IsProtectedTableColumnExpanderPlugin as BackendIsProtectedTableColumnExpanderPlugin;
use Spryker\Glue\GlueJsonApiConvention\Plugin\GlueApplication\JsonApiConventionPlugin;
use Spryker\Glue\GlueStorefrontApiApplication\Plugin\GlueApplication\ControllerConfigurationCacheCollectorPlugin as StorefrontControllerConfigurationCacheCollectorPlugin;
use Spryker\Glue\GlueStorefrontApiApplication\Plugin\GlueApplication\CustomRouteRoutesProviderPlugin as StorefrontCustomRouteRoutesProviderPlugin;
use Spryker\Glue\GlueStorefrontApiApplication\Plugin\GlueApplication\ResourcesProviderPlugin as StorefrontResourcesProviderPlugin;
use Spryker\Glue\GlueStorefrontApiApplication\Plugin\GlueApplication\StorefrontApiGlueApplicationBootstrapPlugin;
use Spryker\Glue\GlueStorefrontApiApplication\Plugin\GlueApplication\StorefrontRouterProviderPlugin;
use Spryker\Glue\GlueStorefrontApiApplicationAuthorizationConnector\Plugin\GlueApplication\IsProtectedTableColumnExpanderPlugin as StorefrontIsProtectedTableColumnExpanderPlugin;
use Spryker\Glue\HealthCheck\Plugin\HealthCheckResourceRoutePlugin;
use Spryker\Glue\Http\Plugin\Application\HttpApplicationPlugin;
use Spryker\Glue\Locale\Plugin\Application\LocaleApplicationPlugin;
use Spryker\Glue\NavigationsCategoryNodesResourceRelationship\Plugin\GlueApplication\CategoryNodeByResourceIdResourceRelationshipPlugin;
use Spryker\Glue\NavigationsRestApi\NavigationsRestApiConfig;
use Spryker\Glue\NavigationsRestApi\Plugin\ResourceRoute\NavigationsResourceRoutePlugin;
use Spryker\Glue\OrderPaymentsRestApi\Plugin\OrderPaymentsResourceRoutePlugin;
use Spryker\Glue\OrdersRestApi\OrdersRestApiConfig;
use Spryker\Glue\OrdersRestApi\Plugin\CustomerOrdersResourceRoutePlugin;
use Spryker\Glue\OrdersRestApi\Plugin\OrderItemByResourceIdResourceRelationshipPlugin;
use Spryker\Glue\OrdersRestApi\Plugin\OrderRelationshipByOrderReferencePlugin;
use Spryker\Glue\OrdersRestApi\Plugin\OrdersResourceRoutePlugin;
use Spryker\Glue\PaymentsRestApi\Plugin\GlueApplication\PaymentMethodsByCheckoutDataResourceRelationshipPlugin;
use Spryker\Glue\ProductAttributesRestApi\Plugin\GlueApplication\ProductManagementAttributesResourceRoutePlugin;
use Spryker\Glue\ProductAvailabilitiesRestApi\Plugin\AbstractProductAvailabilitiesRoutePlugin;
use Spryker\Glue\ProductAvailabilitiesRestApi\Plugin\ConcreteProductAvailabilitiesRoutePlugin;
use Spryker\Glue\ProductAvailabilitiesRestApi\Plugin\GlueApplication\AbstractProductAvailabilitiesByResourceIdResourceRelationshipPlugin;
use Spryker\Glue\ProductAvailabilitiesRestApi\Plugin\GlueApplication\ConcreteProductAvailabilitiesByResourceIdResourceRelationshipPlugin;
use Spryker\Glue\ProductBundleCartsRestApi\Plugin\GlueApplication\BundledItemByQuoteResourceRelationshipPlugin;
use Spryker\Glue\ProductBundleCartsRestApi\Plugin\GlueApplication\BundleItemByQuoteResourceRelationshipPlugin;
use Spryker\Glue\ProductBundleCartsRestApi\Plugin\GlueApplication\GuestBundleItemByQuoteResourceRelationshipPlugin;
use Spryker\Glue\ProductBundleCartsRestApi\ProductBundleCartsRestApiConfig;
use Spryker\Glue\ProductBundlesRestApi\Plugin\GlueApplication\BundledProductByProductConcreteSkuResourceRelationshipPlugin;
use Spryker\Glue\ProductBundlesRestApi\Plugin\GlueApplication\ConcreteProductsBundledProductsResourceRoutePlugin;
use Spryker\Glue\ProductBundlesRestApi\ProductBundlesRestApiConfig;
use Spryker\Glue\ProductConfigurationsRestApi\Plugin\GlueApplication\CartItemProductConfigurationRestRequestValidatorPlugin;
use Spryker\Glue\ProductImageSetsRestApi\Plugin\AbstractProductImageSetsRoutePlugin;
use Spryker\Glue\ProductImageSetsRestApi\Plugin\ConcreteProductImageSetsRoutePlugin;
use Spryker\Glue\ProductImageSetsRestApi\Plugin\Relationship\AbstractProductsProductImageSetsResourceRelationshipPlugin;
use Spryker\Glue\ProductImageSetsRestApi\Plugin\Relationship\ConcreteProductsProductImageSetsResourceRelationshipPlugin;
use Spryker\Glue\ProductLabelsRestApi\Plugin\GlueApplication\ProductLabelByProductConcreteSkuResourceRelationshipPlugin;
use Spryker\Glue\ProductLabelsRestApi\Plugin\GlueApplication\ProductLabelsRelationshipByResourceIdPlugin;
use Spryker\Glue\ProductLabelsRestApi\Plugin\GlueApplication\ProductLabelsResourceRoutePlugin;
use Spryker\Glue\ProductOptionsRestApi\Plugin\GlueApplication\ProductOptionsByProductAbstractSkuResourceRelationshipPlugin;
use Spryker\Glue\ProductOptionsRestApi\Plugin\GlueApplication\ProductOptionsByProductConcreteSkuResourceRelationshipPlugin;
use Spryker\Glue\ProductPricesRestApi\Plugin\AbstractProductPricesRoutePlugin;
use Spryker\Glue\ProductPricesRestApi\Plugin\ConcreteProductPricesRoutePlugin;
use Spryker\Glue\ProductPricesRestApi\Plugin\GlueApplication\AbstractProductPricesByResourceIdResourceRelationshipPlugin;
use Spryker\Glue\ProductPricesRestApi\Plugin\GlueApplication\ConcreteProductPricesByResourceIdResourceRelationshipPlugin;
use Spryker\Glue\ProductPricesRestApi\Plugin\GlueApplication\CurrencyParameterValidatorPlugin;
use Spryker\Glue\ProductPricesRestApi\Plugin\GlueApplication\PriceModeParameterValidatorPlugin;
use Spryker\Glue\ProductPricesRestApi\Plugin\GlueApplication\SetPriceModeBeforeActionPlugin;
use Spryker\Glue\ProductReviewsRestApi\Plugin\GlueApplication\AbstractProductsProductReviewsResourceRoutePlugin;
use Spryker\Glue\ProductReviewsRestApi\Plugin\GlueApplication\ProductReviewsRelationshipByProductAbstractSkuPlugin;
use Spryker\Glue\ProductReviewsRestApi\Plugin\GlueApplication\ProductReviewsRelationshipByProductConcreteSkuPlugin;
use Spryker\Glue\ProductsCategoriesResourceRelationship\Plugin\AbstractProductsCategoriesResourceRelationshipPlugin;
use Spryker\Glue\ProductsRestApi\Plugin\AbstractProductsResourceRoutePlugin;
use Spryker\Glue\ProductsRestApi\Plugin\ConcreteProductsResourceRoutePlugin;
use Spryker\Glue\ProductsRestApi\Plugin\GlueApplication\ConcreteProductBySkuResourceRelationshipPlugin;
use Spryker\Glue\ProductsRestApi\Plugin\GlueApplication\ConcreteProductsByProductConcreteIdsResourceRelationshipPlugin;
use Spryker\Glue\ProductsRestApi\Plugin\GlueApplication\ProductAbstractByProductAbstractSkuResourceRelationshipPlugin;
use Spryker\Glue\ProductsRestApi\Plugin\GlueApplication\ProductAbstractBySkuResourceRelationshipPlugin;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;
use Spryker\Glue\ProductTaxSetsRestApi\Plugin\GlueApplication\ProductTaxSetByProductAbstractSkuResourceRelationshipPlugin;
use Spryker\Glue\ProductTaxSetsRestApi\Plugin\GlueApplication\ProductTaxSetsResourceRoutePlugin;
use Spryker\Glue\RelatedProductsRestApi\Plugin\GlueApplication\RelatedProductsResourceRoutePlugin;
use Spryker\Glue\RestRequestValidator\Plugin\ValidateRestRequestAttributesPlugin;
use Spryker\Glue\Router\Plugin\Application\RouterApplicationPlugin;
use Spryker\Glue\SalesReturnsRestApi\Plugin\ReturnItemByReturnResourceRelationshipPlugin;
use Spryker\Glue\SalesReturnsRestApi\Plugin\ReturnReasonsResourceRoutePlugin;
use Spryker\Glue\SalesReturnsRestApi\Plugin\ReturnsResourceRoutePlugin;
use Spryker\Glue\SalesReturnsRestApi\SalesReturnsRestApiConfig;
use Spryker\Glue\SecurityBlockerRestApi\Plugin\GlueApplication\SecurityBlockerAgentControllerAfterActionPlugin;
use Spryker\Glue\SecurityBlockerRestApi\Plugin\GlueApplication\SecurityBlockerAgentRestRequestValidatorPlugin;
use Spryker\Glue\SecurityBlockerRestApi\Plugin\GlueApplication\SecurityBlockerCustomerControllerAfterActionPlugin;
use Spryker\Glue\SecurityBlockerRestApi\Plugin\GlueApplication\SecurityBlockerCustomerRestRequestValidatorPlugin;
use Spryker\Glue\Session\Plugin\Application\SessionApplicationPlugin;
use Spryker\Glue\ShipmentsRestApi\Plugin\GlueApplication\OrderShipmentByOrderResourceRelationshipPlugin;
use Spryker\Glue\ShipmentsRestApi\Plugin\GlueApplication\ShipmentMethodsByShipmentResourceRelationshipPlugin;
use Spryker\Glue\ShipmentsRestApi\Plugin\GlueApplication\ShipmentsByCheckoutDataResourceRelationshipPlugin;
use Spryker\Glue\ShipmentsRestApi\ShipmentsRestApiConfig;
use Spryker\Glue\StoresApi\Plugin\GlueStorefrontApiApplication\StoreApplicationPlugin;
use Spryker\Glue\StoresRestApi\Plugin\StoresResourceRoutePlugin;
use Spryker\Glue\UpSellingProductsRestApi\Plugin\GlueApplication\CartUpSellingProductsResourceRoutePlugin;
use Spryker\Glue\UpSellingProductsRestApi\Plugin\GlueApplication\GuestCartUpSellingProductsResourceRoutePlugin;
use Spryker\Glue\UrlsRestApi\Plugin\GlueApplication\UrlResolverResourceRoutePlugin;
use Spryker\Glue\WishlistsRestApi\Plugin\WishlistItemsResourceRoutePlugin;
use Spryker\Glue\WishlistsRestApi\Plugin\WishlistRelationshipByResourceIdPlugin;
use Spryker\Glue\WishlistsRestApi\Plugin\WishlistsResourceRoutePlugin;
use Spryker\Glue\WishlistsRestApi\WishlistsRestApiConfig;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class GlueApplicationDependencyProvider extends SprykerGlueApplicationDependencyProvider
{
    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface>
     */
    protected function getResourceRoutePlugins(): array
    {
        return [
            new ConcreteProductsResourceRoutePlugin(),
            new AccessTokensResourceRoutePlugin(),
            new RefreshTokensResourceRoutePlugin(),
            new CatalogSearchResourceRoutePlugin(),
            new StoresResourceRoutePlugin(),
            new CatalogSearchSuggestionsResourceRoutePlugin(),
            new ConcreteProductAvailabilitiesRoutePlugin(),
            new AbstractProductAvailabilitiesRoutePlugin(),
            new CategoriesResourceRoutePlugin(),
            new CategoryResourceRoutePlugin(),
            new CustomersResourceRoutePlugin(),
            new CustomerForgottenPasswordResourceRoutePlugin(),
            new CustomerRestorePasswordResourceRoutePlugin(),
            new AbstractProductsResourceRoutePlugin(),
            new AbstractProductPricesRoutePlugin(),
            new ConcreteProductPricesRoutePlugin(),
            new CartsResourceRoutePlugin(),
            new CartItemsResourceRoutePlugin(),
            new AbstractProductImageSetsRoutePlugin(),
            new ConcreteProductImageSetsRoutePlugin(),
            new OrdersResourceRoutePlugin(),
            new WishlistsResourceRoutePlugin(),
            new WishlistItemsResourceRoutePlugin(),
            new CustomerPasswordResourceRoutePlugin(),
            new AddressesResourceRoutePlugin(),
            new GuestCartsResourceRoutePlugin(),
            new GuestCartItemsResourceRoutePlugin(),
            new ProductLabelsResourceRoutePlugin(),
            new CheckoutDataResourcePlugin(),
            new CheckoutResourcePlugin(),
            new NavigationsResourceRoutePlugin(),
            new RelatedProductsResourceRoutePlugin(),
            new CartUpSellingProductsResourceRoutePlugin(),
            new GuestCartUpSellingProductsResourceRoutePlugin(),
            new ConcreteAlternativeProductsResourceRoutePlugin(),
            new AbstractAlternativeProductsResourceRoutePlugin(),
            new ProductTaxSetsResourceRoutePlugin(),
            new OrderPaymentsResourceRoutePlugin(),
            new ContentBannerResourceRoutePlugin(),
            new UrlResolverResourceRoutePlugin(),
            new CustomerAccessResourceRoutePlugin(),
            new AbstractProductsProductReviewsResourceRoutePlugin(),
            new HealthCheckResourceRoutePlugin(),
            new CartVouchersResourceRoutePlugin(),
            new GuestCartVouchersResourceRoutePlugin(),
            new ReturnReasonsResourceRoutePlugin(),
            new ReturnsResourceRoutePlugin(),
            new CartCodesResourceRoutePlugin(),
            new GuestCartCodesResourceRoutePlugin(),
            new CmsPagesResourceRoutePlugin(),
            new ContentProductAbstractListAbstractProductsResourceRoutePlugin(),
            new ContentProductAbstractListsResourceRoutePlugin(),
            new AgentAccessTokensResourceRoutePlugin(),
            new AgentCustomerImpersonationAccessTokensResourceRoutePlugin(),
            new AgentCustomerSearchResourceRoutePlugin(),
            new ConcreteProductsBundledProductsResourceRoutePlugin(),
            new ProductManagementAttributesResourceRoutePlugin(),
            new CustomerConfirmationResourceRoutePlugin(),
            new TokenResourceRoutePlugin(),
            new CustomerOrdersResourceRoutePlugin(),
            new CustomerCartsResourceRoutePlugin(),
            new AvailabilityNotificationsResourceRoutePlugin(),
            new CustomerAvailabilityNotificationsResourceRoutePlugin(),
            new ConfigurableBundleTemplatesResourceRoutePlugin(),
            new MyAvailabilityNotificationsResourceRoutePlugin(),
            new ConfiguredBundlesResourceRoutePlugin(),
            new GuestConfiguredBundlesResourceRoutePlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ValidateHttpRequestPluginInterface>
     */
    protected function getValidateHttpRequestPlugins(): array
    {
        return [
            new CorsValidateHttpRequestPlugin(),
            new PaginationParametersValidateHttpRequestPlugin(),
            new HeadersValidateHttpRequestPlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\FormattedControllerBeforeActionPluginInterface>
     */
    protected function getFormattedControllerBeforeActionTerminatePlugins(): array
    {
        return [
            new FormattedControllerBeforeActionValidateAccessTokenPlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\FormatRequestPluginInterface>
     */
    protected function getFormatRequestPlugins(): array
    {
        return [
            new CustomerAccessFormatRequestPlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ValidateRestRequestPluginInterface>
     */
    protected function getValidateRestRequestPlugins(): array
    {
        return [
            new AnonymousCustomerUniqueIdValidatorPlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RestUserValidatorPluginInterface>
     */
    protected function getRestUserValidatorPlugins(): array
    {
        return [
            new AgentRestUserValidatorPlugin(),
            new AuthorizationRestUserValidatorPlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RestRequestValidatorPluginInterface>
     */
    protected function getRestRequestValidatorPlugins(): array
    {
        return [
            new SecurityBlockerCustomerRestRequestValidatorPlugin(),
            new SecurityBlockerAgentRestRequestValidatorPlugin(),
            new AgentAccessTokenRestRequestValidatorPlugin(),
            new SimultaneousAuthenticationRestRequestValidatorPlugin(),
            new AccessTokenRestRequestValidatorPlugin(),
            new ValidateRestRequestAttributesPlugin(),
            new CurrencyParameterValidatorPlugin(),
            new PriceModeParameterValidatorPlugin(),
            new EntityTagRestRequestValidatorPlugin(),
            new CatalogSearchRequestParametersIntegerRestRequestValidatorPlugin(),
            new CartItemProductConfigurationRestRequestValidatorPlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\FormatResponseHeadersPluginInterface>
     */
    protected function getFormatResponseHeadersPlugins(): array
    {
        return [
            new FormatAuthenticationErrorResponseHeadersPlugin(),
            new EntityTagFormatResponseHeadersPlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ControllerBeforeActionPluginInterface>
     */
    protected function getControllerBeforeActionPlugins(): array
    {
        return [
            new SetAnonymousCustomerIdControllerBeforeActionPlugin(),
            new SetCustomerBeforeActionPlugin(),
            new SetPriceModeBeforeActionPlugin(),
        ];
    }

    /**
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ControllerAfterActionPluginInterface>
     */
    protected function getControllerAfterActionPlugins(): array
    {
        return [
            new SecurityBlockerCustomerControllerAfterActionPlugin(),
            new SecurityBlockerAgentControllerAfterActionPlugin(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Will be removed without replacement.
     *
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRelationshipCollectionInterface $resourceRelationshipCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRelationshipCollectionInterface
     */
    protected function getResourceRelationshipPlugins(
        ResourceRelationshipCollectionInterface $resourceRelationshipCollection,
    ): ResourceRelationshipCollectionInterface {
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
            new AbstractProductsProductImageSetsResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
            new ConcreteProductsByProductConcreteIdsResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            new ConcreteProductsProductImageSetsResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            WishlistsRestApiConfig::RESOURCE_WISHLIST_ITEMS,
            new ConcreteProductBySkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CatalogSearchRestApiConfig::RESOURCE_CATALOG_SEARCH,
            new CatalogSearchAbstractProductsResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CatalogSearchRestApiConfig::RESOURCE_CATALOG_SEARCH_SUGGESTIONS,
            new CatalogSearchSuggestionsAbstractProductsResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
            new AbstractProductAvailabilitiesByResourceIdResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            new ConcreteProductAvailabilitiesByResourceIdResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
            new AbstractProductPricesByResourceIdResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            new ConcreteProductPricesByResourceIdResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
            new AbstractProductsCategoriesResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CustomersRestApiConfig::RESOURCE_CUSTOMERS,
            new CustomersToAddressesRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CustomersRestApiConfig::RESOURCE_CUSTOMERS,
            new WishlistRelationshipByResourceIdPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
            new ProductLabelsRelationshipByResourceIdPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            new ProductLabelByProductConcreteSkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CheckoutRestApiConfig::RESOURCE_CHECKOUT,
            new OrderRelationshipByOrderReferencePlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_CART_ITEMS,
            new ConcreteProductBySkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            new ConcreteProductBySkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            NavigationsRestApiConfig::RESOURCE_NAVIGATIONS,
            new CategoryNodeByResourceIdResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
            new ProductTaxSetByProductAbstractSkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
            new ProductReviewsRelationshipByProductAbstractSkuPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            new ProductReviewsRelationshipByProductConcreteSkuPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
            new ProductOptionsByProductAbstractSkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            new ProductOptionsByProductConcreteSkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_CARTS,
            new VoucherByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS,
            new VoucherByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_CARTS,
            new CartRuleByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS,
            new CartRuleByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_CARTS,
            new CartItemsByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_CARTS,
            new PromotionItemByQuoteTransferResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS,
            new PromotionItemByQuoteTransferResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            DiscountPromotionsRestApiConfig::RESOURCE_PROMOTIONAL_ITEMS,
            new ProductAbstractBySkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
            new ShipmentsByCheckoutDataResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ShipmentsRestApiConfig::RESOURCE_SHIPMENTS,
            new ShipmentMethodsByShipmentResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
            new PaymentMethodsByCheckoutDataResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
            new AddressByCheckoutDataResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
            new CartByRestCheckoutDataResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
            new GuestCartByRestCheckoutDataResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            SalesReturnsRestApiConfig::RESOURCE_RETURNS,
            new ReturnItemByReturnResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            OrdersRestApiConfig::RESOURCE_ORDERS,
            new OrderShipmentByOrderResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            SalesReturnsRestApiConfig::RESOURCE_RETURN_ITEMS,
            new OrderItemByResourceIdResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_CARTS,
            new GiftCardByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS,
            new GiftCardByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductBundlesRestApiConfig::RESOURCE_BUNDLED_PRODUCTS,
            new ConcreteProductBySkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            new BundledProductByProductConcreteSkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            new ProductAbstractByProductAbstractSkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_CARTS,
            new BundleItemByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS,
            new GuestBundleItemByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductBundleCartsRestApiConfig::RESOURCE_BUNDLE_ITEMS,
            new BundledItemByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductBundleCartsRestApiConfig::RESOURCE_BUNDLE_ITEMS,
            new ConcreteProductBySkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ProductBundleCartsRestApiConfig::RESOURCE_BUNDLED_ITEMS,
            new ConcreteProductBySkuResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS,
            new GuestCartItemsByQuoteResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ConfigurableBundlesRestApiConfig::RESOURCE_CONFIGURABLE_BUNDLE_TEMPLATES,
            new ConfigurableBundleTemplateSlotByConfigurableBundleTemplateResourceRelationshipPlugin(),
        );

        $resourceRelationshipCollection->addRelationship(
            ConfigurableBundlesRestApiConfig::RESOURCE_CONFIGURABLE_BUNDLE_TEMPLATES,
            new ConfigurableBundleTemplateImageSetByConfigurableBundleTemplateResourceRelationshipPlugin(),
        );

        $resourceRelationshipCollection->addRelationship(
            ConfigurableBundlesProductsResourceRelationshipConfig::RESOURCE_CONFIGURABLE_BUNDLE_TEMPLATE_SLOTS,
            new ProductConcreteByConfigurableBundleTemplateSlotResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CmsPagesRestApiConfig::RESOURCE_CMS_PAGES,
            new ContentBannerByCmsPageResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            CmsPagesRestApiConfig::RESOURCE_CMS_PAGES,
            new ContentProductAbstractListByCmsPageResourceRelationshipPlugin(),
        );
        $resourceRelationshipCollection->addRelationship(
            ContentProductAbstractListsRestApiConfig::RESOURCE_CONTENT_PRODUCT_ABSTRACT_LISTS,
            new ProductAbstractByContentProductAbstractListResourceRelationshipPlugin(),
        );

        return $resourceRelationshipCollection;
    }

    /**
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RestUserFinderPluginInterface>
     */
    protected function getRestUserFinderPlugins(): array
    {
        return [
            new RestUserFinderByAccessTokenPlugin(),
            new AgentAccessTokenRestUserFinderPlugin(),
        ];
    }

    /**
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface>
     */
    protected function getApplicationPlugins(): array
    {
        return [
            new HttpApplicationPlugin(),
            new SessionApplicationPlugin(),
            new EventDispatcherApplicationPlugin(),
            new GlueApplicationApplicationPlugin(),
            new RouterApplicationPlugin(),
            new StoreApplicationPlugin(),
            new LocaleApplicationPlugin(),
        ];
    }

    /**
     * @deprecated Will be removed without replacement.
     *
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RouterParameterExpanderPluginInterface>
     */
    protected function getRouterParameterExpanderPlugins(): array
    {
        return [
            new AuthorizationRouterParameterExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\GlueApplicationBootstrapPluginInterface>
     */
    protected function getGlueApplicationBootstrapPlugins(): array
    {
        return [
            new StorefrontApiGlueApplicationBootstrapPlugin(),
            new BackendApiGlueApplicationBootstrapPlugin(),
            new FallbackStorefrontApiGlueApplicationBootstrapPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ConventionPluginInterface>
     */
    protected function getConventionPlugins(): array
    {
        return [
            new JsonApiConventionPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ControllerConfigurationCacheCollectorPluginInterface>
     */
    protected function getControllerConfigurationCacheCollectorPlugins(): array
    {
        return [
            new StorefrontControllerConfigurationCacheCollectorPlugin(),
            new BackendControllerConfigurationCacheCollectorPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ApiApplicationEndpointProviderPluginInterface>
     */
    protected function getGlueApplicationRouterProviderPlugins(): array
    {
        return [
            new BackendRouterProviderPlugin(),
            new StorefrontRouterProviderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RoutesProviderPluginInterface>
     */
    protected function getRoutesProviderPlugins(): array
    {
        return [
            new StorefrontCustomRouteRoutesProviderPlugin(),
            new BackendCustomRouteRoutesProviderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourcesProviderPluginInterface>
     */
    protected function getResourcesProviderPlugins(): array
    {
        return [
            new StorefrontResourcesProviderPlugin(),
            new BackendResourcesProviderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\TableColumnExpanderPluginInterface>
     */
    protected function getTableColumnExpanderPlugins(): array
    {
        return [
            new BackendIsProtectedTableColumnExpanderPlugin(),
            new StorefrontIsProtectedTableColumnExpanderPlugin(),
        ];
    }
}
