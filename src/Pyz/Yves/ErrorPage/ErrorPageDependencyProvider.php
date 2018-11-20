<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ErrorPage;

use SprykerShop\Yves\ErrorPage\ErrorPageDependencyProvider as SprykerErrorPageDependencyProvider;
use SprykerShop\Yves\ErrorPage\Plugin\ExceptionHandler\SubRequestExceptionHandlerPlugin;

class ErrorPageDependencyProvider extends SprykerErrorPageDependencyProvider
{
    /**
     * @return \SprykerShop\Yves\ErrorPage\Dependency\Plugin\ExceptionHandlerPluginInterface[]
     */
    protected function getExceptionHandlerPlugins()
    {
        return [
            new SubRequestExceptionHandlerPlugin(),
        ];
    }
}
