<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\CartReorderPage;

use SprykerShop\Yves\AvailabilityWidget\Plugin\CartReorderPage\ProductAvailabilityCartReorderItemCheckboxAttributeExpanderPlugin;
use SprykerShop\Yves\CartReorderPage\CartReorderPageDependencyProvider as SprykerCartReorderPageDependencyProvider;
use SprykerShop\Yves\ProductBundleWidget\Plugin\CartReorderPage\ProductBundleCartReorderItemCheckboxAttributeExpanderPlugin;
use SprykerShop\Yves\ProductBundleWidget\Plugin\CartReorderPage\ProductBundleCartReorderRequestExpanderPlugin;

class CartReorderPageDependencyProvider extends SprykerCartReorderPageDependencyProvider
{
    /**
     * @return list<\SprykerShop\Yves\CartReorderPageExtension\Dependency\Plugin\CartReorderItemCheckboxAttributeExpanderPluginInterface>
     */
    protected function getCartReorderItemCheckboxAttributeExpanderPlugins(): array
    {
        return [
            new ProductAvailabilityCartReorderItemCheckboxAttributeExpanderPlugin(),
            new ProductBundleCartReorderItemCheckboxAttributeExpanderPlugin(),
        ];
    }

    /**
     * @return list<\SprykerShop\Yves\CartReorderPageExtension\Dependency\Plugin\CartReorderRequestExpanderPluginInterface>
     */
    protected function getCartReorderRequestExpanderPlugins(): array
    {
        return [
            new ProductBundleCartReorderRequestExpanderPlugin(),
        ];
    }
}
