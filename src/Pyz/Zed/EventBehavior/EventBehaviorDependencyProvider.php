<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\EventBehavior;

use Spryker\Zed\AvailabilityStorage\Communication\Plugin\Event\AvailabilityEventResourceQueryContainerPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Event\CategoryPageEventResourceQueryContainerPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\CategoryNodeEventResourceQueryContainerPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\CategoryTreeEventResourceQueryContainerPlugin;
use Spryker\Zed\CmsBlockCategoryStorage\Communication\Plugin\Event\CmsBlockCategoryEventResourceQueryContainerPlugin;
use Spryker\Zed\CmsBlockProductStorage\Communication\Plugin\Event\CmsBlockProductEventResourceQueryContainerPlugin;
use Spryker\Zed\CmsBlockStorage\Communication\Plugin\Event\CmsBlockEventResourceQueryContainerPlugin;
use Spryker\Zed\CmsPageSearch\Communication\Plugin\Event\CmsPageEventResourceQueryContainerPlugin;
use Spryker\Zed\CmsStorage\Communication\Plugin\Event\CmsEventResourceQueryContainerPlugin;
use Spryker\Zed\EventBehavior\EventBehaviorDependencyProvider as SprykerEventBehaviorDependencyProvider;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Event\GlossaryEventResourceQueryContainerPlugin;
use Spryker\Zed\NavigationStorage\Communication\Plugin\Event\NavigationEventResourceQueryContainerPlugin;
use Spryker\Zed\PriceProductStorage\Communication\Plugin\Event\PriceProductAbstractEventResourceQueryContainerPlugin;
use Spryker\Zed\PriceProductStorage\Communication\Plugin\Event\PriceProductConcreteEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductCategoryFilterStorage\Communication\Plugin\Event\ProductCategoryFilterEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Event\ProductCategoryEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductGroupStorage\Communication\Plugin\Event\ProductGroupEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductImageStorage\Communication\Plugin\Event\ProductAbstractImageEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductImageStorage\Communication\Plugin\Event\ProductConcreteImageEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Event\ProductAbstractLabelEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Event\ProductLabelDictionaryEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductOptionStorage\Communication\Plugin\Event\ProductOptionEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Event\ProductPageEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductQuantityStorage\Communication\Plugin\Event\ProductQuantityEventResourceRepositoryPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Event\ProductRelationEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductReviewSearch\Communication\Plugin\Event\ProductReviewEventResourceQueryContainerPlugin as ProductReviewSearchEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductReviewStorage\Communication\Plugin\Event\ProductReviewEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductSearchConfigStorage\Communication\Plugin\Event\ProductSearchConfigEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductSetPageSearch\Communication\Plugin\Event\ProductSetEventResourceQueryContainerPlugin as ProductSetPageSearchEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductSetStorage\Communication\Plugin\Event\ProductSetEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductStorage\Communication\Plugin\Event\ProductAbstractEventResourceQueryContainerPlugin;
use Spryker\Zed\ProductStorage\Communication\Plugin\Event\ProductConcreteEventResourceQueryContainerPlugin;
use Spryker\Zed\UrlStorage\Communication\Plugin\Event\RedirectEventResourceQueryContainerPlugin;
use Spryker\Zed\UrlStorage\Communication\Plugin\Event\UrlEventResourceQueryContainerPlugin;

class EventBehaviorDependencyProvider extends SprykerEventBehaviorDependencyProvider
{
    /**
     * @return \Spryker\Zed\EventBehavior\Dependency\Plugin\EventResourcePluginInterface[]
     */
    protected function getEventTriggerResourcePlugins()
    {
        return [
            new CmsPageEventResourceQueryContainerPlugin(),
            new CategoryPageEventResourceQueryContainerPlugin(),
            new ProductPageEventResourceQueryContainerPlugin(),
            new ProductSetPageSearchEventResourceQueryContainerPlugin(),
            new ProductReviewSearchEventResourceQueryContainerPlugin(),
            new AvailabilityEventResourceQueryContainerPlugin(),
            new CategoryTreeEventResourceQueryContainerPlugin(),
            new CategoryNodeEventResourceQueryContainerPlugin(),
            new CmsBlockCategoryEventResourceQueryContainerPlugin(),
            new CmsBlockProductEventResourceQueryContainerPlugin(),
            new CmsBlockEventResourceQueryContainerPlugin(),
            new CmsEventResourceQueryContainerPlugin(),
            new GlossaryEventResourceQueryContainerPlugin(),
            new NavigationEventResourceQueryContainerPlugin(),
            new PriceProductConcreteEventResourceQueryContainerPlugin(),
            new PriceProductAbstractEventResourceQueryContainerPlugin(),
            new ProductCategoryFilterEventResourceQueryContainerPlugin(),
            new ProductCategoryEventResourceQueryContainerPlugin(),
            new ProductGroupEventResourceQueryContainerPlugin(),
            new ProductAbstractImageEventResourceQueryContainerPlugin(),
            new ProductConcreteImageEventResourceQueryContainerPlugin(),
            new ProductLabelDictionaryEventResourceQueryContainerPlugin(),
            new ProductAbstractLabelEventResourceQueryContainerPlugin(),
            new ProductOptionEventResourceQueryContainerPlugin(),
            new ProductRelationEventResourceQueryContainerPlugin(),
            new ProductReviewEventResourceQueryContainerPlugin(),
            new ProductSearchConfigEventResourceQueryContainerPlugin(),
            new ProductSetEventResourceQueryContainerPlugin(),
            new ProductAbstractEventResourceQueryContainerPlugin(),
            new ProductConcreteEventResourceQueryContainerPlugin(),
            new UrlEventResourceQueryContainerPlugin(),
            new RedirectEventResourceQueryContainerPlugin(),
            new ProductQuantityEventResourceRepositoryPlugin(),
        ];
    }
}
