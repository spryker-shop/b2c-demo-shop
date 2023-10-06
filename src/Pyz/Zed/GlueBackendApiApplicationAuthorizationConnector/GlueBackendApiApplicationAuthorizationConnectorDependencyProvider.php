<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\GlueBackendApiApplicationAuthorizationConnector;

use Spryker\Glue\DynamicEntityBackendApi\Plugin\GlueBackendApiApplicationAuthorizationConnector\DynamicEntityProtectedPathCollectionExpanderPlugin;
use Spryker\Zed\GlueBackendApiApplicationAuthorizationConnector\GlueBackendApiApplicationAuthorizationConnectorDependencyProvider as SprykerGlueBackendApiApplicationAuthorizationConnectorDependencyProvider;

class GlueBackendApiApplicationAuthorizationConnectorDependencyProvider extends SprykerGlueBackendApiApplicationAuthorizationConnectorDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\GlueBackendApiApplicationAuthorizationConnectorExtension\Dependency\Plugin\ProtectedPathCollectionExpanderPluginInterface>
     */
    protected function getProtectedPathCollectionExpanderPlugins(): array
    {
        return [
            new DynamicEntityProtectedPathCollectionExpanderPlugin(),
        ];
    }
}
