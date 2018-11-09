<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\WebProfiler;

use Spryker\Shared\WebProfiler\Plugin\ServiceProvider\WebProfilerServiceProvider;
use Spryker\Zed\Config\Communication\Plugin\ServiceProvider\ConfigProfilerServiceProvider;
use Spryker\Zed\WebProfiler\WebProfilerDependencyProvider as SprykerWebProfilerDependencyProvider;

class WebProfilerDependencyProvider extends SprykerWebProfilerDependencyProvider
{
    /**
     * @return array
     */
    public function getWebProfilerPlugins()
    {
        return [
            new WebProfilerServiceProvider(),
            new ConfigProfilerServiceProvider(),
        ];
    }
}
