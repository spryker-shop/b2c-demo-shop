<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductWidget;

use Pyz\Yves\ExampleProductColorGroupWidget\Plugin\ProductWidget\ExampleProductColorGroupWidgetPlugin;
use SprykerShop\Yves\ProductLabelWidget\Plugin\ProductWidget\ProductAbstractLabelWidgetPlugin;
use SprykerShop\Yves\ProductLabelWidget\Plugin\ProductWidget\ProductLabelWidgetPlugin;
use SprykerShop\Yves\ProductReviewWidget\Plugin\ProductWidget\ProductAbstractReviewWidgetPlugin;
use SprykerShop\Yves\ProductReviewWidget\Plugin\ProductWidget\ProductReviewWidgetPlugin;
use SprykerShop\Yves\ProductWidget\ProductWidgetDependencyProvider as SprykerProductWidgetDependencyProvider;

class ProductWidgetDependencyProvider extends SprykerProductWidgetDependencyProvider
{
    /**
     * Returns a list of widget plugin class names that implement \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface.
     *
     * @return string[]
     */
    protected function getProductRelationWidgetSubWidgetPlugins(): array
    {
        return [
            ProductAbstractLabelWidgetPlugin::class,
            ExampleProductColorGroupWidgetPlugin::class,
            ProductAbstractReviewWidgetPlugin::class,
        ];
    }

    /**
     * Returns a list of widget plugin class names that implement \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface.
     *
     * @return string[]
     */
    protected function getCatalogPageSubWidgetPlugins(): array
    {
        return [
            ProductLabelWidgetPlugin::class,
            ExampleProductColorGroupWidgetPlugin::class,
            ProductReviewWidgetPlugin::class,
        ];
    }

    /**
     * Returns a list of widget plugin class names that implement \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface.
     *
     * @return string[]
     */
    protected function getCmsContentWidgetProductSubWidgetPlugins(): array
    {
        return [
            ProductAbstractLabelWidgetPlugin::class,
            ProductAbstractReviewWidgetPlugin::class,
        ];
    }

    /**
     * Returns a list of widget plugin class names that implement \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface.
     *
     * @return string[]
     */
    protected function getCmsContentWidgetProductGroupSubWidgetPlugins(): array
    {
        return [
            ProductAbstractLabelWidgetPlugin::class,
            ExampleProductColorGroupWidgetPlugin::class,
            ProductAbstractReviewWidgetPlugin::class,
        ];
    }

    /**
     * Returns a list of widget plugin class names that implement \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface.
     *
     * @return string[]
     */
    protected function getHomePageSubWidgetPlugins(): array
    {
        return [
            ProductLabelWidgetPlugin::class,
            ExampleProductColorGroupWidgetPlugin::class,
            ProductReviewWidgetPlugin::class,
        ];
    }

    /**
     * Returns a list of widget plugin class names that implement \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface.
     *
     * @return string[]
     */
    protected function getProductReplacementForWidgetPlugins(): array
    {
        return [
            ProductAbstractLabelWidgetPlugin::class, #ProductAlternativeFeature
            ExampleProductColorGroupWidgetPlugin::class, #ProductAlternativeFeature
            ProductAbstractReviewWidgetPlugin::class, #ProductAlternativeFeature
        ];
    }

    /**
     * Returns a list of widget plugin class names that implement \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface.
     *
     * @return string[]
     */
    protected function getProductAlternativeWidgetPlugins(): array
    {
        return [
            ProductAbstractLabelWidgetPlugin::class, #ProductAlternativeFeature
            ExampleProductColorGroupWidgetPlugin::class, #ProductAlternativeFeature
            ProductAbstractReviewWidgetPlugin::class, #ProductAlternativeFeature
        ];
    }
}
