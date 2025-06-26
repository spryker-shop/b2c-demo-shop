<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\SecurityGui;

use Spryker\Zed\SecurityGui\SecurityGuiDependencyProvider as SprykerSecurityGuiDependencyProvider;
use Spryker\Zed\WarehouseUser\Communication\Plugin\SecurityGui\WarehouseUserLoginRestrictionPlugin;

class SecurityGuiDependencyProvider extends SprykerSecurityGuiDependencyProvider
{
    /**
     * @return list<\Spryker\Zed\SecurityGuiExtension\Dependency\Plugin\UserLoginRestrictionPluginInterface>
     */
    protected function getUserLoginRestrictionPlugins(): array
    {
        return [
            new WarehouseUserLoginRestrictionPlugin(),
        ];
    }
}
