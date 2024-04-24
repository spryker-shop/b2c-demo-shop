<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\GlueBackendApiApplicationAuthorizationConnector;

use Spryker\Glue\ApiKeyAuthorizationConnector\Plugin\GlueBackendApiApplicationAuthorizationConnector\ApiKeyAuthorizationRequestExpanderPlugin;
use Spryker\Glue\GlueBackendApiApplicationAuthorizationConnector\GlueBackendApiApplicationAuthorizationConnectorDependencyProvider as SprykerGlueBackendApiApplicationAuthorizationConnectorDependencyProvider;
use Spryker\Glue\OauthUserConnector\Plugin\GlueBackendApiApplicationAuthorizationConnector\OauthUserScopeProtectedRouteAuthorizationConfigProviderPlugin;
use Spryker\Glue\WarehouseOauthBackendApi\Plugin\GlueBackendApiApplicationAuthorizationConnector\WarehouseAuthorizationRequestExpanderPlugin;

/**
 * @method \Spryker\Glue\GlueBackendApiApplicationAuthorizationConnector\GlueBackendApiApplicationAuthorizationConnectorConfig getConfig()
 */
class GlueBackendApiApplicationAuthorizationConnectorDependencyProvider extends SprykerGlueBackendApiApplicationAuthorizationConnectorDependencyProvider
{
    /**
     * @return list<\Spryker\Glue\GlueBackendApiApplicationAuthorizationConnectorExtension\Dependency\Plugin\AuthorizationRequestExpanderPluginInterface>
     */
    protected function getAuthorizationRequestExpanderPlugins(): array
    {
        return [
            new ApiKeyAuthorizationRequestExpanderPlugin(),
            new WarehouseAuthorizationRequestExpanderPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Glue\GlueBackendApiApplicationAuthorizationConnectorExtension\Dependency\Plugin\ProtectedRouteAuthorizationConfigProviderPluginInterface>
     */
    protected function getProtectedRouteAuthorizationConfigProviderPlugins(): array
    {
        return [
            new OauthUserScopeProtectedRouteAuthorizationConfigProviderPlugin(),
        ];
    }
}
