<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ErrorHandler;

use Spryker\Zed\ErrorHandler\ErrorHandlerConfig as SprykerErrorHandlerConfigAlias;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Spryker\Shared\ErrorHandler\ErrorHandlerConfig getSharedConfig()
 */
class ErrorHandlerConfig extends SprykerErrorHandlerConfigAlias
{
    /**
     * @api
     *
     * @return array<int>
     */
    public function getValidSubRequestExceptionStatusCodes(): array
    {
        return array_merge(
            parent::getValidSubRequestExceptionStatusCodes(),
            [
                Response::HTTP_TOO_MANY_REQUESTS,
            ],
        );
    }
}
