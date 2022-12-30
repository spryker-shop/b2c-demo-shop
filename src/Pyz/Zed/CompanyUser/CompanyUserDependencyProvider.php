<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CompanyUser;

use Spryker\Zed\CompanyBusinessUnit\Communication\Plugin\CompanyUser\CheckCompanyUserUniquenessCompanyUserSavePreCheckPlugin;
use Spryker\Zed\CompanyRole\Communication\Plugin\CompanyUser\AssignRolesCompanyUserPostCreatePlugin;
use Spryker\Zed\CompanyRole\Communication\Plugin\CompanyUser\AssignRolesCompanyUserPostSavePlugin;
use Spryker\Zed\CompanyRole\Communication\Plugin\CompanyUser\CompanyRoleCollectionHydratePlugin;
use Spryker\Zed\CompanyUser\CompanyUserDependencyProvider as SprykerCompanyUserDependencyProvider;

class CompanyUserDependencyProvider extends SprykerCompanyUserDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserSavePreCheckPluginInterface>
     */
    protected function getCompanyUserSavePreCheckPlugins() : array
    {
        return [
            new CheckCompanyUserUniquenessCompanyUserSavePreCheckPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface>
     */
    protected function getCompanyUserHydrationPlugins() : array
    {
        return [
            new CompanyRoleCollectionHydratePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface>
     */
    protected function getCompanyUserPostCreatePlugins() : array
    {
        return [
            new AssignRolesCompanyUserPostCreatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPostSavePluginInterface>
     */
    protected function getCompanyUserPostSavePlugins() : array
    {
        return [
            new AssignRolesCompanyUserPostSavePlugin(),
        ];
    }
}