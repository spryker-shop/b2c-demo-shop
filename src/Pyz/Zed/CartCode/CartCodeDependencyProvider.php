<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\CartCode;

use Spryker\Zed\CartCode\CartCodeDependencyProvider as SprykerCartCodeDependencyProvider;
use Spryker\Zed\Discount\Communication\Plugin\CartCode\VoucherCartCodePlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\CartCode\GiftCardCartCodePlugin;
use Spryker\Zed\Nopayment\Communication\Plugin\CartCode\NopaymentCartCodePostAddPlugin;

class CartCodeDependencyProvider extends SprykerCartCodeDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\CartCodeExtension\Dependency\Plugin\CartCodePluginInterface>
     */
    protected function getCartCodePlugins(): array
    {
        return [
            new VoucherCartCodePlugin(),
            new GiftCardCartCodePlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\CartCodeExtension\Dependency\Plugin\CartCodePostAddPluginInterface>
     */
    protected function getCartCodePostAddPlugins(): array
    {
        return [
            new NopaymentCartCodePostAddPlugin(),
        ];
    }
}
