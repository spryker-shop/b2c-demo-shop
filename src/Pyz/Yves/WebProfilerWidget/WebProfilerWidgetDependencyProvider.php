<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\WebProfilerWidget;

use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerAjaxDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerConfigDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerConfigDataCollectorPlugin as SymfonyWebProfilerConfigDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerEventsDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerExceptionDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerLoggerDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerMemoryDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerRequestDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerRouterDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerTimeDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\WebProfiler\WebProfilerTwigDataCollectorPlugin;
use SprykerShop\Yves\WebProfilerWidget\WebProfilerWidgetDependencyProvider as SprykerWebProfilerDependencyProvider;

class WebProfilerWidgetDependencyProvider extends SprykerWebProfilerDependencyProvider
{
    /**
     * @return \Spryker\Shared\WebProfilerExtension\Dependency\Plugin\WebProfilerDataCollectorPluginInterface[]
     */
    public function getDataCollectorPlugins()
    {
        return [
            new WebProfilerRequestDataCollectorPlugin(),
            new WebProfilerRouterDataCollectorPlugin(),
            new WebProfilerAjaxDataCollectorPlugin(),
            new SymfonyWebProfilerConfigDataCollectorPlugin(),
            new WebProfilerConfigDataCollectorPlugin(),
            new WebProfilerEventsDataCollectorPlugin(),
            new WebProfilerExceptionDataCollectorPlugin(),
            new WebProfilerLoggerDataCollectorPlugin(),
            new WebProfilerMemoryDataCollectorPlugin(),
            new WebProfilerTimeDataCollectorPlugin(),
            new WebProfilerTwigDataCollectorPlugin(),
        ];
    }
}
