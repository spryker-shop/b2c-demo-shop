<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Glue\AuthRestApi;

use Spryker\Glue\AgentAuthRestApi\Plugin\AuthRestApi\AgentRestUserMapperPlugin;
use Spryker\Glue\AuthRestApi\AuthRestApiDependencyProvider as SprykerAuthRestApiDependencyProvider;

/**
 * @method \Spryker\Glue\AuthRestApi\AuthRestApiConfig getConfig()
 */
class AuthRestApiDependencyProvider extends SprykerAuthRestApiDependencyProvider
{
    /**
     * @return array<\Spryker\Glue\AuthRestApiExtension\Dependency\Plugin\RestUserMapperPluginInterface>
     */
    protected function getRestUserExpanderPlugins(): array
    {
        return [
            new AgentRestUserMapperPlugin(),
        ];
    }
}
