<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Glue\MultiFactorAuth;

use Spryker\Glue\MultiFactorAuth\MultiFactorAuthDependencyProvider as SprykerGlueApplicationDependencyProvider;
use Spryker\Yves\MultiFactorAuth\Plugin\Factors\Email\CustomerEmailMultiFactorAuthPlugin;
use Spryker\Zed\MultiFactorAuth\Communication\Plugin\Factors\Email\UserEmailMultiFactorAuthPlugin;

class MultiFactorAuthDependencyProvider extends SprykerGlueApplicationDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\MultiFactorAuthExtension\Dependency\Plugin\MultiFactorAuthPluginInterface>
     */
    protected function getCustomerMultiFactorAuthPlugins(): array
    {
        return [
            new CustomerEmailMultiFactorAuthPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\MultiFactorAuthExtension\Dependency\Plugin\MultiFactorAuthPluginInterface>
     */
    protected function getUserMultiFactorAuthPlugins(): array
    {
        return [
            new UserEmailMultiFactorAuthPlugin(),
        ];
    }
}
