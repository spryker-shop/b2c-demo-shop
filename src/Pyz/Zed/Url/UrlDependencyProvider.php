<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Url;

use Spryker\Zed\Navigation\Communication\Plugin\DetachNavigationUrlAfterUrlDeletePlugin;
use Spryker\Zed\Url\UrlDependencyProvider as SprykerUrlDependencyProvider;

class UrlDependencyProvider extends SprykerUrlDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\Url\Dependency\Plugin\UrlDeletePluginInterface>
     */
    protected function getUrlBeforeDeletePlugins(): array
    {
        return [
            new DetachNavigationUrlAfterUrlDeletePlugin(),
        ];
    }
}
