<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductList;

use Spryker\Zed\ConfigurableBundle\Communication\Plugin\ProductList\ConfigurableBundleTemplateSlotProductListDeletePreCheckPlugin;
use Spryker\Zed\ProductList\ProductListDependencyProvider as SprykerProductListDependencyProvider;

class ProductListDependencyProvider extends SprykerProductListDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\ProductListExtension\Dependency\Plugin\ProductListDeletePreCheckPluginInterface>
     */
    protected function getProductListDeletePreCheckPlugins(): array
    {
        return [
            new ConfigurableBundleTemplateSlotProductListDeletePreCheckPlugin(),
        ];
    }
}
