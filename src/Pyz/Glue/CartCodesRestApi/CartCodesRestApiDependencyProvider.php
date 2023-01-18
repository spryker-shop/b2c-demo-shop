<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CartCodesRestApi;

use Spryker\Glue\CartCodesRestApi\CartCodesRestApiDependencyProvider as SprykerCartCodesRestApiDependencyProvider;
use Spryker\Glue\DiscountPromotionsRestApi\Plugin\CartCodesRestApi\DiscountPromotionDiscountMapperPlugin;

class CartCodesRestApiDependencyProvider extends SprykerCartCodesRestApiDependencyProvider
{
    /**
     * @return array<\Spryker\Glue\CartCodesRestApiExtension\Dependency\Plugin\DiscountMapperPluginInterface>
     */
    protected function getDiscountMapperPlugins(): array
    {
        return [
            new DiscountPromotionDiscountMapperPlugin(),
        ];
    }
}
