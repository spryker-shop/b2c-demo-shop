<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CartsRestApi;

use Spryker\Zed\CartsRestApi\CartsRestApiDependencyProvider as SprykerCartsRestApiDependencyProvider;
use Spryker\Zed\CartsRestApi\Communication\Plugin\CartsRestApi\QuoteCreatorPlugin;
use Spryker\Zed\CartsRestApiExtension\Dependency\Plugin\QuoteCreatorPluginInterface;
use Spryker\Zed\DiscountPromotionsRestApi\Communication\Plugin\CartsRestApi\DiscountPromotionCartItemMapperPlugin;
use Spryker\Zed\ProductOptionsRestApi\Communication\Plugin\CartsRestApi\ProductOptionCartItemMapperPlugin;

class CartsRestApiDependencyProvider extends SprykerCartsRestApiDependencyProvider
{
    /**
     * @return \Spryker\Zed\CartsRestApiExtension\Dependency\Plugin\QuoteCreatorPluginInterface
     */
    protected function getQuoteCreatorPlugin(): QuoteCreatorPluginInterface
    {
        return new QuoteCreatorPlugin();
    }

    /**
     * @return \Spryker\Zed\CartsRestApiExtension\Dependency\Plugin\CartItemMapperPluginInterface[]
     */
    protected function getCartItemMapperPlugins(): array
    {
        return [
            new ProductOptionCartItemMapperPlugin(),
            new DiscountPromotionCartItemMapperPlugin(),
        ];
    }
}
