<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ErrorHandler;

use Spryker\Zed\ErrorHandler\Communication\Plugin\ExceptionHandler\SubRequestExceptionHandlerStrategyPlugin;
use Spryker\Zed\ErrorHandler\ErrorHandlerDependencyProvider as SprykerErrorHandlerDependencyProvider;

class ErrorHandlerDependencyProvider extends SprykerErrorHandlerDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\ErrorHandlerExtension\Dependency\Plugin\ExceptionHandlerStrategyPluginInterface>
     */
    protected function getExceptionHandlerStrategyPlugins(): array
    {
        return [
            new SubRequestExceptionHandlerStrategyPlugin(),
        ];
    }
}
