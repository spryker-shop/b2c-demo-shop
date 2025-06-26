<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\Customer;

use Spryker\Client\Cart\Plugin\CustomerChangeCartUpdatePlugin;
use Spryker\Client\Customer\CustomerDependencyProvider as SprykerCustomerDependencyProvider;
use Spryker\Client\Customer\Plugin\CustomerAddressSessionUpdatePlugin;
use Spryker\Client\Customer\Plugin\CustomerTransferSessionRefreshPlugin;
use Spryker\Client\CustomerAccessPermission\Plugin\Customer\CustomerAccessSecuredPatternRulePlugin;
use Spryker\Client\PersistentCart\Plugin\GuestCartUpdateCustomerSessionSetPlugin;

class CustomerDependencyProvider extends SprykerCustomerDependencyProvider
{
    /**
     * @return array<\Spryker\Client\Customer\Dependency\Plugin\CustomerSessionGetPluginInterface>
     */
    protected function getCustomerSessionGetPlugins(): array
    {
        return [
            new CustomerTransferSessionRefreshPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\Customer\Dependency\Plugin\CustomerSessionSetPluginInterface>
     */
    protected function getCustomerSessionSetPlugins(): array
    {
        return [
            new GuestCartUpdateCustomerSessionSetPlugin(),
            new CustomerChangeCartUpdatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\Customer\Dependency\Plugin\DefaultAddressChangePluginInterface>
     */
    protected function getDefaultAddressChangePlugins(): array
    {
        return [
            new CustomerAddressSessionUpdatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\CustomerExtension\Dependency\Plugin\CustomerSecuredPatternRulePluginInterface>
     */
    protected function getCustomerSecuredPatternRulePlugins(): array
    {
        return [
            new CustomerAccessSecuredPatternRulePlugin(), #CustomerAccessPermissionFeature
        ];
    }
}
