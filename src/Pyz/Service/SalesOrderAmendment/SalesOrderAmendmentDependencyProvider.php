<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Service\SalesOrderAmendment;

use Spryker\Service\ProductOffer\Plugin\SalesOrderAmendment\ProductOfferOriginalSalesOrderItemGroupKeyExpanderPlugin;
use Spryker\Service\SalesOrderAmendment\SalesOrderAmendmentDependencyProvider as SprykerSalesOrderAmendmentDependencyProvider;

class SalesOrderAmendmentDependencyProvider extends SprykerSalesOrderAmendmentDependencyProvider
{
    /**
     * @return list<\Spryker\Service\SalesOrderAmendmentExtension\Dependency\Plugin\OriginalSalesOrderItemGroupKeyExpanderPluginInterface>
     */
    protected function getOriginalSalesOrderItemGroupKeyExpanderPlugins(): array
    {
        return [
            new ProductOfferOriginalSalesOrderItemGroupKeyExpanderPlugin(),
        ];
    }
}
