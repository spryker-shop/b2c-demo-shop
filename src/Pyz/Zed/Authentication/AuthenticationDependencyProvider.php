<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Authentication;

use Spryker\Zed\Authentication\AuthenticationDependencyProvider as SprykerAuthenticationDependencyProvider;
use Spryker\Zed\AuthenticationOauth\Communication\Plugin\OauthAuthenticationServerPlugin;

class AuthenticationDependencyProvider extends SprykerAuthenticationDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\AuthenticationExtension\Dependency\Plugin\AuthenticationServerPluginInterface>
     */
    protected function getAuthenticationServerPlugins(): array
    {
        return [
            new OauthAuthenticationServerPlugin(),
        ];
    }
}
