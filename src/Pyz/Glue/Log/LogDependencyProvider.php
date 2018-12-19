<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\Log;

use Spryker\Glue\Kernel\Container;
use Spryker\Glue\Log\LogDependencyProvider as SprykerLogDependencyProvider;
use Spryker\Glue\Log\Plugin\Handler\ExceptionStreamHandlerPlugin;
use Spryker\Glue\Log\Plugin\Handler\StreamHandlerPlugin;
use Spryker\Glue\Log\Plugin\Processor\EnvironmentProcessorPlugin;
use Spryker\Glue\Log\Plugin\Processor\GuzzleBodyProcessorPlugin;
use Spryker\Glue\Log\Plugin\Processor\PsrLogMessageProcessorPlugin;
use Spryker\Glue\Log\Plugin\Processor\RequestProcessorPlugin;
use Spryker\Glue\Log\Plugin\Processor\ResponseProcessorPlugin;
use Spryker\Glue\Log\Plugin\Processor\ServerProcessorPlugin;

class LogDependencyProvider extends SprykerLogDependencyProvider
{
    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addLogHandlers(Container $container): Container
    {
        $container[static::LOG_HANDLERS] = function () {
            return [
                new StreamHandlerPlugin(),
                new ExceptionStreamHandlerPlugin(),
            ];
        };

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addProcessors(Container $container): Container
    {
        $container[static::LOG_PROCESSORS] = function () {
            return [
                new PsrLogMessageProcessorPlugin(),
                new EnvironmentProcessorPlugin(),
                new ServerProcessorPlugin(),
                new RequestProcessorPlugin(),
                new ResponseProcessorPlugin(),
                new GuzzleBodyProcessorPlugin(),
            ];
        };

        return $container;
    }
}
