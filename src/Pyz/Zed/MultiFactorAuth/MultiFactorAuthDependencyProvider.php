<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\MultiFactorAuth;

use Spryker\Zed\MultiFactorAuth\Communication\Plugin\Factors\Email\UserEmailMultiFactorAuthPlugin;
use Spryker\Zed\MultiFactorAuth\Communication\Plugin\Sender\Customer\CustomerEmailCodeSenderStrategyPlugin;
use Spryker\Zed\MultiFactorAuth\Communication\Plugin\Sender\User\UserEmailCodeSenderStrategyPlugin;
use Spryker\Zed\MultiFactorAuth\MultiFactorAuthDependencyProvider as SprykerMultiFactorAuthDependencyProvider;
use Spryker\Zed\SecurityGui\Communication\Plugin\MultiFactorAuth\PostUserLoginMultiFactorAuthenticationPlugin;

class MultiFactorAuthDependencyProvider extends SprykerMultiFactorAuthDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\MultiFactorAuthExtension\Dependency\Plugin\MultiFactorAuthPluginInterface>
     */
    protected function getUserMultiFactorAuthPlugins(): array
    {
        return [
            new UserEmailMultiFactorAuthPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\MultiFactorAuthExtension\Dependency\Plugin\SendStrategyPluginInterface>
     */
    protected function getCustomerSendStrategyPlugins(): array
    {
        return [
            new CustomerEmailCodeSenderStrategyPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\MultiFactorAuthExtension\Dependency\Plugin\SendStrategyPluginInterface>
     */
    protected function getUserSendStrategyPlugins(): array
    {
        return [
            new UserEmailCodeSenderStrategyPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\MultiFactorAuthExtension\Dependency\Plugin\PostLoginMultiFactorAuthenticationPluginInterface>
     */
    protected function getPostLoginMultiFactorAuthenticationPlugins(): array
    {
        return [
            new PostUserLoginMultiFactorAuthenticationPlugin(),
        ];
    }
}
