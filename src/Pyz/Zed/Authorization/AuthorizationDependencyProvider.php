<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Authorization;

use Spryker\Zed\ApiKeyAuthorizationConnector\Communication\Plugin\Authorization\ApiKeyAuthorizationStrategyPlugin;
use Spryker\Zed\Authorization\AuthorizationDependencyProvider as SprykerAuthorizationDependencyProvider;
use Spryker\Zed\GlueBackendApiApplicationAuthorizationConnector\Communication\Plugin\Authorization\ProtectedPathAuthorizationStrategyPlugin;
use Spryker\Zed\OauthUserConnector\Communication\Plugin\Authorization\OauthUserScopeAuthorizationStrategyPlugin;
use Spryker\Zed\OauthWarehouse\Communication\Plugin\Authorization\WarehouseTokenAuthorizationStrategyPlugin;

class AuthorizationDependencyProvider extends SprykerAuthorizationDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\AuthorizationExtension\Dependency\Plugin\AuthorizationStrategyPluginInterface>
     */
    protected function getAuthorizationStrategyPlugins(): array
    {
        return [
            new ProtectedPathAuthorizationStrategyPlugin(),
            new ApiKeyAuthorizationStrategyPlugin(),
            new WarehouseTokenAuthorizationStrategyPlugin(),
            new OauthUserScopeAuthorizationStrategyPlugin(),
        ];
    }
}
