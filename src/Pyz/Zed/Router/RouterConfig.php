<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Router;

use Spryker\Zed\Router\RouterConfig as SprykerRouterConfig;

class RouterConfig extends SprykerRouterConfig
{
    /**
     * @return array
     */
    public function getControllerDirectories(): array
    {
        $controllerDirectories = parent::getControllerDirectories();

        $controllerDirectories[] = sprintf('%s/spryker-sdk/*/src/*/Zed/*/Communication/Controller/', APPLICATION_VENDOR_DIR);
        $controllerDirectories[] = sprintf('%s/spryker-eco/*/src/*/Zed/*/Communication/Controller/', APPLICATION_VENDOR_DIR);

        return array_filter($controllerDirectories, 'glob');
    }
}
