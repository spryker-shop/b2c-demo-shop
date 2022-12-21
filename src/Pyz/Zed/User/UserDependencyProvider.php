<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\User;

use Spryker\Zed\Acl\Communication\Plugin\GroupPlugin;
use Spryker\Zed\AgentGui\Communication\Plugin\UserAgentFormExpanderPlugin;
use Spryker\Zed\AgentGui\Communication\Plugin\UserAgentTableConfigExpanderPlugin;
use Spryker\Zed\AgentGui\Communication\Plugin\UserAgentTableDataExpanderPlugin;
use Spryker\Zed\CustomerUserConnectorGui\Communication\Plugin\UserTableActionExpanderPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\User\UserDependencyProvider as SprykerUserDependencyProvider;
use Spryker\Zed\UserLocale\Communication\Plugin\User\AssignUserLocalePreSavePlugin;
use Spryker\Zed\UserLocale\Communication\Plugin\User\UserLocaleTransferExpanderPlugin;
use Spryker\Zed\UserLocaleGui\Communication\Plugin\UserLocaleFormExpanderPlugin;

class UserDependencyProvider extends SprykerUserDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addGroupPlugin(Container $container): Container
    {
        $container->set(static::PLUGIN_GROUP, function (Container $container) {
            return new GroupPlugin();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\UserExtension\Dependency\Plugin\UserTableActionExpanderPluginInterface>
     */
    protected function getUserTableActionExpanderPlugins(): array
    {
        return [
            new UserTableActionExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\UserExtension\Dependency\Plugin\UserFormExpanderPluginInterface>
     */
    protected function getUserFormExpanderPlugins(): array
    {
        return [
            new UserAgentFormExpanderPlugin(),
            new UserLocaleFormExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\UserExtension\Dependency\Plugin\UserTableConfigExpanderPluginInterface>
     */
    protected function getUserTableConfigExpanderPlugins(): array
    {
        return [
            new UserAgentTableConfigExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\UserExtension\Dependency\Plugin\UserTableDataExpanderPluginInterface>
     */
    protected function getUserTableDataExpanderPlugins(): array
    {
        return [
            new UserAgentTableDataExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\UserExtension\Dependency\Plugin\UserPreSavePluginInterface>
     */
    protected function getUserPreSavePlugins(): array
    {
        return [
            new AssignUserLocalePreSavePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\UserExtension\Dependency\Plugin\UserTransferExpanderPluginInterface>
     */
    protected function getUserTransferExpanderPlugins(): array
    {
        return [
            new UserLocaleTransferExpanderPlugin(),
        ];
    }
}
