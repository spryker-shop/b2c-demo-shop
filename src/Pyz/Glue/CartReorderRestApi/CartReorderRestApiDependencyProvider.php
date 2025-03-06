<?php

namespace Pyz\Glue\CartReorderRestApi;

use Spryker\Glue\CartReorderRestApi\CartReorderRestApiDependencyProvider as SprykerCartReorderRestApiDependencyProvider;
use Spryker\Glue\OrderAmendmentsRestApi\Plugin\CartReorderRestApi\OrderAmendmentRestCartReorderAttributesMapperPlugin;

class CartReorderRestApiDependencyProvider extends SprykerCartReorderRestApiDependencyProvider
{
    /**
     * @return list<\Spryker\Glue\CartReorderRestApiExtension\Dependency\Plugin\RestCartReorderAttributesMapperPluginInterface>
     */
    protected function getRestCartReorderAttributesMapperPlugins(): array
    {
        return [
            new OrderAmendmentRestCartReorderAttributesMapperPlugin(),
        ];
    }
}
