<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductDetailPage;

use Pyz\Yves\ExampleProductColorGroupWidget\Plugin\ProductDetailPage\ExampleProductColorGroupWidgetPlugin;
use SprykerShop\Yves\AvailabilityWidget\Plugin\ProductDetailPage\AvailabilityWidgetPlugin;
use SprykerShop\Yves\CmsBlockWidget\Plugin\ProductDetailPage\ProductCmsBlockWidgetPlugin;
use SprykerShop\Yves\PriceWidget\Plugin\ProductDetailPage\PriceWidgetPlugin;
use SprykerShop\Yves\ProductCategoryWidget\Plugin\ProductDetailPage\ProductCategoryWidgetPlugin;
use SprykerShop\Yves\ProductDetailPage\ProductDetailPageDependencyProvider as SprykerShopProductDetailPageDependencyProvider;
use SprykerShop\Yves\ProductImageWidget\Plugin\ProductDetailPage\ProductImageWidgetPlugin;
use SprykerShop\Yves\ProductLabelWidget\Plugin\ProductDetailPage\ProductAbstractLabelWidgetPlugin;
use SprykerShop\Yves\ProductMeasurementUnitWidget\Plugin\ProductDetailPage\ProductMeasurementUnitWidgetPlugin;
use SprykerShop\Yves\ProductOptionWidget\Plugin\ProductDetailPage\ProductOptionWidgetPlugin;
use SprykerShop\Yves\ProductRelationWidget\Plugin\ProductDetailPage\SimilarProductsWidgetPlugin;
use SprykerShop\Yves\ProductReviewWidget\Plugin\ProductDetailPage\ProductReviewWidgetPlugin;
use SprykerShop\Yves\WishlistWidget\Plugin\ProductDetailPage\WishlistWidgetPlugin;

class ProductDetailPageDependencyProvider extends SprykerShopProductDetailPageDependencyProvider
{
    /**
     * @return \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface[]
     */
    protected function getProductDetailPageWidgetPlugins(): array
    {
        return [
            PriceWidgetPlugin::class,
            ProductCategoryWidgetPlugin::class,
            ProductImageWidgetPlugin::class,
            AvailabilityWidgetPlugin::class,
            ProductOptionWidgetPlugin::class,
            ProductAbstractLabelWidgetPlugin::class,
            WishlistWidgetPlugin::class,
            SimilarProductsWidgetPlugin::class,
            ProductCmsBlockWidgetPlugin::class,
            ProductReviewWidgetPlugin::class,
            ExampleProductColorGroupWidgetPlugin::class,
            ProductMeasurementUnitWidgetPlugin::class,
        ];
    }
}
