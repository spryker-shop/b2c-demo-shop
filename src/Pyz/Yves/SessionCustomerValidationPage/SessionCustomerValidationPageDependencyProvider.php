<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\SessionCustomerValidationPage;

use Spryker\Yves\SessionRedis\Plugin\SessionCustomerValidationPage\RedisCustomerSessionSaverPlugin;
use Spryker\Yves\SessionRedis\Plugin\SessionCustomerValidationPage\RedisCustomerSessionValidatorPlugin;
use SprykerShop\Yves\SessionCustomerValidationPage\SessionCustomerValidationPageDependencyProvider as SprykerSessionCustomerValidationPageDependencyProvider;
use SprykerShop\Yves\SessionCustomerValidationPageExtension\Dependency\Plugin\CustomerSessionSaverPluginInterface;
use SprykerShop\Yves\SessionCustomerValidationPageExtension\Dependency\Plugin\CustomerSessionValidatorPluginInterface;

class SessionCustomerValidationPageDependencyProvider extends SprykerSessionCustomerValidationPageDependencyProvider
{
    /**
     * @return \SprykerShop\Yves\SessionCustomerValidationPageExtension\Dependency\Plugin\CustomerSessionSaverPluginInterface
     */
    protected function getCustomerSessionSaverPlugin(): CustomerSessionSaverPluginInterface
    {
        return new RedisCustomerSessionSaverPlugin();
    }

    /**
     * @return \SprykerShop\Yves\SessionCustomerValidationPageExtension\Dependency\Plugin\CustomerSessionValidatorPluginInterface
     */
    protected function getCustomerSessionValidatorPlugin(): CustomerSessionValidatorPluginInterface
    {
        return new RedisCustomerSessionValidatorPlugin();
    }
}
