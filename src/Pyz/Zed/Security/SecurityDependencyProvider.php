<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Security;

use Spryker\Zed\Security\SecurityDependencyProvider as SprykerSecurityDependencyProvider;
use Spryker\Zed\SecurityGui\Communication\Plugin\Security\UserSecurityPlugin;
use Spryker\Zed\SecurityOauthUser\Communication\Plugin\Security\OauthUserSecurityPlugin;
use Spryker\Zed\SecuritySystemUser\Communication\Plugin\Security\SystemUserSecurityPlugin;
use Spryker\Zed\SessionUserValidation\Communication\Plugin\Security\SaveSessionUserSecurityPlugin;
use Spryker\Zed\SessionUserValidation\Communication\Plugin\Security\ValidateSessionUserSecurityPlugin;
use Spryker\Zed\User\Communication\Plugin\Security\UserSessionHandlerSecurityPlugin;

class SecurityDependencyProvider extends SprykerSecurityDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\SecurityExtension\Dependency\Plugin\SecurityPluginInterface>
     */
    protected function getSecurityPlugins(): array
    {
        return [
            new UserSessionHandlerSecurityPlugin(),
            new SystemUserSecurityPlugin(),
            new UserSecurityPlugin(),
            new OauthUserSecurityPlugin(),
            new ValidateSessionUserSecurityPlugin(),
            new SaveSessionUserSecurityPlugin(),
        ];
    }
}
