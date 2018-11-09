<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductPageSearch;

use Spryker\Shared\ProductLabelSearch\ProductLabelSearchConfig;
use Spryker\Shared\ProductReviewSearch\ProductReviewSearchConfig;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\PageDataExpander\ProductLabelDataExpanderPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\PageMapExpander\ProductLabelMapExpanderPlugin;
use Spryker\Zed\ProductPageSearch\ProductPageSearchDependencyProvider as SprykerProductPageSearchDependencyProvider;
use Spryker\Zed\ProductReviewSearch\Communication\Plugin\PageDataExpander\ProductReviewDataExpanderPlugin;
use Spryker\Zed\ProductReviewSearch\Communication\Plugin\PageMapExpander\ProductReviewMapExpanderPlugin;

class ProductPageSearchDependencyProvider extends SprykerProductPageSearchDependencyProvider
{
    const PLUGIN_PRODUCT_LABEL_DATA = 'PLUGIN_PRODUCT_LABEL_DATA';

    /**
     * @return \Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageMapExpanderInterface[]
     */
    protected function getDataExpanderPlugins()
    {
        $dataExpanderPlugins = parent::getDataExpanderPlugins();
        $dataExpanderPlugins[ProductLabelSearchConfig::PLUGIN_PRODUCT_LABEL_DATA] = new ProductLabelDataExpanderPlugin();
        $dataExpanderPlugins[ProductReviewSearchConfig::PLUGIN_PRODUCT_PAGE_RATING_DATA] = new ProductReviewDataExpanderPlugin();

        return $dataExpanderPlugins;
    }

    /**
     * @return \Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageMapExpanderInterface[]
     */
    protected function getMapExpanderPlugins()
    {
        $mapExpanderPlugins = parent::getMapExpanderPlugins();
        $mapExpanderPlugins[] = new ProductLabelMapExpanderPlugin();
        $mapExpanderPlugins[] = new ProductReviewMapExpanderPlugin();

        return $mapExpanderPlugins;
    }
}
