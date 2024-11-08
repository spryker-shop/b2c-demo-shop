<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\KernelApp;

use Spryker\Zed\KernelApp\KernelAppDependencyProvider as SprykerKernelAppDependencyProvider;
use Spryker\Zed\OauthClient\Communication\Plugin\KernelApp\OAuthRequestExpanderPlugin;

class KernelAppDependencyProvider extends SprykerKernelAppDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\KernelAppExtension\RequestExpanderPluginInterface>
     */
    public function getRequestExpanderPlugins(): array
    {
        return [
            new OAuthRequestExpanderPlugin(),
        ];
    }
}
