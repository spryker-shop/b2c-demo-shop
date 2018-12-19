<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomersRestApi;

use Spryker\Glue\CartsRestApi\Plugin\CustomerPostRegister\UpdateCartCustomerReferencePlugin;
use Spryker\Glue\CustomersRestApi\CustomersRestApiDependencyProvider as SprykerCustomersRestApiDependencyProvider;

class CustomersRestApiDependencyProvider extends SprykerCustomersRestApiDependencyProvider
{
    /**
     * @return \Spryker\Glue\CustomersRestApiExtension\Dependency\Plugin\CustomerPostRegisterPluginInterface[]
     */
    protected function getCustomerPostRegisterPlugins(): array
    {
        return array_merge(parent::getCustomerPostRegisterPlugins(), [
            new UpdateCartCustomerReferencePlugin(),
        ]);
    }
}
