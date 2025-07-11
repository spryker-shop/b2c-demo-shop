<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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
