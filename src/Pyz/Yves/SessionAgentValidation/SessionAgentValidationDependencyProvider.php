<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\SessionAgentValidation;

use Spryker\Yves\SessionRedis\Plugin\SessionAgentValidation\SessionRedisSessionAgentSaverPlugin;
use Spryker\Yves\SessionRedis\Plugin\SessionAgentValidation\SessionRedisSessionAgentValidatorPlugin;
use SprykerShop\Yves\SessionAgentValidation\SessionAgentValidationDependencyProvider as SprykerSessionAgentValidationDependencyProvider;
use SprykerShop\Yves\SessionAgentValidationExtension\Dependency\Plugin\SessionAgentSaverPluginInterface;
use SprykerShop\Yves\SessionAgentValidationExtension\Dependency\Plugin\SessionAgentValidatorPluginInterface;

class SessionAgentValidationDependencyProvider extends SprykerSessionAgentValidationDependencyProvider
{
    /**
     * @return \SprykerShop\Yves\SessionAgentValidationExtension\Dependency\Plugin\SessionAgentSaverPluginInterface
     */
    protected function getSessionAgentSaverPlugin(): SessionAgentSaverPluginInterface
    {
        return new SessionRedisSessionAgentSaverPlugin();
    }

    /**
     * @return \SprykerShop\Yves\SessionAgentValidationExtension\Dependency\Plugin\SessionAgentValidatorPluginInterface
     */
    protected function getSessionAgentValidatorPlugin(): SessionAgentValidatorPluginInterface
    {
        return new SessionRedisSessionAgentValidatorPlugin();
    }
}
