<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Router;

use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Zed\Router\RouterConfig as SprykerRouterConfig;
use Zend\Filter\FilterChain;
use Zend\Filter\StringToLower;
use Zend\Filter\Word\CamelCaseToDash;

class RouterConfig extends SprykerRouterConfig
{
    /**
     * Specification:
     * - Returns an array of directories where Controller are placed.
     * - Used to build to Router cache.
     *
     * @api
     *
     * @return array
     */
    public function getControllerDirectories(): array
    {
        $controllerDirectories = [];

        foreach ($this->get(KernelConstants::PROJECT_NAMESPACES) as $projectNamespace) {
            $controllerDirectories[] = sprintf('%s/%s/Zed/*/Communication/Controller/', APPLICATION_SOURCE_DIR, $projectNamespace);
        }

        foreach ($this->get(KernelConstants::CORE_NAMESPACES) as $coreNamespace) {
            $controllerDirectories[] = sprintf('%s/spryker/*/src/%s/Zed/*/Communication/Controller/', APPLICATION_VENDOR_DIR, $coreNamespace);
        }

        $filterChain = new FilterChain();
        $filterChain
            ->attach(new CamelCaseToDash())
            ->attach(new StringToLower());

        $controllerDirectories[] = sprintf('%s/spryker/%s/Bundles/CmsSlot*/src/%s/Zed/*/Communication/Controller/', APPLICATION_VENDOR_DIR, $filterChain->filter($coreNamespace), 'Spryker');

        return array_filter($controllerDirectories, 'glob');
    }
}
