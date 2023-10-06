<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\Oauth;

use Spryker\Client\Oauth\OauthDependencyProvider as SprykerOauthDependencyProvider;
use Spryker\Client\OauthCryptography\Communication\Plugin\Oauth\BearerTokenAuthorizationValidatorPlugin;
use Spryker\Client\OauthCryptography\Communication\Plugin\Oauth\FileSystemKeyLoaderPlugin;
use Spryker\Client\OauthCustomerValidation\Plugin\Oauth\ValidateInvalidatedCustomerAccessTokenValidatorPlugin;

class OauthDependencyProvider extends SprykerOauthDependencyProvider
{
    /**
     * @return array<\Spryker\Client\OauthExtension\Dependency\Plugin\KeyLoaderPluginInterface>
     */
    protected function getKeyLoaderPlugins(): array
    {
        return [
            new FileSystemKeyLoaderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\OauthExtension\Dependency\Plugin\AuthorizationValidatorPluginInterface>
     */
    protected function getAuthorizationValidatorPlugins(): array
    {
        return [
            new BearerTokenAuthorizationValidatorPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\OauthExtension\Dependency\Plugin\AccessTokenValidatorPluginInterface>
     */
    protected function getAccessTokenValidatorPlugins(): array
    {
        return [
            new ValidateInvalidatedCustomerAccessTokenValidatorPlugin(),
        ];
    }
}
