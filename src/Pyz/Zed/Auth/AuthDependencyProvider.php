<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Auth;

use Spryker\Zed\Auth\AuthDependencyProvider as SprykerAuthDependencyProvider;
use Spryker\Zed\Auth\Dependency\Plugin\AuthPasswordResetSenderInterface;
use Spryker\Zed\AuthMailConnector\Communication\Plugin\AuthPasswordResetMailSenderPlugin;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\Auth\AuthConfig getConfig()
 */
class AuthDependencyProvider extends SprykerAuthDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Auth\Dependency\Plugin\AuthPasswordResetSenderInterface|null
     */
    protected function getPasswordResetNotificationSender(Container $container): ?AuthPasswordResetSenderInterface
    {
        return new AuthPasswordResetMailSenderPlugin();
    }
}
