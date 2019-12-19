<?php
/**
 * Created by PhpStorm.
 * User: kravchenko
 * Date: 2019-12-19
 * Time: 18:35
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
