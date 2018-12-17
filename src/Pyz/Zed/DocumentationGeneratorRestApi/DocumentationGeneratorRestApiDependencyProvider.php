<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DocumentationGeneratorRestApi;

use Spryker\Glue\GlueApplication\Plugin\DocumentationGeneratorRestApi\ResourceRelationshipCollectionProviderPlugin;
use Spryker\Glue\GlueApplication\Plugin\DocumentationGeneratorRestApi\ResourceRoutePluginsProviderPlugin;
use Spryker\Zed\DocumentationGeneratorRestApi\DocumentationGeneratorRestApiDependencyProvider as SprykerDocumentationGeneratorRestApiDependencyProvider;

class DocumentationGeneratorRestApiDependencyProvider extends SprykerDocumentationGeneratorRestApiDependencyProvider
{
    /**
     * @return \Spryker\Glue\DocumentationGeneratorRestApiExtension\Dependency\Plugin\ResourceRoutePluginsProviderPluginInterface[]
     */
    protected function getResourceRoutePluginProviderPlugins(): array
    {
        return [
            new ResourceRoutePluginsProviderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Glue\DocumentationGeneratorRestApiExtension\Dependency\Plugin\ResourceRelationshipCollectionProviderPluginInterface[]
     */
    protected function getResourceRelationshipCollectionProviderPlugins(): array
    {
        return [
            new ResourceRelationshipCollectionProviderPlugin(),
        ];
    }
}
