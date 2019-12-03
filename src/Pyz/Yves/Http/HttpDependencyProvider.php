<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Http;

use Spryker\Yves\Http\HttpDependencyProvider as SprykerHttpDependencyProvider;
use Spryker\Yves\Http\Plugin\Http\HIncludeRendererFragmentHandlerPlugin;
use Spryker\Yves\Http\Plugin\Http\InlineRendererFragmentHandlerPlugin;

class HttpDependencyProvider extends SprykerHttpDependencyProvider
{
    /**
     * @return \Spryker\Shared\HttpExtension\Dependency\Plugin\FragmentHandlerPluginInterface[]
     */
    protected function getFragmentHandlerPlugins(): array
    {
        return [
            new InlineRendererFragmentHandlerPlugin(),
            new HIncludeRendererFragmentHandlerPlugin(),
        ];
    }
}
