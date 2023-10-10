<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\OauthBackendApi;

use Spryker\Glue\OauthBackendApi\OauthBackendApiDependencyProvider as SprykerOauthBackendApiDependencyProvider;
use Spryker\Glue\WarehouseOauthBackendApi\Plugin\OauthBackendApi\WarehouseUserRequestValidationPreCheckerPlugin;

/**
 * @method \Spryker\Glue\OauthBackendApi\OauthBackendApiConfig getConfig()
 */
class OauthBackendApiDependencyProvider extends SprykerOauthBackendApiDependencyProvider
{
    /**
     * @return list<\Spryker\Glue\OauthBackendApiExtension\Dependency\Plugin\UserRequestValidationPreCheckerPluginInterface>
     */
    protected function getUserRequestValidationPreCheckerPlugins(): array
    {
        return [
            new WarehouseUserRequestValidationPreCheckerPlugin(),
        ];
    }
}
