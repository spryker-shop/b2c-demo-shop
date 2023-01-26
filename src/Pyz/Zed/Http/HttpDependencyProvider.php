<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Http;

use Spryker\Zed\Http\Communication\Plugin\Http\HIncludeRendererFragmentHandlerPlugin;
use Spryker\Zed\Http\Communication\Plugin\Http\InlineRendererFragmentHandlerPlugin;
use Spryker\Zed\Http\HttpDependencyProvider as SprykerHttpDependencyProvider;

class HttpDependencyProvider extends SprykerHttpDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\HttpExtension\Dependency\Plugin\FragmentHandlerPluginInterface>
     */
    protected function getFragmentHandlerPlugins(): array
    {
        return [
            new InlineRendererFragmentHandlerPlugin(),
            new HIncludeRendererFragmentHandlerPlugin(),
        ];
    }
}
