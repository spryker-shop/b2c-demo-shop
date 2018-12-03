<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\GlueApplication\Bootstrap;

use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Spryker\Glue\GlueApplication\Bootstrap\AbstractGlueBootstrap;
use Spryker\Glue\GlueApplication\Plugin\Rest\GlueServiceProviderPlugin;
use Spryker\Glue\GlueApplication\Plugin\Rest\ServiceProvider\GlueApplicationServiceProvider;
use Spryker\Glue\GlueApplication\Plugin\Rest\ServiceProvider\GlueResourceBuilderService;
use Spryker\Glue\GlueApplication\Plugin\Rest\ServiceProvider\GlueRoutingServiceProvider;

class GlueBootstrap extends AbstractGlueBootstrap
{
    /**
     * @return void
     */
    protected function registerServiceProviders(): void
    {
        $this->application
            ->register(new GlueResourceBuilderService())
            ->register(new GlueApplicationServiceProvider())
            ->register(new SessionServiceProvider())
            ->register(new ServiceControllerServiceProvider())
            ->register(new GlueServiceProviderPlugin())
            ->register(new GlueRoutingServiceProvider());
    }
}
