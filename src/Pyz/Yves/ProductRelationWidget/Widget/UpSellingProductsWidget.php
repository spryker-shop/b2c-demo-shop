<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductRelationWidget\Widget;

use SprykerShop\Yves\ProductRelationWidget\Widget\UpSellingProductsWidget as SprykerUpSellingProductsWidget;

/**
 * @method \SprykerShop\Yves\ProductRelationWidget\ProductRelationWidgetFactory getFactory()
 */
class UpSellingProductsWidget extends SprykerUpSellingProductsWidget
{
    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@ProductRelationWidget/views/pdp-upsell-products-carousel/pdp-upsell-products-carousel.twig';
    }
}
