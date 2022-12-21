<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\SalesReturnPage;

use SprykerShop\Yves\SalesProductBundleWidget\Plugin\SalesReturnPage\ProductBundleReturnCreateFormHandlerPlugin;
use SprykerShop\Yves\SalesReturnPage\SalesReturnPageDependencyProvider as SprykerSalesReturnPageDependencyProvider;

class SalesReturnPageDependencyProvider extends SprykerSalesReturnPageDependencyProvider
{
    /**
     * @return array<\SprykerShop\Yves\SalesReturnPageExtension\Dependency\Plugin\ReturnCreateFormHandlerPluginInterface>
     */
    protected function getReturnCreateFormHandlerPlugins(): array
    {
        return [
            new ProductBundleReturnCreateFormHandlerPlugin(),
        ];
    }
}
