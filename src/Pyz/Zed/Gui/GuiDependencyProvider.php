<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Gui;

use Spryker\Zed\Gui\GuiDependencyProvider as SprykerGuiDependencyProvider;
use Spryker\Zed\MultiFactorAuth\Communication\Plugin\Navigation\MultiFactorAuthSetupNavigationPlugin;

class GuiDependencyProvider extends SprykerGuiDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\GuiExtension\Dependency\Plugin\NavigationPluginInterface>
     */
    protected function getDropdownNavigationPlugins(): array
    {
        return [
            new MultiFactorAuthSetupNavigationPlugin(),
        ];
    }
}
