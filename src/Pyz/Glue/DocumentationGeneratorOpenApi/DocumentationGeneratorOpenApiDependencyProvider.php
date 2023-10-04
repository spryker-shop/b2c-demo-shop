<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\DocumentationGeneratorOpenApi;

use Spryker\Glue\DocumentationGeneratorOpenApi\DocumentationGeneratorOpenApiDependencyProvider as SprykerDocumentationGeneratorOpenApiDependencyProvider;
use Spryker\Glue\DynamicEntityBackendApi\Plugin\DocumentationGeneratorOpenApi\DynamicEntityOpenApiSchemaFormatterPlugin;

class DocumentationGeneratorOpenApiDependencyProvider extends SprykerDocumentationGeneratorOpenApiDependencyProvider
{
    /**
     * @return array<\Spryker\Glue\DocumentationGeneratorOpenApiExtension\Dependency\Plugin\OpenApiSchemaFormatterPluginInterface>
     */
    protected function getOpenApiSchemaFormatterPlugins(): array
    {
        return [
            new DynamicEntityOpenApiSchemaFormatterPlugin(),
        ];
    }
}
