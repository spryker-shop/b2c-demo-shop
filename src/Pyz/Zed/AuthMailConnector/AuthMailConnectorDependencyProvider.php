<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuthMailConnector;

use Spryker\Zed\AuthMailConnector\AuthMailConnectorDependencyProvider as SprykerAuthMailConnectorDependencyProvider;
use Spryker\Zed\User\Communication\Plugin\AuthMailConnector\UserAuthMailExpanderPlugin;

class AuthMailConnectorDependencyProvider extends SprykerAuthMailConnectorDependencyProvider
{
    /**
     * @return \Spryker\Zed\AuthMailConnectorExtension\Dependency\Plugin\AuthMailExpanderPluginInterface[]
     */
    protected function getAuthMailExpanderPlugins(): array
    {
        return [
            new UserAuthMailExpanderPlugin(),
        ];
    }
}
