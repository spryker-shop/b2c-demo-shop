<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuthRestApi;

use Spryker\Zed\AuthRestApi\AuthRestApiDependencyProvider as SprykerAuthRestApiDependencyProvider;
use Spryker\Zed\CartsRestApi\Communication\Plugin\AuthRestApi\AddGuestQuoteItemsToCustomerQuotePostAuthPlugin;

class AuthRestApiDependencyProvider extends SprykerAuthRestApiDependencyProvider
{
    /**
     * @return \Spryker\Zed\AuthRestApiExtension\Dependency\Plugin\PostAuthPluginInterface[]
     */
    protected function getPostAuthPlugins(): array
    {
        return [
            new AddGuestQuoteItemsToCustomerQuotePostAuthPlugin(),
        ];
    }
}
