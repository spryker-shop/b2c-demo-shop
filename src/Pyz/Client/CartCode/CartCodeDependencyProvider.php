<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\CartCode;

use Spryker\Client\CartCode\CartCodeDependencyProvider as SprykerCartCodeDependencyProvider;
use Spryker\Client\Discount\Plugin\CartCode\VoucherCartCodePlugin;
use Spryker\Client\GiftCard\Plugin\CartCode\GiftCardCartCodePlugin;

class CartCodeDependencyProvider extends SprykerCartCodeDependencyProvider
{
    /**
     * @return \Spryker\Client\CartCodeExtension\Dependency\Plugin\CartCodePluginInterface[]
     */
    protected function getCartCodePluginCollection(): array
    {
        return [
            new VoucherCartCodePlugin(),
            new GiftCardCartCodePlugin(),
        ];
    }
}
