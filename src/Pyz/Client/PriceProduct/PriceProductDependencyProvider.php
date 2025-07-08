<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\PriceProduct;

use Spryker\Client\PriceProduct\PriceProductDependencyProvider as SprykerPriceProductDependencyProvider;
use Spryker\Client\PriceProductSalesOrderAmendment\Plugin\PriceProduct\OriginalSalesOrderItemPriceProductPostResolvePlugin;

class PriceProductDependencyProvider extends SprykerPriceProductDependencyProvider
{
    /**
     * @return list<\Spryker\Client\PriceProductExtension\Dependency\Plugin\PriceProductPostResolvePluginInterface>
     */
    protected function getPriceProductPostResolvePlugins(): array
    {
        return [
            new OriginalSalesOrderItemPriceProductPostResolvePlugin(),
        ];
    }
}
