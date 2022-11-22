<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\SessionCustomerValidation;

use Spryker\Yves\SessionCustomerValidation\SessionCustomerValidationDependencyProvider as SprykerSessionCustomerValidationDependencyProvider;
use Spryker\Yves\SessionCustomerValidationExtension\Dependency\Plugin\SessionCustomerSaverPluginInterface;
use Spryker\Yves\SessionCustomerValidationExtension\Dependency\Plugin\SessionCustomerValidatorPluginInterface;
use Spryker\Yves\SessionRedis\Plugin\SessionCustomerValidation\SessionRedisSessionCustomerSaverPlugin;
use Spryker\Yves\SessionRedis\Plugin\SessionCustomerValidation\SessionRedisSessionCustomerValidatorPlugin;

class SessionCustomerValidationDependencyProvider extends SprykerSessionCustomerValidationDependencyProvider
{
    /**
     * @return \Spryker\Yves\SessionCustomerValidationExtension\Dependency\Plugin\SessionCustomerSaverPluginInterface
     */
    protected function getSessionCustomerSaverPlugin(): SessionCustomerSaverPluginInterface
    {
        return new SessionRedisSessionCustomerSaverPlugin();
    }

    /**
     * @return \Spryker\Yves\SessionCustomerValidationExtension\Dependency\Plugin\SessionCustomerValidatorPluginInterface
     */
    protected function getSessionCustomerValidatorPlugin(): SessionCustomerValidatorPluginInterface
    {
        return new SessionRedisSessionCustomerValidatorPlugin();
    }
}
