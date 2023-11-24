<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\GlueBackendApiApplication;

use Spryker\Glue\DynamicEntityBackendApi\Plugin\GlueApplication\DynamicEntityRouteProviderPlugin;
use Spryker\Glue\EventDispatcher\Plugin\GlueBackendApiApplication\EventDispatcherApplicationPlugin;
use Spryker\Glue\GlueBackendApiApplication\GlueBackendApiApplicationDependencyProvider as SprykerGlueBackendApiApplicationDependencyProvider;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\ApplicationIdentifierRequestBuilderPlugin;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\LocaleRequestBuilderPlugin;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\RequestCorsValidatorPlugin;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\ScopeRequestAfterRoutingValidatorPlugin;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\SecurityHeaderResponseFormatterPlugin;
use Spryker\Glue\GlueBackendApiApplication\Plugin\GlueApplication\StrictTransportSecurityHeaderResponseFormatterPlugin;
use Spryker\Glue\GlueBackendApiApplicationAuthorizationConnector\Plugin\GlueBackendApiApplication\AuthorizationRequestAfterRoutingValidatorPlugin;
use Spryker\Glue\Http\Plugin\Application\HttpApplicationPlugin;
use Spryker\Glue\OauthBackendApi\Plugin\AccessTokenValidatorPlugin;
use Spryker\Glue\OauthBackendApi\Plugin\GlueApplication\OauthBackendApiTokenResource;
use Spryker\Glue\OauthBackendApi\Plugin\GlueApplication\UserRequestValidatorPlugin;
use Spryker\Glue\OauthBackendApi\Plugin\GlueBackendApiApplication\UserRequestBuilderPlugin;
use Spryker\Glue\PickingListsBackendApi\Plugin\GlueBackendApiApplication\PickingListItemsBackendResourcePlugin;
use Spryker\Glue\PickingListsBackendApi\Plugin\GlueBackendApiApplication\PickingListsBackendResourcePlugin;
use Spryker\Glue\PickingListsBackendApi\Plugin\GlueBackendApiApplication\PickingListStartPickingBackendResourcePlugin;
use Spryker\Glue\PushNotificationsBackendApi\Plugin\GlueBackendApiApplication\PushNotificationProvidersBackendResourcePlugin;
use Spryker\Glue\PushNotificationsBackendApi\Plugin\GlueBackendApiApplication\PushNotificationSubscriptionsBackendResourcePlugin;
use Spryker\Glue\Router\Plugin\Application\RouterApplicationPlugin;
use Spryker\Glue\StoresRestApi\Plugin\Application\StoreHttpHeaderApplicationPlugin;
use Spryker\Glue\WarehouseOauthBackendApi\Plugin\GlueBackendApiApplication\WarehouseRequestBuilderPlugin;
use Spryker\Glue\WarehouseOauthBackendApi\Plugin\GlueBackendApiApplication\WarehouseRequestValidatorPlugin;
use Spryker\Glue\WarehouseOauthBackendApi\Plugin\GlueBackendApiApplication\WarehouseTokensBackendResourcePlugin;
use Spryker\Glue\WarehouseUsersBackendApi\Plugin\GlueBackendApiApplication\WarehouseUserAssignmentsBackendResourcePlugin;
use Spryker\Zed\Propel\Communication\Plugin\Application\PropelApplicationPlugin;

class GlueBackendApiApplicationDependencyProvider extends SprykerGlueBackendApiApplicationDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface>
     */
    protected function getApplicationPlugins(): array
    {
        return [
            new HttpApplicationPlugin(),
            new PropelApplicationPlugin(),
            new StoreHttpHeaderApplicationPlugin(),
            new RouterApplicationPlugin(),
            new EventDispatcherApplicationPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RequestBuilderPluginInterface>
     */
    protected function getRequestBuilderPlugins(): array
    {
        return [
            new ApplicationIdentifierRequestBuilderPlugin(),
            new LocaleRequestBuilderPlugin(),
            new UserRequestBuilderPlugin(),
            new WarehouseRequestBuilderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RequestValidatorPluginInterface>
     */
    protected function getRequestValidatorPlugins(): array
    {
        return [
            new AccessTokenValidatorPlugin(),
            new UserRequestValidatorPlugin(),
            new WarehouseRequestValidatorPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RequestAfterRoutingValidatorPluginInterface>
     */
    protected function getRequestAfterRoutingValidatorPlugins(): array
    {
        return [
            new RequestCorsValidatorPlugin(),
            new ScopeRequestAfterRoutingValidatorPlugin(),
            new AuthorizationRequestAfterRoutingValidatorPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResponseFormatterPluginInterface>
     */
    protected function getResponseFormatterPlugins(): array
    {
        return [
            new SecurityHeaderResponseFormatterPlugin(),
            new StrictTransportSecurityHeaderResponseFormatterPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceInterface>
     */
    protected function getResourcePlugins(): array
    {
        return [
            new OauthBackendApiTokenResource(),
            new WarehouseTokensBackendResourcePlugin(),
            new PushNotificationSubscriptionsBackendResourcePlugin(),
            new PushNotificationProvidersBackendResourcePlugin(),
            new PickingListsBackendResourcePlugin(),
            new PickingListStartPickingBackendResourcePlugin(),
            new PickingListItemsBackendResourcePlugin(),
            new WarehouseUserAssignmentsBackendResourcePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RouteProviderPluginInterface>
     */
    protected function getRouteProviderPlugins(): array
    {
        return [
            new DynamicEntityRouteProviderPlugin(),
        ];
    }
}
