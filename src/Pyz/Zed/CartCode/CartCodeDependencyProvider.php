<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CartCode;

use Spryker\Zed\CartCode\CartCodeDependencyProvider as SprykerCartCodeDependencyProvider;
use Spryker\Zed\Discount\Communication\Plugin\CartCode\VoucherCartCodePlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\CartCode\GiftCardCartCodePlugin;

class CartCodeDependencyProvider extends SprykerCartCodeDependencyProvider
{
    /**
     * @return \Spryker\Zed\CartCodeExtension\Dependency\Plugin\CartCodePluginInterface[]
     */
    protected function getCartCodePlugins(): array
    {
        return [
            new VoucherCartCodePlugin(),
            new GiftCardCartCodePlugin(),
        ];
    }
}
