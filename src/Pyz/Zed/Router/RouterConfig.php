<?php

/**
 * This file is part of the Spryker Commerce OS.
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
     * @project Only required for nonsplit-repositories, do not use this in project.
     *
     * @return array
     */
    public function getControllerDirectories(): array
    {
        $controllerDirectories = [];

        foreach ($this->get(KernelConstants::PROJECT_NAMESPACES) as $projectNamespace) {
            $controllerDirectories[] = sprintf('%s/%s/Zed/*/Communication/Controller/', APPLICATION_SOURCE_DIR, $projectNamespace);
        }

        $filterChain = new FilterChain();
        $filterChain
            ->attach(new CamelCaseToDash())
            ->attach(new StringToLower());

        foreach ($this->get(KernelConstants::CORE_NAMESPACES) as $coreNamespace) {
            $controllerDirectories[] = sprintf('%s/%s/*/src/%s/Zed/*/Communication/Controller/', APPLICATION_VENDOR_DIR, $filterChain->filter($coreNamespace), $coreNamespace);
        }

        return array_filter($controllerDirectories, 'glob');
    }
}
